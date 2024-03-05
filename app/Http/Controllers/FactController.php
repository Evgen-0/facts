<?php

namespace App\Http\Controllers;

use App\Data\CommentData;
use App\Data\FactData;
use App\Models\Fact;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class FactController extends Controller
{
    public function favorite(Fact $fact): void
    {
        $isFavorite = $fact->userFavorites()->where('user_id', auth()->id());
        if ($isFavorite->exists()) {
            $isFavorite->delete();

            return;
        }

        $fact->userFavorites()->create(['user_id' => auth()->id()]);
    }

    public function comment(Fact $fact, CommentData $data): void
    {
        $fact->comments()->create($data->all());
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
        $like = $fact->likes()->where('user_id', auth()->id());
        if ($like->exists()) {
            $existingLike = $like->first();
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
    public function show(Fact $fact): Response
    {
        $fact->load('comments', 'comments.user');
        return Inertia::render('Fact', compact('fact'));
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
