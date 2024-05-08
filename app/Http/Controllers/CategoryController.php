<?php

namespace App\Http\Controllers;

use App\Data\CategoryData;
use App\Models\Category;
use App\Models\Fact;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return CategoryData::collection(Category::paginate(10));
    }

    public function indexWeb()
    {
        $categories = Category::paginate(10);

        $categories->map(function (Category $category) {
            if (!filter_var($category->photo, FILTER_VALIDATE_URL)) {
                Storage::url($category->photo);
            }
        });

        return Inertia::render('Categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryData $data): CategoryData
    {
        return CategoryData::from(Category::create($data->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): CategoryData
    {
        return CategoryData::from($category);
    }

    public function showWeb(Category $category)
    {
        $facts = $category->facts()->paginate(10);

        $facts->map(function (Fact $fact) {
            if (!filter_var($fact->body, FILTER_VALIDATE_URL)) {
                Storage::url($fact->body);
            }
        });

        return Inertia::render('CategoriesFacts', compact('category', 'facts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryData $data, Category $category): CategoryData
    {
        $category->update($data->all());

        return CategoryData::from($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): void
    {
        $category->delete();
    }
}
