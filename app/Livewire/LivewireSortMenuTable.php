<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class LivewireSortMenuTable extends Component
{
    public function render()
    {
        $menus = Menu::all();
        //return view('menus.list', compact('menus'));
        return view('livewire.livewire-sort-menu-table', compact('menus'));
    }
}
