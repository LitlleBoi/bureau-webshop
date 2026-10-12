<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Code;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart_item');
        $product = null;

        if ($cart && isset($cart['product_id'])) {
            $product = Product::find($cart['product_id']);
        }

        return view('cart.index', compact('cart', 'product'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'color' => ['required', 'string'],
            'size' => ['nullable', 'string'],
        ]);

        session()->put('cart_item', [
            'product_id' => $validated['product_id'],
            'color' => $validated['color'],
            'size' => $validated['size'] ?? null,
        ]);

        return redirect()->route('cart.index')->with('success', 'Product toegevoegd aan je winkelwagen!');
    }

    public function remove()
    {
        session()->forget('cart_item');
        return redirect()->route('cart.index')->with('info', 'Winkelwagen leeggemaakt.');
    }

    public function claim(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Log eerst in om je medewerkerscode te gebruiken.');
        }

        $user = Auth::user();

        if ($user->code_used) {
            return back()->with('error', 'Je hebt al eerder een product geclaimd met jouw medewerkerscode.');
        }

        $cart = session()->get('cart_item');
        if (!$cart || !isset($cart['product_id'])) {
            return back()->with('error', 'Je winkelwagen is leeg. Kies eerst een product.');
        }

        $product = Product::findOrFail($cart['product_id']);
        if (!$product->available) {
            return back()->with('error', 'Dit product is momenteel helaas niet beschikbaar.');
        }

        $request->validate([
            'code' => ['required', 'string'],
        ], [
            'code.required' => 'Vul je persoonlijke medewerkerscode in.',
        ]);

        $codeStr = strtoupper(trim($request->code));
        $code = Code::where('code', $codeStr)->first();

        if (!$code) {
            return back()->with('error', 'Ongeldige code. Controleer je code en probeer opnieuw.');
        }

        if ($code->used) {
            return back()->with('error', 'Deze code is al gebruikt.');
        }

        if ($code->assigned_to && $code->assigned_to !== $user->id) {
            return back()->with('error', 'Deze persoonlijke code is niet aan jouw account gekoppeld.');
        }

        // Transactie: claim aanmaken, code markeren, user markeren
        $claim = Claim::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'product_id' => $product->id,
            'product_name' => $product->name_nl,
            'code_id' => $code->id,
            'code_value' => $code->code,
            'color' => $cart['color'] ?? 'Standaard',
            'size' => $cart['size'] ?? null,
            'status' => 'claimed',
        ]);

        $code->update([
            'used' => true,
            'used_by' => $user->id,
            'used_at' => now(),
        ]);

        $user->update([
            'code_used' => true,
        ]);

        session()->forget('cart_item');

        return redirect()->route('cart.success', $claim->id);
    }

    public function success($claimId)
    {
        $claim = Claim::with(['product'])->findOrFail($claimId);

        // Alleen de eigenaar of admin mag deze bevestiging zien
        if (Auth::id() !== $claim->user_id && (!Auth::check() || !Auth::user()->isAdmin())) {
            abort(403);
        }

        return view('cart.success', compact('claim'));
    }
}
