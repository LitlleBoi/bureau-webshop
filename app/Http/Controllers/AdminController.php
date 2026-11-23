<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Code;
use App\Models\User;
use App\Models\Claim;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $productsCount = Product::count();
        $availableProductsCount = Product::where('available', true)->count();
        $codesCount = Code::count();
        $usedCodesCount = Code::where('used', true)->count();
        $usersCount = User::count();
        $claimsCount = Claim::count();

        $recentClaims = Claim::with(['user', 'product', 'code'])->latest()->take(10)->get();
        $recentCodes = Code::with(['assignedUser', 'usedByUser', 'claim'])->latest()->take(6)->get();
        $recentProducts = Product::latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'productsCount',
            'availableProductsCount',
            'codesCount',
            'usedCodesCount',
            'usersCount',
            'claimsCount',
            'recentClaims',
            'recentCodes',
            'recentProducts'
        ));
    }

    public function products()
    {
        $products = Product::latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name_nl' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'image' => 'required|url',
            'colors' => 'required|string',
            'sizes' => 'nullable|string',
            'tag' => 'nullable|string|max:50',
            'available' => 'nullable|boolean',
        ]);

        $colorsArray = array_values(array_filter(array_map('trim', explode(',', $validated['colors']))));
        $sizesArray = !empty($validated['sizes'])
            ? array_values(array_filter(array_map('trim', explode(',', $validated['sizes']))))
            : null;

        Product::create([
            'name' => $validated['name_nl'],
            'name_nl' => $validated['name_nl'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'image' => $validated['image'],
            'colors' => $colorsArray,
            'sizes' => $sizesArray,
            'tag' => $validated['tag'] ?? null,
            'available' => $request->has('available'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product succesvol aangemaakt!');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name_nl' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'image' => 'required|url',
            'colors' => 'required|string',
            'sizes' => 'nullable|string',
            'tag' => 'nullable|string|max:50',
        ]);

        $colorsArray = array_values(array_filter(array_map('trim', explode(',', $validated['colors']))));
        $sizesArray = !empty($validated['sizes'])
            ? array_values(array_filter(array_map('trim', explode(',', $validated['sizes']))))
            : null;

        $product->update([
            'name' => $validated['name_nl'],
            'name_nl' => $validated['name_nl'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'image' => $validated['image'],
            'colors' => $colorsArray,
            'sizes' => $sizesArray,
            'tag' => $validated['tag'] ?? null,
            'available' => $request->has('available'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product succesvol bijgewerkt!');
    }

    public function toggleAvailability($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['available' => !$product->available]);

        return back()->with('success', 'Status van ' . $product->name_nl . ' aangepast.');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product verwijderd.');
    }

    public function codes(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $query = Code::with(['assignedUser', 'usedByUser', 'claims'])->latest();

        if ($filter === 'used') {
            $query->where('used', true);
        } elseif ($filter === 'available') {
            $query->where('used', false);
        }

        $codes = $query->get();
        $employees = User::where('role', 'employee')->orderBy('name')->get();

        $totalCount = Code::count();
        $availableCount = Code::where('used', false)->count();
        $usedCount = Code::where('used', true)->count();

        return view('admin.codes.index', compact('codes', 'employees', 'filter', 'totalCount', 'availableCount', 'usedCount'));
    }

    public function storeCode(Request $request)
    {
        if (!$request->filled('code')) {
            $request->merge(['code' => Code::generateCode()]);
        }

        $request->validate([
            'code' => ['required', 'string', 'min:4', 'max:20', 'alpha_num', 'unique:codes,code'],
            'max_uses' => ['nullable', 'integer', 'min:1', 'max:100'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ], [
            'code.required' => 'Vul een code in.',
            'code.alpha_num' => 'De code mag alleen letters en cijfers bevatten.',
            'code.unique' => 'Deze code bestaat al.',
            'max_uses.min' => 'Een code moet minimaal 1 product opleveren.',
            'max_uses.max' => 'Een code kan maximaal 100 producten opleveren.',
        ]);

        $codeStr = strtoupper(trim($request->code));
        $maxUses = (int) ($request->max_uses ?: 1);

        Code::create([
            'code' => $codeStr,
            'max_uses' => $maxUses,
            'assigned_to' => $request->assigned_to ?: null,
            'used' => false,
        ]);

        $suffix = $maxUses === 1 ? '1 product' : "{$maxUses} producten";
        return back()->with('success', "Code {$codeStr} succesvol aangemaakt (geldig voor {$suffix})!");
    }

    public function storeBulkCodes(Request $request)
    {
        $validated = $request->validate([
            'amount' => ['required', 'integer', 'min:1', 'max:100'],
            'max_uses' => ['nullable', 'integer', 'min:1', 'max:100'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ], [
            'amount.required' => 'Geef aan hoeveel codes je wilt genereren.',
            'amount.integer' => 'Aantal moet een geldig getal zijn.',
            'amount.min' => 'Je moet minimaal 1 code genereren.',
            'amount.max' => 'Je kunt maximaal 100 codes tegelijk genereren.',
            'max_uses.min' => 'Een code moet minimaal 1 product opleveren.',
            'max_uses.max' => 'Een code kan maximaal 100 producten opleveren.',
        ]);

        $amount = (int) $validated['amount'];
        $maxUses = max(1, (int) ($validated['max_uses'] ?? 1));
        $assignedTo = ($validated['assigned_to'] ?? null) ?: null;
        $createdCodes = [];

        for ($i = 0; $i < $amount; $i++) {
            $codeStr = Code::generateCode();
            $code = Code::create([
                'code' => $codeStr,
                'max_uses' => $maxUses,
                'assigned_to' => $assignedTo,
                'used' => false,
            ]);
            $createdCodes[] = $code->code;
        }

        $perCode = $maxUses === 1 ? '1 product' : "{$maxUses} producten";
        $msg = $amount === 1
            ? "1 nieuwe willekeurige code succesvol gegenereerd (geldig voor {$perCode})!"
            : "{$amount} nieuwe willekeurige codes succesvol in één keer gegenereerd (elk geldig voor {$perCode})!";

        return back()->with([
            'success' => $msg,
            'generated_codes' => $createdCodes,
        ]);
    }

    public function deleteCode($id)
    {
        $code = Code::findOrFail($id);
        if ($code->used || $code->uses_count > 0) {
            return back()->with('error', 'Een (deels) gebruikte code kan niet worden verwijderd.');
        }

        $code->delete();
        return back()->with('success', 'Code verwijderd.');
    }
}
