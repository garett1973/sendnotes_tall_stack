<?php

use Livewire\Features\SupportRedirects\Redirector;
use Livewire\Volt\Component;

new class extends Component {
    public string $noteTitle;
    public string $noteRecipient;
    public string $noteBody;
    public string $noteSendDate;

    public function submit(): Redirector
    {
        $this->validate([
            'noteTitle' => 'required|string|min:5|unique:notes,title',
            'noteRecipient' => 'required|email',
            'noteBody' => 'required|string|min:10',
            'noteSendDate' => 'required|date',
        ]);

        auth()->user()->notes()->create([
            'title' => $this->noteTitle,
            'recipient' => $this->noteRecipient,
            'body' => $this->noteBody,
            'send_date' => $this->noteSendDate,
            'is_published' => false,
        ]);

        $this->noteTitle = '';
        $this->noteRecipient = '';
        $this->noteBody = '';
        $this->noteSendDate = '';

        session()->flash('success', 'Note created successfully');

        return redirect()->route('notes_list');
    }
}; ?>

<div class="w-full md:w-1/2 mx-auto">
    <form wire:submit="submit">
        <x-input wire:model="noteTitle" label="Note Title" class="mb-4"></x-input>
        <x-input icon="user" wire:model="noteRecipient" label="Recipient" type="email" class="mb-4" placeholder="Recipient's email"></x-input>
        <x-input icon="calendar" wire:model="noteSendDate" label="Send Date" type="date" class="mb-4"></x-input>
        <x-textarea wire:model="noteBody" label="Body" class="mb-4" placeholder="Share your thoughts"></x-textarea>
        <x-button primary right-icon="plus" spinner wire:click="submit">Create Note</x-button>
    </form>
</div>
