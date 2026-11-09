<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:10000',
        ]);

        if (in_array(config('mail.default'), ['log', 'array'], true)) {
            return back()
                ->withInput()
                ->with('error', 'E-mail verzenden is nog niet ingesteld. Configureer eerst een SMTP-mailserver.');
        }

        $subject = $validated['subject'] ?: 'Bericht via het contactformulier';
        $body = "Nieuw bericht via het contactformulier\n\n"
            ."Naam: {$validated['name']}\n"
            ."E-mailadres: {$validated['email']}\n"
            ."Onderwerp: {$subject}\n\n"
            ."Bericht:\n{$validated['message']}";

        try {
            Mail::raw($body, function ($mail) use ($validated, $subject) {
                $mail->to('hr@hetbureau.nl')
                    ->replyTo($validated['email'], $validated['name'])
                    ->subject($subject);
            });
        } catch (TransportExceptionInterface $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Je bericht kon niet worden verzonden. Probeer het later opnieuw.');
        }

        return back()->with('success', 'Bedankt voor je bericht! We nemen zo spoedig mogelijk contact met je op.');
    }
}
