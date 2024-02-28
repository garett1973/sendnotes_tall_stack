<?php

use App\Models\Note;
use Livewire\Volt\Component;

new class extends Component {
    public Note $note;
    public $heartCount;

    public function mount(Note $note): void
    {
        $this->note = $note;
        $this->heartCount = $note->heart_count;
    }

    public function updateNote(): void
    {
        $this->note->update([
            'heart_count' => $this->heartCount + 1
        ]);
        $this->heartCount = $this->note->heart_count;
    }

}; ?>

<div>
    <x-button xs wire:click="updateNote" rose icon="heart" class="mr-2 rounded-lg">
        {{ $heartCount }}
    </x-button>
</div>
