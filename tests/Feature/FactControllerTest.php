<?php

namespace Tests\Feature;

use App\Models\Fact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactControllerTest extends TestCase
{
    use RefreshDatabase;

    private Fact $fact;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fact = Fact::factory()->create();
    }

    public function testGet()
    {
        $response = $this->getJson(route('facts.index'));

        $response->assertOk();

        $response->assertJsonPath('data.0.id', $this->fact->id);
    }

    public function testStore()
    {
        $this->withoutExceptionHandling();

        $data = $this->fact->toArray();
        $this->fact->delete();

        $response = $this->postJson(route('facts.store'), $data);

        $response->assertCreated();

        $this->assertDatabaseCount('facts', 1);
    }

    public function testShow()
    {
        $response = $this->getJson(route('facts.show', $this->fact->slug));

        $response->assertOk();

        $response->assertJsonFragment(['id' => $this->fact->id]);
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();

        $this->fact->body = 'No body';

        $response = $this->patchJson(route('facts.update', $this->fact->slug), $this->fact->toArray());

        $response->assertOk();

        $this->assertDatabaseHas('facts', ['body' => 'No body']);
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();

        $response = $this->deleteJson(route('facts.destroy', $this->fact->slug));

        $response->assertOk();

        $this->assertDatabaseMissing('facts', ['id' => $this->fact->id]);
    }
}
