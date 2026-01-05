<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // This migration should add extra columns to the existing `users` table
        // instead of creating it (the users table is created by the base migration).
        if (! Schema::hasTable('users')) {
            // If for some reason the users table does not exist, create a minimal
            // version so the rest of the app can work. Preferably base migration
            // creates the table and this branch will not run.
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamp('email_verified_at')->nullable();
                $table->string('email')->unique();
                $table->string('password');
                $table->enum('role', ['admin', 'warga'])->default('warga');
                $table->rememberToken();
                $table->timestamps();
            });
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            // Add optional profile fields if they don't already exist
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->after('name');
            }

            if (! Schema::hasColumn('users', 'nik')) {
                $table->string('nik')->nullable()->after('username');
            }

            if (! Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('nik');
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'warga'])->default('warga')->after('password');
            }
            // Add email_verified_at if missing (some seeders expect it)
            if (! Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the columns we added if they exist
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }

            if (Schema::hasColumn('users', 'nik')) {
                $table->dropColumn('nik');
            }

            if (Schema::hasColumn('users', 'no_hp')) {
                $table->dropColumn('no_hp');
            }

            // We don't usually drop `role` here because it likely existed before,
            // but if this migration created it we can attempt to drop it.
            if (Schema::hasColumn('users', 'role')) {
                // Some DB drivers have issues dropping enum columns; attempt drop.
                try {
                    $table->dropColumn('role');
                } catch (\Exception $e) {
                    // ignore: some drivers cannot drop enum easily in down()
                }
            }
            if (Schema::hasColumn('users', 'email_verified_at')) {
                try {
                    $table->dropColumn('email_verified_at');
                } catch (\Exception $e) {
                    // ignore if DB can't drop timestamp column in this context
                }
            }
        });
    }
};
