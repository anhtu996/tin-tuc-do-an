<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Eloquent\CategoryRepository as Category;
use App\Repositories\Eloquent\PostRepository as Post;
use App\Repositories\Eloquent\TagRepository as Tag;
use App\Repositories\Eloquent\UserRepository as User;
use DB;

class AjaxController extends Controller
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

    public function searchTag(Request $request)
    {

        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $tags = $this->tag->findLimitLikeBy('Title', $term, 30, 'VisitCount') ;

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->Title];
        }
        
        return \Response::json($formatted_tags);
    }

    public function searchTagWithId($id)
    {
        
        $post = $this->post->find($id);
        $tagIds = $post->tags()->allRelatedIds();
        
        $tags = DB::table('tags')->whereIn('id', $tagIds)->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => "$tag->id", 'text' => $tag->Title];
        }

        return \Response::json($formatted_tags);
    }
}
