<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use RuntimeException;

class DemoUserPasswordSeeder extends Seeder
{
    public function run()
    {
        $plainPassword = env('TSA_DEMO_PASSWORD');

        if (! is_string($plainPassword) || strlen($plainPassword) < 12) {
            throw new RuntimeException('Set TSA_DEMO_PASSWORD to at least 12 characters in .env before seeding.');
        }

        $users = new UserModel();
        $demoUser = $users->where('username', 'gabsaulo')->first();

        if ($demoUser === null) {
            throw new RuntimeException('Import database/tms_tsa1.sql before seeding the demo user.');
        }

        $users->update((int) $demoUser['id'], [
            'password' => password_hash($plainPassword, PASSWORD_DEFAULT),
        ]);
    }
}
