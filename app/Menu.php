<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function subMenu()
    {
        return $this->hasMany('App\SubMenu');
    }

    public function article()
    {
        return $this->hasMany('App\Article');
    }
}
