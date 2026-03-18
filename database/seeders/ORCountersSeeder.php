<?php

namespace Database\Seeders;

use App\Models\ORCounters;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ORCountersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entry = ORCounters::create([
            'or_count' => 1,
            'format_id' => 1
        ]);
    }
}
