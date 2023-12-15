<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = Category::factory()->create();
    }

    public function testGet()
    {
        $response = $this->getJson(route('categories.index'));

        $response->assertOk();

        $response->assertJsonPath('data.0.id', $this->category->id);

    }

    public function testStore()
    {
        $this->withoutExceptionHandling();

        $data = $this->category->toArray();
        $this->category->delete();

        $response = $this->postJson(route('categories.store'), $data);

        $response->assertCreated();

        $this->assertDatabaseCount('categories', 1);

    }

    public function testShow()
    {
        $response = $this->getJson(route('categories.show', $this->category->slug));

        $response->assertOk();

        $response->assertJsonFragment(['id' => $this->category->id]);
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();

        $this->category->name = 'No name';

        $response = $this->patchJson(route('categories.update', $this->category->slug), $this->category->toArray());

        $response->assertOk();

        $this->assertDatabaseHas('categories', ['name' => 'No name']);
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();

        $response = $this->deleteJson(route('categories.destroy', $this->category->slug));

        $response->assertOk();

        $this->assertDatabaseMissing('categories', ['id' => $this->category->id]);
    }
}
