<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Posts extends Component
{
    public function render()
    {
        return view('livewire.admin.posts', [
            'posts' => auth()->user()->type == "superAdmin" ? Post::all() : Post::where('author', auth()->id())->get(),
        ]);
    }
}
