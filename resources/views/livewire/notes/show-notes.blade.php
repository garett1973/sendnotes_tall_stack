<?php

use Livewire\Volt\Component;

new class extends Component {


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

<div>
    @foreach ($notes as $note)
        <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-4">
            <h2 class="text-xl font-bold mb-2">{{ $note->title }}</h2>
            <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $note->body }}</p>
            <p class="text-gray-600 dark:text-gray-300 mb-2">Published: <b>{{ $note->is_published ? 'Yes' : 'No' }}</b></p>
            <p class="text-gray-600 dark:text-gray-300 mb-2">Heart count: <b>{{ $note->heart_count }}</b></p>
            <p class="text-gray-600 text-sm dark:text-gray-300 mb-2">Send date: <b>{{ explode(' ', $note->send_date)[0] }}</b></p>
        </div>
    @endforeach
</div>
