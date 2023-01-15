<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class UserInfoMain extends Component
{

    public function __construct(public bool $edit = false, public User $user,public $countries,public $shipping, public $billing, public $tab = "account")
    {
    }

    public function render()
    {
        return view('components.user-info-main');
    }
}
