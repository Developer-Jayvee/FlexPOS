<?php

namespace Database\Seeders;

use App\Models\ORFormat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ORFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entry = ORFormat::create([
            'prefix' => 'OR',
            'has_date' => true,
            'date_format' => 'YY',
            'number_length' => 4
        ]);
    }
}
