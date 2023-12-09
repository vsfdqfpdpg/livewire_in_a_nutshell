<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class Counter
{
    public int $count = 1;

    public function increment(): void
    {
        $this->count++;
    }

    public function decrement(): void
    {
        $this->count--;
    }

    public function render(): View|Closure|string
    {
        // Single quotes do not parse variables
        return <<<'HTML'
<div>
    <div class="flex font-bold p-6">
        <button wire:click="increment" type="button"
                class="px-6 py-2 bg-indigo-500 rounded-lg me-5 hover:bg-indigo-700 text-white">+
        </button>
        <button wire:click="decrement" type="button"
                class="px-6 py-2 bg-blue-500 text-white rounded-lg me-5 hover:bg-blue-700">-
        </button>
    </div>
    </div>
    <span class="p-3">Counter: {{$count}}</span>
</div>
HTML;
    }
}
