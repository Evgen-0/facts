<?php

namespace App\Http\Controllers;

use App\Models\Fact;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::paginate(10);

        $tags->map(function (Tag $category) {
            if (!filter_var($category->photo, FILTER_VALIDATE_URL)) {
                Storage::url($category->photo);
            }
        });

        return Inertia::render('Tags', compact('tags'));
    }

    public function show(Tag $tag)
    {
        $facts = $tag->facts()->paginate(10);

        $facts->map(function (Fact $fact) {
            if (!filter_var($fact->body, FILTER_VALIDATE_URL)) {
                Storage::url($fact->body);
            }
        });

        return Inertia::render('TagsFacts', compact('tag', 'facts'));
    }
}
