<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class JournalController extends Controller
{
    public function index(): Response
    {
        // Here we've used Eloquent's with method to eager-load every Chirp's associated user's ID and name. We've also used the latest scope to return the records in reverse-chronological order.
        return Inertia::render('Journals/Index', [
            'journals' => Journal::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'entry' => 'required|string',
            'date' => 'required|date',
            'height' => 'required|integer|min:0',
            'weight' => 'required|integer|min:0',
        ]);

        $request->user()->journals()->create($validated);

        return redirect(route('journals.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journal $journal): RedirectResponse
    {
        Gate::authorize('update', $journal);
        $validated = $request->validate([
            'entry' => 'required|string',
            'date' => 'required|date',
            'height' => 'required|integer|min:0',
            'weight' => 'required|integer|min:0',
        ]);

        $journal->update($validated);

        return redirect(route('journals.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal)
    {
        //
    }
}
