<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForwardedEmail;
use App\Models\ParentEmail;
use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Mail\Attachment;
// use App\Http\Controllers\MailgunController;
use BeyondCode\Mailbox\Http\Controllers\MailgunController;

Route::get('/', function () {
    return view('welcome');
});

Route::post(
    'laravel-mailbox/mailgun/mime',
    MailgunController::class
);

// this collects the email and build into arrays to then go to forwardemail.php that constructs the forwarded emails.
// question: if emails are password protected then how does this work?

// Mailbox::from('{any}@sandbox8404ad9885484827b737ba4dcaf6007d.mailgun.org', function (InboundEmail $email) {
//     // $subject = $email->subject();
//     // $body = $email->text();

//     // $attachments = collect($email->attachments())->map(function ($attachment) {
//     //     return Attachment::fromPath($attachment->getPath())
//     //         ->as($attachment->getFilename())
//     //         ->withMime($attachment->getMimeType());
//     // })->toArray();

// add emails to be forwarded to 
// $recipients = ['test1@outlook.com', 'test2@outlook.com', 'test3@outlook.com'];
// foreach ($recipients as $recipient) {

//     $email->forward($recipient);

// }
// };
//forward
//     Mail::to($recipients)
//         ->send(new ForwardedEmail(subject: $subject, body: $body, attachments: $attachments));
// });

Mailbox::from('{any}@sandbox8404ad9885484827b737ba4dcaf6007d.mailgun.org', function (InboundEmail $email){
    $parentEmail = ParentEmail::where('email', $email->to())->firstOrFail();

    foreach ($parentEmail->childEmails as $childEmail) {
        $email->forward($childEmail->email);
    }
});

