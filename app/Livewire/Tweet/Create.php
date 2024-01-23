<?php

namespace App\Livewire\Tweet;

use App\Models\Tweet;
use Livewire\Component;

class Create extends Component
{
    public ?string $body = null;

    public function tweet(): void
    {
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
