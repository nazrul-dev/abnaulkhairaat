<?php

namespace App\Livewire\Pages;

use DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Landing extends Component
{
    #[Layout('components.layouts.web')]
    public function render()
    {


        return view('livewire.pages.landing');
    }
}
