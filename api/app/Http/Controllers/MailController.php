<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function testMail()
    {
        Mail::raw('This is a test email using Mailtrap.', function ($message) {
            $message->to('jemsbond1109@mailinator.com')
                    ->subject('Test Email');
        });

        return response()->json(['message' => 'Test email sent!']);
    }
}
