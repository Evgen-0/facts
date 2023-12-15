<?php

namespace App\Http\Controllers;

use App\Data\FormatTypeData;
use App\Models\FormatType;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class FormatTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        return FormatTypeData::collection(FormatType::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormatTypeData $data): FormatTypeData
    {
        return FormatTypeData::from(FormatType::create($data->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(FormatType $formatType): FormatTypeData
    {
        return FormatTypeData::from($formatType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormatTypeData $data, FormatType $formatType): FormatTypeData
    {
        $formatType->update($data->all());

        return FormatTypeData::from($formatType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormatType $formatType): void
    {
        $formatType->delete();
    }
}
