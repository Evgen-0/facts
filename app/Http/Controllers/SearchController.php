<?php

namespace App\Http\Controllers;

use App\Models\Fact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function search(Request $request): Response
    {
        $facts = Fact::paginate();

        $facts->map(function (Fact $fact) {
            if (!filter_var($fact->body, FILTER_VALIDATE_URL)) {
                $fact->body = Storage::url($fact->body);
            }
        });

        if ($request->has('query')) {
            $facts = Fact::where('heading', 'ilike', "%{$request->query('query')}%")->paginate();
        }

        return Inertia::render('Search', compact('facts'));
    }
}
