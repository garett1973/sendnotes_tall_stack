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

    public function placeholder(): string
    {
        return <<<'HTML'
<div role="status">
    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="spinner" class="animate-spin h-10 w-10 text-blue-500 dark:text-blue-300" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="currentColor" d="M256 40c-97 0-176 79-176 176s79 176 176 176 176-79 176-176-79-176-176-176zm0 304c-75.02 0-136-60.98-136-136 0-75.02 60.98-136 136-136 75.02 0 136 60.98 136 136 0 75.02-60.98 136-136 136zm0-304c-75.02 0-136 60.98-136 136 0 75.02 60.98 136 136 136 75.02 0 136-60.98 136-136 0-75.02-60.98-136-136-136z"></path>
    </svg>
    <span class="sr-only">Loading...</span>
</div>
HTML;

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
                        @can('update', $note)
                            <a href="{{ route("note_edit", $note) }}" wire:navigate
                               class="text-blue-500 text-xl dark:text-blue-300 hover:underline">{{ $note->title }}</a>
                        @else
                            <p class="text-blue-500 text-xl dark:text-blue-300">{{ $note->title }}</p>
                        @endcan
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
                            <x-button.circle icon="eye" href="{{ route('note_view', $note) }}"></x-button.circle>
                            <x-button.circle icon="trash" wire:click="delete('{{ $note->id }}') "></x-button.circle>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif
</div>
