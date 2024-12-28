<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use App\Models\Journal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InfiniteScrolling extends Controller
{

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $journals = Journal::with('baby')->paginate(2);
        $baby = Baby::all()->first();

        return Inertia::render('Journals/JournalIndexInfinite', [
            'journals' => $journals,
            'baby' => $baby
        ]);
    }
}
