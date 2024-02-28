<x-guest-layout>
    <div class="flex flex-col">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 mb-3">
            {{ $note->title }}
        </h2>
        <p class="mt-2">{{ $note->body }}</p>
        <div class="flex items-center justify-end mt-12 space-x-2">
            <h3 class="text-sm mr-2">Sent from {{ $user->name }}</h3>
            <livewire:heartreact :note="$note" :key="$note->id" />
        </div>
    </div>
</x-guest-layout>
