<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use App\Models\ParentEmail;


Log::info('✅ mailbox.php loaded');

Mailbox::catchAll(function (BeyondCode\Mailbox\InboundEmail $email) {
    try {
        // Safely extract Message-ID from ZBateson header
        $mid = null;
        try {
            $h = $email->message()->getHeader('Message-ID'); // returns a header object or null
            if ($h) {
                if (method_exists($h, 'getValue')) {
                    $mid = $h->getValue();      // preferred
                } elseif (method_exists($h, 'getId')) {
                    $mid = $h->getId();         // fallback some versions expose
                } else {
                    $mid = (string) $h;         // last-resort: cast to string
                }
            }
        } catch (\Throwable $e) {
            // ignore; we'll fall back below
        }

            if (empty($mid)) {
                $mid = (string) \Illuminate\Support\Str::uuid();
            }

        // Save to inbound_logs table
        DB::table('inbound_logs')->insert([
            'message_id' => $mid,
            'message'    => $email->text(),  // or $email->html()
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Determine the "To" address (parent email)
        $toAddresses = $email->to(); // returns array of Address objects
        $toEmail = null;
        if (!empty($toAddresses) && isset($toAddresses[0])) {
            $toEmail = method_exists($toAddresses[0], 'getEmail') ? $toAddresses[0]->getEmail() : null;
        }

        if (!$toEmail) {
            Log::warning('⚠ No "To" address found, skipping forward');
            return;
        }

        // Lookup parent email record
        $parent = ParentEmail::where('email', $toEmail)->first();
        if (!$parent) {
            Log::warning("⚠ No parent email found for {$toEmail}");
            return;
        }

        // Forward to all children of the parent
        foreach ($parent->childEmails as $child) {
            Mail::raw($email->text(), function ($message) use ($child, $email) {
                $message->to($child->email)
                        ->subject($email->subject() ?? '(no subject)');
            });
        }

        Log::info("📨 Forwarded email from {$toEmail} to children of parent ID {$parent->id}");

    } catch (\Throwable $e) {
        Log::error('❌ Error processing email', [
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString()
        ]);
    }
});