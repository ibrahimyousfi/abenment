<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Plan;
use App\Models\TrainingType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionCalculationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $bodybuilding;
    protected $plan1m;
    protected $plan3m;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        
        $this->bodybuilding = TrainingType::create(['name' => 'Bodybuilding']);
        
        $this->plan1m = Plan::create([
            'training_type_id' => $this->bodybuilding->id,
            'name' => '1 Month',
            'duration_days' => 30,
            'price' => 200,
            'is_active' => true,
        ]);

        $this->plan3m = Plan::create([
            'training_type_id' => $this->bodybuilding->id,
            'name' => '3 Months',
            'duration_days' => 90,
            'price' => 600,
            'is_active' => true,
        ]);
    }

    public function test_1_month_subscription_adds_calendar_month()
    {
        $startDate = '2025-01-31'; // January 31st
        
        $response = $this->actingAs($this->user)->post(route('members.store'), [
            'full_name' => 'Test Member',
            'cin' => 'AB123456',
            'gender' => 'male',
            'plan_id' => $this->plan1m->id,
            'start_date' => $startDate,
        ]);

        $response->assertRedirect(route('members.index'));
        
        $member = Member::where('cin', 'AB123456')->first();
        $subscription = $member->subscriptions->first();
        
        // Jan 31 + 1 month = Feb 28 (or 29)
        $expectedEndDate = Carbon::parse($startDate)->addMonth()->toDateString();
        $this->assertEquals($expectedEndDate, $subscription->end_date->toDateString());
    }

    public function test_3_month_subscription_adds_3_calendar_months()
    {
        $startDate = '2025-03-31'; // March 31st
        
        $response = $this->actingAs($this->user)->post(route('members.store'), [
            'full_name' => 'Test Member 3M',
            'cin' => 'CD123456',
            'gender' => 'female',
            'plan_id' => $this->plan3m->id,
            'start_date' => $startDate,
        ]);

        $member = Member::where('cin', 'CD123456')->first();
        $subscription = $member->subscriptions->first();
        
        // Mar 31 + 3 months = June 30
        $expectedEndDate = Carbon::parse($startDate)->addMonths(3)->toDateString();
        $this->assertEquals($expectedEndDate, $subscription->end_date->toDateString());
    }

    public function test_subscription_with_old_date_is_calculated_correctly()
    {
        // One month ago from today (2025-12-28)
        $startDate = '2025-11-20'; 
        
        $response = $this->actingAs($this->user)->post(route('members.store'), [
            'full_name' => 'Old Member',
            'cin' => 'EF123456',
            'gender' => 'male',
            'plan_id' => $this->plan1m->id,
            'start_date' => $startDate,
        ]);

        $member = Member::where('cin', 'EF123456')->first();
        $subscription = $member->subscriptions->first();
        
        $expectedEndDate = Carbon::parse($startDate)->addMonth()->toDateString();
        $this->assertEquals($expectedEndDate, $subscription->end_date->toDateString());
        
        // It should be expired by now (2025-12-28) if end date is 2025-12-20
        $this->assertTrue($subscription->end_date->isPast());
    }
}
