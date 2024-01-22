<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $users;

    protected function setUp(): void
    {
        parent::setUp();
        $this->users = User::factory()->create();
    }

    public function testGet()
    {
        $response = $this->getJson(route('users.index'));

        $response->assertOk();

        $response->assertJsonPath('data.0.id', $this->users->id);

    }

    public function testShow()
    {
        $response = $this->getJson(route('users.show', $this->users->id));

        $response->assertOk();

        $response->assertJsonFragment(['id' => $this->users->id]);
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();

        $this->users->name = 'No name';

        $response = $this->patchJson(route('users.update', $this->users->id), $this->users->toArray());

        $response->assertOk();

        $this->assertDatabaseHas('users', ['name' => 'No name']);
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();

        $response = $this->deleteJson(route('users.destroy', $this->users->id));

        $response->assertOk();

        $this->assertDatabaseMissing('users', ['id' => $this->users->id]);
    }
}
