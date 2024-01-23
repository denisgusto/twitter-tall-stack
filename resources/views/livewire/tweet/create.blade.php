<div>
    <div>
        <div class="mb-4">
            <textarea wire:model="body" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none"
                      rows="4" placeholder="What's up?"></textarea>
            @error('body')
            <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex justify-end">
            <button wire:click="tweet" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                Tweet-a-roo!
            </button>
        </div>
    </div>
</div>
