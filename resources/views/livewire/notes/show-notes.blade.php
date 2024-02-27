<?php

use Illuminate\Support\Str;
use Livewire\Volt\Component;

new class extends Component {

    public function delete($noteId): void
    {
        $note = auth()->user()->notes()->find($noteId);
        if ($note) {
            $authorized = $this->authorize('delete', $note);
            if ($authorized) {
                $note->delete();
                session()->flash('success', 'Note deleted successfully');
            } else {
                session()->flash('error', 'You are not authorized to delete this note');
            }
        }
    }

    public function with(): array
    {
        return [
            'notes' => auth()->user()
                ->notes()
                ->orderBy('send_date', 'desc')
                ->get()
        ];
    }
}; ?>

<div class="w-full">
    <x-button primary icon-right="plus" class="mb-4" href="{{ route('notes_create') }}" wire:navigate>
        Create a note
    </x-button>
    @if ($notes->isEmpty())
        <div class="w-full flex flex-col items-center justify-center p-4 gap-y-2">
            <p class="text-gray-600 text-2xl dark:text-gray-800">No notes found</p>
            <p class="text-gray-600 dark:text-gray-300">Create a note to get started</p>
            <x-button primary icon-right="plus" href="{{ route('notes_create') }}" wire:navigate>Create a note
            </x-button>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($notes as $note)
                <x-card wire:key="{{ $note->id }}">
                    <div class="w-full flex items-center justify-between p-4">
                        <a href="{{ route("note_edit", $note) }}" wire:navigate
                           class="text-blue-500 text-xl dark:text-blue-300 hover:underline">{{ $note->title }}</a>
                        <p class="text-gray-600 text-xs dark:text-gray-300">
                            <b>{{ $note->send_date->format('m/d/Y') }}</b></p>
                    </div>
                    <div class="px-4">
                        <p>{{ Str::limit($note->body, 20) }}</p>
                    </div>
                    <div class="w-full flex items-center justify-between p-4">
                        <p class="text-gray-600 text-xs dark:text-gray-300">Recipient: <span
                                class="font-semibold">{{ $note->recipient }}</span></p>
                        <div>
                            <x-button.circle icon="eye"></x-button.circle>
                            <x-button.circle icon="trash" wire:click="delete('{{ $note->id }}') "></x-button.circle>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif
</div>
