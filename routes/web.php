<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\DB;
// use App\Models\ParentEmail;
// use App\Models\ChildEmail;
// use BeyondCode\Mailbox\Facades\Mailbox;
// use BeyondCode\Mailbox\InboundEmail;

Route::get('/', function () {
    return view('welcome');
});

// // Main inbound email forwarding logic
// // 

// Mailbox::from('{any}@sandbox8404ad9885484827b737ba4dcaf6007d.mailgun.org', function (InboundEmail $email) {

//     $from = $email->from()[0]->getEmail();
//     $to   = $email->to()[0]->getEmail();
//     $subject = $email->subject();

//     // save a row even if forwarding fails
//     DB::table('inbound_logs')->insert([
//         'from'       => $from,
//         'to'         => $to,
//         'subject'    => $subject,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ]);

//     Log::info('📩 Email received', compact('from','to','subject'));

//     // forward (remember: sandbox can only send to authorized recipients)
//     foreach (['dukeofmetal@outlook.com'] as $recipient) {
//         Log::info("Forwarding to: {$recipient}");
//         $email->forward($recipient);
//     }
// });
