<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\Eloquent\CategoryRepository as Category;
use App\Repositories\Eloquent\PostRepository as Post;
use App\Repositories\Eloquent\TagRepository as Tag;
use App\Repositories\Eloquent\UserRepository as User;

class HomeController extends Controller
{
    private $category;
    private $post;
    private $tag;
    private $user;
	public function __construct(Category $category, Post $post, Tag $tag, User $user) {

        $this->category = $category;
        $this->post = $post;
        $this->tag = $tag;
        $this->user = $user;
    }

    public function getDashboard()	
    {
    	$post_count = $this->post->count();
    	$user_count = $this->user->count();
    	$tag_count = $this->tag->count();
    	$category_count = $this->category->count();
    	return view('admin.index',compact('post_count','user_count','tag_count','category_count'));
    }
}
