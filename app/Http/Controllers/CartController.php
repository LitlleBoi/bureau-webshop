<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Code;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /** Maximaal aantal producten in de winkelwagen (gelijk aan max. producten per code). */
    public const MAX_ITEMS = 100;

    /**
     * Haalt de winkelwagen (lijst met items) uit de sessie.
     * Zet een oude winkelwagen met één item ('cart_item') om naar de nieuwe lijst.
     */
    public static function items(): array
    {
        $items = session()->get('cart_items', []);

        if (session()->has('cart_item')) {
            $old = session()->pull('cart_item');
            if (!empty($old['product_id'])) {
                $items[] = $old;
            }
            session()->put('cart_items', $items);
        }

        return array_values($items);
    }

    public function index()
    {
        $items = self::items();
        $products = Product::whereIn('id', array_column($items, 'product_id'))->get()->keyBy('id');

        // Items waarvan het product niet meer bestaat weglaten
        $cartItems = [];
        foreach ($items as $index => $item) {
            if ($product = $products->get($item['product_id'])) {
                $cartItems[] = ['index' => $index, 'item' => $item, 'product' => $product];
            }
        }

        $assignedCode = Auth::check() ? Auth::user()->assignedCode : null;

        return view('cart.index', compact('cartItems', 'assignedCode'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'color' => ['required', 'string'],
            'size' => ['nullable', 'string'],
        ]);

        $items = self::items();
        if (count($items) >= self::MAX_ITEMS) {
            return back()->with('error', 'Je winkelwagen zit vol.');
        }

        $items[] = [
            'product_id' => (int) $validated['product_id'],
            'color' => $validated['color'],
            'size' => $validated['size'] ?? null,
        ];
        session()->put('cart_items', $items);

        $product = Product::find($validated['product_id']);
        $msg = ($product->name_nl ?? 'Product') . ' is toegevoegd aan je winkelwagen! (' . count($items) . ' ' . (count($items) === 1 ? 'item' : 'items') . ')';

        // Vanuit het productoverzicht: op dezelfde pagina blijven
        if ($request->boolean('stay')) {
            return back()->with('success', $msg);
        }

        return redirect()->route('cart.index')->with('success', $msg);
    }

    public function remove(Request $request)
    {
        // Zonder index: hele winkelwagen leegmaken
        if (!$request->filled('index')) {
            session()->forget('cart_items');
            return redirect()->route('cart.index')->with('info', 'Winkelwagen leeggemaakt.');
        }

        $items = self::items();
        $index = (int) $request->index;
        if (isset($items[$index])) {
            unset($items[$index]);
            session()->put('cart_items', array_values($items));
        }

        return redirect()->route('cart.index')->with('info', 'Product verwijderd uit je winkelwagen.');
    }

    public function claim(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Log eerst in om je medewerkerscode te gebruiken.');
        }

        $user = Auth::user();

        $items = self::items();
        if (empty($items)) {
            return back()->with('error', 'Je winkelwagen is leeg. Kies eerst een product.');
        }

        $products = Product::whereIn('id', array_column($items, 'product_id'))->get()->keyBy('id');
        foreach ($items as $item) {
            $product = $products->get($item['product_id']);
            if (!$product) {
                return back()->with('error', 'Een product in je winkelwagen bestaat niet meer. Verwijder het en probeer opnieuw.');
            }
            if (!$product->available) {
                return back()->with('error', $product->name_nl . ' is momenteel helaas niet beschikbaar. Verwijder het uit je winkelwagen.');
            }
        }

        $request->validate([
            'code' => ['required', 'string'],
        ], [
            'code.required' => 'Vul je persoonlijke medewerkerscode in.',
        ]);

        $codeStr = strtoupper(trim($request->code));
        $count = count($items);

        // Transactie + lock: voorkomt dat een code vaker gebruikt wordt dan toegestaan
        $result = DB::transaction(function () use ($codeStr, $user, $items, $products, $count) {
            $code = Code::where('code', $codeStr)->lockForUpdate()->first();

            if (!$code) {
                return 'Ongeldige code. Controleer je code en probeer opnieuw.';
            }

            if ($code->assigned_to && $code->assigned_to !== $user->id) {
                return 'Deze persoonlijke code is niet aan jouw account gekoppeld.';
            }

            $remaining = $code->used ? 0 : $code->remainingUses();
            if ($remaining <= 0) {
                return 'Deze code is al volledig gebruikt.';
            }

            if ($count > $remaining) {
                $teVeel = $count - $remaining;
                return "Je hebt {$count} producten in je winkelwagen, maar deze code is nog maar geldig voor {$remaining} "
                    . ($remaining === 1 ? 'product' : 'producten')
                    . ". Verwijder {$teVeel} " . ($teVeel === 1 ? 'product' : 'producten') . ' uit je winkelwagen.';
            }

            $claimIds = [];
            foreach ($items as $item) {
                $product = $products->get($item['product_id']);
                $claimIds[] = Claim::create([
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'product_id' => $product->id,
                    'product_name' => $product->name_nl,
                    'code_id' => $code->id,
                    'code_value' => $code->code,
                    'color' => $item['color'] ?? 'Standaard',
                    'size' => $item['size'] ?? null,
                    'status' => 'claimed',
                ])->id;
            }

            $usesCount = $code->uses_count + $count;
            $code->update([
                'uses_count' => $usesCount,
                'used' => $usesCount >= $code->max_uses,
                'used_by' => $user->id,
                'used_at' => now(),
            ]);

            return $claimIds;
        });

        if (is_string($result)) {
            return back()->with('error', $result)->withInput();
        }

        session()->forget('cart_items');
        session()->put('last_claim_ids', $result);

        return redirect()->route('cart.success', $result[0]);
    }

    public function success($claimId)
    {
        $claim = Claim::with(['product', 'code'])->findOrFail($claimId);

        // Alleen de eigenaar of admin mag deze bevestiging zien
        if (Auth::id() !== $claim->user_id && (!Auth::check() || !Auth::user()->isAdmin())) {
            abort(403);
        }

        // Alle producten van dezelfde bestelling tonen
        $ids = session()->get('last_claim_ids', []);
        $claims = in_array((int) $claimId, $ids, true)
            ? Claim::with('product')->whereIn('id', $ids)->where('user_id', $claim->user_id)->get()
            : collect([$claim]);

        return view('cart.success', compact('claim', 'claims'));
    }
}
