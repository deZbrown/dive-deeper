<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_calendars(): void
    {
        $user = User::factory()->create();
        Calendar::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/calendars');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    public function test_can_create_calendar(): void
    {
        $user = User::factory()->create();

        $calendarData = [
            'date' => '2022-08-01',
        ];

        $response = $this->actingAs($user)->post('/api/v1/calendars', $calendarData);

        $response->assertStatus(201);
        $response->assertJsonFragment($calendarData);
    }

    public function test_can_show_calendar(): void
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/api/v1/calendars/'.$calendar->id);

        $response->assertStatus(200);
        $response->assertJsonFragment($calendar->toArray());
    }

    public function test_can_update_calendar(): void
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create(['user_id' => $user->id]);

        $updatedData = [
            'date' => '2022-09-01',
        ];

        $response = $this->actingAs($user)->put('/api/v1/calendars/'.$calendar->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updatedData);
    }

    public function test_can_delete_calendar(): void
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/api/v1/calendars/'.$calendar->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('calendars', ['id' => $calendar->id]);
    }

    public function testCanViewOwnCalendar(): void
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->getJson("/api/v1/calendars/{$calendar->id}")
            ->assertStatus(200)
            ->assertJson(['id' => $calendar->id]);
    }

    public function testCannotViewOthersCalendar(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $calendar = Calendar::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($user)
            ->getJson("/api/v1/calendars/{$calendar->id}")
            ->assertStatus(403);
    }

    public function testCanUpdateOwnCalendar(): void
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'name' => 'Updated Name',
            'date' => '2023-08-15',
        ];

        $this->actingAs($user)
            ->putJson("/api/v1/calendars/{$calendar->id}", $updateData)
            ->assertStatus(200);
    }

    public function testCanDeleteOwnCalendar(): void
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->deleteJson("/api/v1/calendars/{$calendar->id}")
            ->assertStatus(204);
    }
}
