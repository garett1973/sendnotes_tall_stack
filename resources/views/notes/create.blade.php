<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create a Note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full">
                        <div class="w-full flex justify-end">
                            <x-button secondary icon="arrow-left" class="mb-4" href="{{ route('notes_list') }}" wire:navigate>Back to notes</x-button>
                        </div>
                        <livewire:notes.create-note />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
