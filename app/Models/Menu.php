<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nav_id', 'parent_id', 'status', 'list_order', 'name', 'href', 'target', 'icon'
    ];


}
