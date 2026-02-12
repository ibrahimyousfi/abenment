<?php

namespace Tests\Feature;

use App\Models\Gym;
use App\Models\User;
use App\Models\TrainingType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopbarIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_index_has_topbar()
    {
        $gym = Gym::factory()->create();
        $user = User::factory()->create(['gym_id' => $gym->id]);

        $response = $this->actingAs($user)->get(route('members.index'));

        $response->assertStatus(200);
        $response->assertSee('name="search"', false);
        $response->assertSee('placeholder="ابحث عن مشترك..."', false);
        $response->assertSee(route('members.create'));
    }

    public function test_training_types_index_has_topbar()
    {
        $gym = Gym::factory()->create();
        $user = User::factory()->create(['gym_id' => $gym->id]);

        $response = $this->actingAs($user)->get(route('training-types.index'));

        $response->assertStatus(200);
        $response->assertSee('name="search"', false);
        $response->assertSee('placeholder="ابحث عن نوع تمرين..."', false);
        $response->assertSee(route('training-types.create'));
    }

    public function test_training_types_show_has_topbar_for_plans()
    {
        $gym = Gym::factory()->create();
        $user = User::factory()->create(['gym_id' => $gym->id]);
        $trainingType = TrainingType::factory()->create(['gym_id' => $gym->id]);

        $response = $this->actingAs($user)->get(route('training-types.show', $trainingType));

        $response->assertStatus(200);
        $response->assertSee('name="search"', false);
        $response->assertSee('placeholder="ابحث عن خطة..."', false);
        // We check if the route is generated correctly in the href
        $expectedUrl = route('plans.create', ['training_type_id' => $trainingType->id]);
        $response->assertSee($expectedUrl);
    }
}
