<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $subject = $request->input('subject', 'Vraag via contactformulier');
        $userMsg = $request->input('message');

        $fullSubject = "[Het BUREAU] {$subject} - {$name}";
        $body = "Beste HR-afdeling van Het BUREAU,\n\n{$userMsg}\n\n---\nVerzonden via het contactformulier van Het BUREAU Webshop\nNaam: {$name}\nE-mailadres: {$email}";

        $mailtoUrl = 'mailto:hr@hetbureau.nl?subject=' . rawurlencode($fullSubject) . '&body=' . rawurlencode($body);
        $outlookWebUrl = 'https://outlook.office.com/mail/deeplink/compose?to=hr@hetbureau.nl&subject=' . rawurlencode($fullSubject) . '&body=' . rawurlencode($body);
        $outlookLiveUrl = 'https://outlook.live.com/mail/0/deeplink/compose?to=hr@hetbureau.nl&subject=' . rawurlencode($fullSubject) . '&body=' . rawurlencode($body);

        return back()->with([
            'success' => 'Je bericht is klaargezet! We openen Outlook voor je.',
            'mailto' => $mailtoUrl,
            'outlookWeb' => $outlookWebUrl,
            'outlookLive' => $outlookLiveUrl,
            'recipient' => 'hr@hetbureau.nl',
            'emailSubject' => $fullSubject,
            'emailBody' => $body,
        ]);
    }
}
