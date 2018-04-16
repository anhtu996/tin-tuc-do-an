<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $table = 'tags';
	protected $fillable = [
        'Title', 'FriendlyTitle', 'VisitCount',
    ];
    public function posts()
    {
    	return $this->belongsToMany('App\Models\Post', 'post_tag', 'Tag_Id', 'Post_Id');
    }
}
