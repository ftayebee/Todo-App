<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Task;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_get_task_list()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum'); // Authenticate first

        Task::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                ->assertJsonCount(3, 'tasks'); // Include 'tasks' path
    }

    public function test_user_can_create_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/tasks/store', [
            'title' => 'New Task',
            'description' => 'This is Test Description From Feature/TaskApiTest',
            'is_completed' => false,
        ]);

        $response->assertStatus(201)
         ->assertJsonStructure(['task' => ['id', 'title', 'is_completed', 'description']]);
    }

    public function test_user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson("/api/tasks/update/{$task->id}", [
            'title' => 'Updated Task',
            'is_completed' => true,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Task updated successfully.']);
    }

    public function test_user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson("/api/tasks/destroy/{$task->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Task deleted successfully.']);
    }
}
