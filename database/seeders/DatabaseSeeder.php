<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $yuzu = User::factory()->create([
            'name' => 'Yuzu',
            'email' => 'yuzu@example.com',
            'password' => bcrypt('password'),
        ]);

        $cece = User::factory()->create([
            'name' => 'Cece',
            'email' => 'cece@example.com',
            'password' => bcrypt('password'),
        ]);

        $users = [$yuzu, $cece];
        $courses = ['Matematika Diskret', 'Algoritma Pemrograman', 'Basis Data', 'Rekayasa Perangkat Lunak', 'Jaringan Komputer'];

        foreach ($users as $user) {
            for ($i = 1; $i <= 10; $i++) {
                $task = $user->tasks()->create([
                    'title' => 'Tugas ' . $i . ' untuk ' . $user->name,
                    'description' => 'Ini adalah deskripsi tugas otomatis untuk keperluan testing QA.',
                    'course' => $courses[array_rand($courses)],
                    'deadline' => now()->addDays(rand(-2, 10))->addHours(rand(1, 12)),
                    'priority' => rand(1, 3), // 1: Tinggi, 2: Menengah, 3: Rendah
                    'status' => rand(1, 4) === 1 ? 'completed' : 'pending',
                ]);

                // Create 2-4 subtasks
                for ($j = 1; $j <= rand(2, 4); $j++) {
                    $task->subtasks()->create([
                        'title' => 'Sub-tugas ' . $j,
                        'is_completed' => rand(0, 1) == 1,
                    ]);
                }
            }
        }
    }
}
