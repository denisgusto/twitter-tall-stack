<?php

namespace App\Http\Livewire;

use App\Models\Tweet;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class Timeline extends Component
{
    public function render(): View
    {
        return view('livewire.timeline', [
            'tweets' => Tweet::query()->latest()->get()
        ]);
    }
}
