<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('account');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Vul je e-mailadres in.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'password.required' => 'Vul je wachtwoord in.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('account'))->with('success', 'Welkom terug, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'De opgegeven inloggegevens zijn onjuist.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('account');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'Vul je naam in.',
            'email.required' => 'Vul je werk-e-mailadres in.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'password.required' => 'Kies een wachtwoord.',
            'password.min' => 'Wachtwoord moet minimaal 6 tekens bevatten.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employee',
            'code_used' => false,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('account')->with('success', 'Account aangemaakt! Welkom bij Het BUREAU.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Je bent succesvol uitgelogd.');
    }

    public function account()
    {
        $user = Auth::user();
        $code = $user->assignedCode;
        $claims = $user->claims()->latest()->get();

        return view('account.index', compact('user', 'code', 'claims'));
    }

    public function updateAccount(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Gegevens succesvol opgeslagen.');
    }
}
