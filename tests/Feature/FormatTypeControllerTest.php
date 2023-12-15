<?php

namespace Tests\Feature;

use App\Models\FormatType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormatTypeControllerTest extends TestCase
{
    private FormatType $formatType;

    protected function setUp(): void
    {
        parent::setUp();
        $this->formatType = FormatType::factory()->create();
    }

    use RefreshDatabase;

    public function testGet()
    {
        $response = $this->getJson(route('formatTypes.index'));

        $response->assertOk();

        $response->assertJsonPath('data.0.id', $this->formatType->id);

    }

    public function testStore()
    {
        $this->withoutExceptionHandling();

        $data = $this->formatType->toArray();
        $this->formatType->delete();

        $response = $this->postJson(route('formatTypes.store'), $data);

        $response->assertCreated();

        $this->assertDatabaseCount('format_types', 1);

    }

    public function testShow()
    {
        $response = $this->getJson(route('formatTypes.show', $this->formatType->id));

        $response->assertOk();

        $response->assertJsonFragment(['id' => $this->formatType->id]);
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();

        $this->formatType->name = 'No name';

        $response = $this->patchJson(route('formatTypes.update', $this->formatType->id), $this->formatType->toArray());

        $response->assertOk();

        $this->assertDatabaseHas('format_types', ['name' => 'No name']);
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();

        $response = $this->deleteJson(route('formatTypes.destroy', $this->formatType->id));

        $response->assertOk();

        $this->assertDatabaseMissing('format_types', ['id' => $this->formatType->id]);
    }
}
