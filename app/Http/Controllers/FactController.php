<?php

namespace App\Http\Controllers;

use App\Data\FactData;
use App\Models\Fact;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use function auth;

class FactController extends Controller
{
    public function favorite(Fact $fact): void
    {
        $isFavorite = $fact->favorites()->where('user_id', auth()->id());
        if ($isFavorite->exists()) {
            $isFavorite->delete();

            return;
        }

        $fact->favorites()->create(['user_id' => auth()->id()]);
    }

    public function like(Fact $fact): void
    {
        $this->toggleLike($fact, true);
    }

    public function dislike(Fact $fact): void
    {
        $this->toggleLike($fact, false);
    }

    public function toggleLike(Fact $fact, bool $isLike): void
    {
        $isLike = $fact->likes()->where('user_id', auth()->id());
        if ($isLike->exists()) {
            $existingLike = $isLike->first();
            if ($existingLike->is_like === $isLike) {
                $existingLike->delete();
            } else {
                $existingLike->update(['is_like' => $isLike]);
            }

            return;
        }

        $fact->likes()->create(['user_id' => auth()->id(), 'is_like' => $isLike]);
    }

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
