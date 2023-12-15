<?php

namespace App\Http\Controllers;

use App\Data\FactData;
use App\Models\Fact;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class FactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return FactData::collection(Fact::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FactData $data): FactData
    {
        return FactData::from(Fact::create($data->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Fact $fact): FactData
    {
        return FactData::from($fact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FactData $data, Fact $fact): FactData
    {
        $fact->update($data->all());

        return FactData::from($fact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fact $fact): void
    {
        $fact->delete();
    }
}
