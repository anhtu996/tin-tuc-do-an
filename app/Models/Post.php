<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $table = 'posts';

    protected $fillable = [
        'Title', 'SubTitle', 'FriendlyTitle', 'Category_Id', 'Headline', 'Content', 'New', 'Status', 'CreatedBy_Id', 'Thumbnail','LastUpdateBy_Id', 
    ];

    public function category()
    {
    	return $this->belongsTo('App\Models\Category','Category_Id','id');
    }

    public function tags()
    {
    	return $this->belongsToMany('App\Models\Tag', 'post_tag', 'Post_id', 'Tag_id');
    }
    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
    public function files()
    {
    	return $this->hasMany('App\File', 'post_id','id');
    }
}
