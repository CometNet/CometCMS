<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagPost extends Model
{
    protected $table = 'tag_post';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag_id', 'post_id'
    ];

    public function posts(){
        return $this->hasMany('App\Models\Post','id', 'post_id');
    }
}
