<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBabyRequest;
use App\Models\Baby;
use App\Models\Journal;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class BabyController extends Controller
{
    public function index(): Response
    {
        // Here we've used Eloquent's with method to eager-load every Journal's associated user's ID and name. We've also used the latest scope to return the records in reverse-chronological order.
        return Inertia::render('Babies/BabyIndex', [
            'babies' => Baby::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Baby $baby)
    {
        return Inertia::render('Babies/BabyDetails', [
            'baby' => $baby->only(
                'id',
                'user_id',
                'first_name',
                'birthday',
            ),
        ]);
    }
    public function store(StoreBabyRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $baby = $request->user()->babies()->create($validated);

        Log::info('Baby created with data: ', $baby->toArray()); // Debugging

        return redirect(route('babies.index'));
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request, Baby $baby): Response
    {
        return Inertia::render('Babies/BabyEdit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'baby' => $baby,
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBabyRequest $request, Baby $baby): RedirectResponse
    {
        Gate::authorize('update', $baby);
        $validated = $request->validated();
        $baby->update($validated);
        return redirect(route('babies.edit', $baby));
    }
}
