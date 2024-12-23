<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJournalRequest;
use App\Models\Journal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class JournalController extends Controller
{
    public function index(): Response
    {
        // Here we've used Eloquent's with method to eager-load every Journal's associated user's ID and name. We've also used the latest scope to return the records in reverse-chronological order.
        return Inertia::render('Journals/JournalIndex', [
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
    public function store(StoreJournalRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Store the file in the storage/app/public/images directory
        if($request->hasFile('image')){
            // store the image into our file disk at storage/app/public/images and set the path as a string to $imagePath
            $imagePath = $request->file('image')->store('images', 'public');
            // Add the image path to the validated data
            $validated['image'] = $imagePath;

            Log::info('Image saved to path: ' . $imagePath); // Debugging
        }
        $journal = $request->user()->journals()->create($validated);

        Log::info('Journal created with data: ', $journal->toArray()); // Debugging

        return redirect(route('journals.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Journal $journal)
    {
        return Inertia::render('Journals/Show1', [
            'journal' => $journal->only(
                'id',
                'date',
                'height',
                'weight',
                'entry',
                'image',
            ),
        ]);

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
    public function update(StoreJournalRequest $request, Journal $journal): RedirectResponse
    {
        Gate::authorize('update', $journal);
        $validated = $request->validated();

        $journal->update($validated);

        return redirect(route('journals.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journal $journal): RedirectResponse
    {
        Gate::authorize('delete', $journal);
        $journal->delete();
        return redirect(route('journals.index'));
    }
}
