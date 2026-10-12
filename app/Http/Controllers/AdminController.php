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
        $query = Code::with(['assignedUser', 'usedByUser', 'claim'])->latest();

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
        $request->validate([
            'code' => ['required', 'string', 'regex:/^HB-\d{4}$/', 'unique:codes,code'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ], [
            'code.required' => 'Vul een code in.',
            'code.regex' => 'De code moet het formaat HB-XXXX hebben (bijv. HB-1234).',
            'code.unique' => 'Deze code bestaat al.',
        ]);

        $codeStr = strtoupper(trim($request->code));

        Code::create([
            'code' => $codeStr,
            'assigned_to' => $request->assigned_to ?: null,
            'used' => false,
        ]);

        return back()->with('success', 'Code ' . $codeStr . ' succesvol aangemaakt!');
    }

    public function deleteCode($id)
    {
        $code = Code::findOrFail($id);
        if ($code->used) {
            return back()->with('error', 'Een reeds gebruikte code kan niet worden verwijderd.');
        }

        $code->delete();
        return back()->with('success', 'Code verwijderd.');
    }
}
