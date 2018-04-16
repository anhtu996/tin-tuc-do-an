<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Eloquent\TagRepository as Tag;
use App\Repositories\Eloquent\PostRepository as Post;
class SidebarComPoser
{
	protected $tag;
	protected $post;

	public function __construct(Tag $tag, Post $post)
	{
		$this->tag = $tag;
		$this->post = $post;
	}

	public function compose(View $view)
	{	
		$tags = $this->tag->findLimitBy('Type','Keyword',10,'id');
		$mostPopularPosts = $this->post->findLimitBy('Popular', 1, 4, 'ViewCount');
        $mostNewPosts = $this->post->findLimitBy('New', 1, 4, 'created_at');
        $mostHotPosts = $this->post->findLimitBy('Hot', 1, 4, 'ViewCount');
		$view->with('tags', $tags)->with('mostPopularPosts', $mostPopularPosts)->with('mostNewPosts', $mostNewPosts)->with('mostHotPosts', $mostHotPosts);
	}
}