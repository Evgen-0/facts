<?php

namespace App\Http\Controllers;

use App\Data\CategoryData;
use App\Models\Category;
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
