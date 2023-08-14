<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Calendar;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $calendar = Calendar::factory()->create();

        $response = $this->actingAs($user)->get('/api/v1/calendars/' . $calendar->id);

        $response->assertStatus(200);
        $response->assertJsonFragment($calendar->toArray());
    }


    public function test_can_update_calendar(): void
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create();

        $updatedData = [
            'date' => '2022-09-01',
        ];

        $response = $this->actingAs($user)->put('/api/v1/calendars/' . $calendar->id, $updatedData);

        $response->assertStatus(200);
        $response->assertJsonFragment($updatedData);
    }

    public function test_can_delete_calendar(): void
    {
        $user = User::factory()->create();
        $calendar = Calendar::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete('/api/v1/calendars/' . $calendar->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('calendars', ['id' => $calendar->id]);
    }

}
