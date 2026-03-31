<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data to start fresh
        Task::truncate();

        $today = Carbon::today();

        // Tasks to test Sorting (High -> Medium -> Low) and Due Date
        Task::create([
            'title' => 'Finalize Wiriq Tech Deployment',
            'due_date' => $today->copy()->addDays(1),
            'priority' => 'high',
            'status' => 'pending',
        ]);

        Task::create([
            'title' => 'Update PangaRent Database Schema',
            'due_date' => $today->copy()->addDays(2),
            'priority' => 'medium',
            'status' => 'in_progress',
        ]);

        Task::create([
            'title' => 'Review Documentation',
            'due_date' => $today->copy()->addDays(3),
            'priority' => 'low',
            'status' => 'done',
        ]);

        // Tasks on the same date with different priorities to test secondary sorting
        Task::create([
            'title' => 'Server Maintenance',
            'due_date' => $today->copy()->addDays(1),
            'priority' => 'medium',
            'status' => 'pending',
        ]);

        Task::create([
            'title' => 'Security Audit',
            'due_date' => $today->copy()->addDays(1),
            'priority' => 'high',
            'status' => 'in_progress',
        ]);

        // Task to test the Delete rule (only 'done' can be deleted)
        Task::create([
            'title' => 'Initial Project Setup',
            'due_date' => $today,
            'priority' => 'high',
            'status' => 'done',
        ]);
    }
}