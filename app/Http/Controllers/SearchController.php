<?php

namespace App\Http\Controllers;

use App\Models\Fact;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function search(Request $request): Response
    {
        $facts = Fact::paginate();
        if ($request->has('query')) {
            $facts = Fact::where('heading', 'ilike', "%{$request->query('query')}%")->paginate();
        }

        return Inertia::render('Search', compact('facts'));
    }
}
