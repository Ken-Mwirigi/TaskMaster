<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    // CREATE TASK TESTS
     

    public function test_can_create_task()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Task',
            'due_date' => now()->toDateString(),
            'priority' => 'high'
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task'
        ]);
    }

    public function test_cannot_create_duplicate_task()
    {
        Task::create([
            'title' => 'Duplicate Task',
            'due_date' => now()->toDateString(),
            'priority' => 'high',
            'status' => 'pending'
        ]);

        $response = $this->postJson('/api/tasks', [
            'title' => 'Duplicate Task',
            'due_date' => now()->toDateString(),
            'priority' => 'high'
        ]);

        $response->assertStatus(422);
    }

    public function test_due_date_must_not_be_past()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Old Task',
            'due_date' => '2020-01-01',
            'priority' => 'low'
        ]);

        $response->assertStatus(422);
    }

    public function test_priority_must_be_valid()
    {
        $response = $this->postJson('/api/tasks', [
            'title' => 'Invalid Priority',
            'due_date' => now()->toDateString(),
            'priority' => 'urgent'
        ]);

        $response->assertStatus(422);
    }


     // LIST TASKS TESTS
     

    public function test_can_list_tasks()
    {
        Task::factory()->create(['priority' => 'low']);
        Task::factory()->create(['priority' => 'high']);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);
    }

    public function test_can_filter_tasks_by_status()
    {
        Task::factory()->create(['status' => 'pending']);
        Task::factory()->create(['status' => 'done']);

        $response = $this->getJson('/api/tasks?status=pending');

        $response->assertStatus(200);
    }

    public function test_invalid_status_filter_returns_error()
    {
        $response = $this->getJson('/api/tasks?status=invalid');

        $response->assertStatus(422);
    }

    
     // STATUS UPDATE TESTS
    

    public function test_status_progression()
    {
        $task = Task::factory()->create(['status' => 'pending']);

        // Test: pending -> in_progress (We must pass the status in the array)
        $this->patchJson("/api/tasks/{$task->id}/status", ['status' => 'in_progress'])
             ->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'in_progress'
        ]);

        // Test: in_progress -> done
        $this->patchJson("/api/tasks/{$task->id}/status", ['status' => 'done'])
             ->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'done'
        ]);
    }

    public function test_cannot_progress_past_done()
    {
        $task = Task::factory()->create(['status' => 'done']);

        // Trying to move a 'done' task to anything else should trigger our logic error
        $response = $this->patchJson("/api/tasks/{$task->id}/status", ['status' => 'in_progress']);

        $response->assertStatus(422);
    }
    
     // DELETE TASK TESTS
    

    public function test_cannot_delete_non_done_task()
    {
        $task = Task::factory()->create(['status' => 'pending']);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(403);
    }

    public function test_can_delete_done_task()
    {
        $task = Task::factory()->create(['status' => 'done']);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    
     // DAILY REPORT TEST
     

    public function test_daily_report()
    {
        Task::factory()->create([
            'priority' => 'high',
            'status' => 'pending',
            'due_date' => now()->toDateString()
        ]);

        $response = $this->getJson('/api/tasks/report?date=' . now()->toDateString());

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'date',
                     'summary' => [
                         'high' => ['pending','in_progress','done'],
                         'medium',
                         'low'
                     ]
                 ]);
    }
}