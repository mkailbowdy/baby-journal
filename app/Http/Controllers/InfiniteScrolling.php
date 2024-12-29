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
    public function __invoke(Request $request, Baby $baby)
    {
        $journals = $baby->journals()->latest()->with('baby')->paginate(3);
//        $journals = Journal::with('baby')->latest()->paginate(3);
//        $baby = Baby::all()->first();

        return Inertia::render('Journals/JournalIndexInfinite', [
            'journals' => $journals,
            'baby' => $baby
        ]);
    }
}
