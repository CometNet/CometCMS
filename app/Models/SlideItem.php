<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slide_id', 'status', 'list_order', 'title', 'image', 'url', 'description', 'content'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'more'
    ];
}
