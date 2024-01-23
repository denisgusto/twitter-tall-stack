<div>
    @foreach($tweets as $tweet)
            <div class="flex items-center mb-5">
                <div class="flex-shrink-0 mr-3">
                    <img class="w-10 h-10 rounded-full" src="" alt="" />
                </div>
                <div class="ml-3">
                    <div class="text-sm font-medium text-gray-100">
                        {{ $tweet->body }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $tweet->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
    @endforeach
</div>
