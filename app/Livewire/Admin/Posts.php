<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Posts extends Component
{
    use WithPagination;

    public $perPage = 4;
    public function render()
    {
        return view('livewire.admin.posts', [
            'posts' => auth()->user()->type == "superAdmin" ?
                Post::paginate($this->perPage) :
                Post::where('author', auth()->id())->paginate($this->perPage),
        ]);
    }
}
