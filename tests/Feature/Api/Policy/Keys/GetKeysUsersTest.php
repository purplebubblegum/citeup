<?php

namespace Tests\Feature\Api\Policy\Keys;

use Tests\TestCase;
use App\Modules\Testing\TestAssistant;
use App\Modules\Models\Key;

class GetKeysUsersTest extends TestCase
{
    use TestAssistant;

    /**
     * Testing a successful attempt on admin.
     *
     * @return void
     */
    public function test200Admin()
    {
        $key = $this->createFactoryKey();

        $response = $this->requestToApi(
            $this->randomAdmin(), 'GET', '/keys/'. $key->id .'/users'
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
        $key = $this->createFactoryKey();

        $response = $this->requestToApi(
            $this->randomCommittee(), 'GET', '/keys/'. $key->id .'/users'
        );

        $response->assertStatus(403);
    }

    /**
     * Create a new key using factory.
     *
     * @return Key
     */
    protected function createFactoryKey()
    {
        return factory(Key::class)->create();
    }
}
