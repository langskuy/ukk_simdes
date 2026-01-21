<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class LogAuthActivity
{
    /**
     * Create the event listener.
     */
    public function __construct(public Request $request)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {
        $user = $event->user;
        $ip = $this->request->ip();
        $userAgent = $this->request->userAgent();

        $type = 'unknown';
        $description = '';

        if ($event instanceof Login) {
            $type = 'login';
            $description = "User {$user->name} logged in.";
        } elseif ($event instanceof Logout) {
            $type = 'logout';
            $description = "User {$user->name} logged out.";
        }

        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'activity_type' => $type,
                'description' => $description,
                'ip_address' => $ip,
                'user_agent' => $userAgent,
            ]);
        }
    }
}
