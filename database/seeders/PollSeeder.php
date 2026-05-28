<?php

namespace Database\Seeders;

use App\Models\Poll;
use Illuminate\Database\Seeder;

class PollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Poll::updateOrCreate(
            ['id' => 1],
            [
                'question' => 'Apakah Anda setuju dengan kebijakan pemerintah untuk mempercepat penutupan PLTU Batubara demi transisi energi hijau?',
                'opt1' => 'Sangat Setuju',
                'opt2' => 'Cukup Setuju',
                'opt3' => 'Kurang Setuju',
                'opt4' => 'Tidak Setuju',
                'is_active' => true,
            ]
        );
    }
}
