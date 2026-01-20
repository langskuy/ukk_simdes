<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected $databaseUrl;

    public function __construct()
    {
        $this->databaseUrl = rtrim(env('FIREBASE_DATABASE_URL'), '/');
    }

    /**
     * Push a notification and activity log to Firebase Realtime Database
     */
    public function pushNotification($type, $data)
    {
        try {
            $database = app('firebase.database');

            // 1. Push notification (for mobile/alerts)
            $database->getReference('notifications/' . $type)->push([
                'title' => $data['title'] ?? 'Notifikasi Baru',
                'message' => $data['message'] ?? '',
                'sender' => $data['sender'] ?? 'Sistem',
                'timestamp' => now()->toIso8601String(),
                'is_read' => false,
                'id' => $data['id'] ?? uniqid()
            ]);

            // 2. Also push to activities for the dashboard list
            $database->getReference('activities')->push([
                'userName' => $data['sender'] ?? 'Sistem',
                'type' => $type === 'surat' ? 'permohonan' : ($type === 'pengaduan' ? 'laporan' : $type),
                'description' => $data['message'] ?? '',
                'createdAt' => now()->toIso8601String(),
            ]);

            // 3. Increment counters for realtime badges
            $counterPath = $type === 'surat' ? 'counters/surat_new' : ($type === 'pengaduan' ? 'counters/pengaduan_new' : null);
            if ($counterPath) {
                $ref = $database->getReference($counterPath);
                $value = $ref->getValue() ?? 0;
                $ref->set($value + 1);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Firebase Push Failed: ' . $e->getMessage());
            return false;
        }
    }
}
