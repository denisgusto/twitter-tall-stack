<?php

namespace App\Livewire\Tweet;

use App\Models\Tweet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    public ?string $body = null;

    public function tweet()
    {
        $this->authorize('create', Tweet::class);

        Tweet::create([
            'body' => $this->body,
            'created_by' => auth()->id()
        ]);

        $this->emit('tweet::created');
    }

    public function render()
    {
        return view('livewire.tweet.create');
    }
}
