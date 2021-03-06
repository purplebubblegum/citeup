<?php

namespace Tests\Feature\Api\Policy\Schedules;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Schedule;

class GetSchedulesEditsTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt by admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $user = $this->randomAdmin();

        $schedule = $this->createFactorySchedule();

        $response = $this->requestToApi(
            $user, 'GET', '/schedules/'. $schedule->id .'/edits'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a successful attempt using key.
     *
     * @return void
     */
    public function test200Keyed()
    {
        $user = $this->randomCommittee();

        $schedule = $this->createFactorySchedule();

        $this->grant($user, 'get-edits');

        $response = $this->requestToApi(
            $user, 'GET', '/schedules/'. $schedule->id .'/edits'
        );

        $response->assertStatus(200);
    }

    /**
     * Testing a forbidden attempt.
     *
     * @return void
     */
    public function test403()
    {
        $user = $this->randomEntrant();

        $schedule = $this->createFactorySchedule();

        $response = $this->requestToApi(
            $user, 'GET', '/schedules/'. $schedule->id .'/edits'
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new schedule using factory.
     *
     * @return this
     */
    protected function createFactorySchedule()
    {
        return factory(Schedule::class)->create();
    }
}
