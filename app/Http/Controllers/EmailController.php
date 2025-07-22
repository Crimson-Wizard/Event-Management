<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\User;
// use App\Models\Event;

class EmailController extends Controller
{
    public function sendReminder()
    {
    $user = \App\Models\User::first();
    $event = \App\Models\Event::first();

            if (!$user || !$event) {
                return response()->json(['error' => 'User or Event not found'], 404);
            }   

        $user->notify(new \App\Notifications\EventReminderNotification($event));

        return response()->json(['message' => 'Reminder sent!']);
}
}
