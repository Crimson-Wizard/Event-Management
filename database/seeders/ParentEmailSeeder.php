<?php

namespace Database\Seeders;

use App\Models\ParentEmail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParentEmailSeeder extends Seeder
{
    
    public function run()
    {
        $parent = ParentEmail::create([
            'email' => 'crimsonwiz@sandbox8404ad9885484827b737ba4dcaf6007d.mailgun.org',
        ]);

        $parent->childEmails()->createMany([
            ['email' => 'mikelawlorarb@outlook.com'],
            ['email' => 'dukeofmetal@hotmail.com'],
            ['email' => 'mikelawlorarb+03@outlook.com'],
        ]);
    }
}
