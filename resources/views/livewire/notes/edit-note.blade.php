<?php

use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;
    public string $noteTitle;
    public string $noteRecipient;
    public string $noteBody;
    public string $noteSendDate;
    public bool $noteIsPublished;

    public function mount(Note $note)
    {
        $authorized = $this->authorize('update', $note);
        if (!$authorized) {
            session()->flash('error', 'You are not authorized to edit this note');
            return redirect()->route('notes_list');
        }

        $this->authorize('update', $note);
        $this->fill($note);
        $this->noteTitle = $note->title;
        $this->noteRecipient = $note->recipient;
        $this->noteBody = $note->body;
        $this->noteSendDate = $note->send_date->format('Y-m-d');
        $this->noteIsPublished = $note->is_published;
    }

    public function saveNote()
    {

        $validated = $this->validate([
            'noteTitle' => 'required|string|min:5',
            'noteRecipient' => 'required|email',
            'noteBody' => 'required|string|min:10',
            'noteSendDate' => 'required|date',
        ]);

        if (!$validated) {
            return back()->withErrors($validated);
        }

        $this->note->update([
            'title' => $this->noteTitle,
            'recipient' => $this->noteRecipient,
            'body' => $this->noteBody,
            'send_date' => $this->noteSendDate,
            'is_published' => $this->noteIsPublished ?? false,
        ]);

        session()->flash('success', 'Note updated successfully');

        $this->dispatch('note-saved');

//        return redirect()->route('notes_list');
    }

}; ?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Edit Note') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                    <form wire:submit="saveNote">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-label for="title">Title</x-label>
                                <x-input wire:model="noteTitle" id="title" type="text" class="w-full"/>
                            </div>
                            <div>
                                <x-label for="send_date">Send date</x-label>
                                <x-input wire:model="noteSendDate" id="send_date" type="date" class="w-full"/>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="body">Body</x-label>
                            <x-textarea wire:model="noteBody" id="body" class="w-full"/>
                        </div>
                        <div class="mt-4">
                            <x-label for="recipient">Recipient</x-label>
                            <x-input wire:model="noteRecipient" id="recipient" type="email" class="w-full"/>
                        </div>
                        <div class="mt-4">
                            <x-checkbox label="Note is published" wire:model="noteIsPublished" id="is_published"/>
                        </div>
                        <div class="my-4 flex justify-between">
                            <x-button positive spinner type="submit">Save</x-button>
                            <x-button secondary href="{{ route('notes_list') }}" wire:navigate>Back to Notes</x-button>
                        </div>
                        <x-action-message on="note-saved" />
                        <x-errors />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
