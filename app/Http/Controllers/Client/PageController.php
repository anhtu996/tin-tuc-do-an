<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\CategoryRepository as Category;
use App\Repositories\Eloquent\PostRepository as Post;
use App\Repositories\Eloquent\TagRepository as Tag;
use App\Repositories\Eloquent\PostTagRepository as PostTag;
use DB;


class PageController extends Controller
{
    /**
     * @var Category
     */
    private $category;
    private $post;
    private $tag;
    private $post_tag;


    public function __construct(Category $category, Post $post, Tag $tag, PostTag $post_tag) {

        $this->category = $category;
        $this->post = $post;
        $this->tag = $tag;
        $this->post_tag = $post_tag;
    }

    public function index() {

        $cates = $this->category->getCateParent();

        $popularPosts = $this->post->findLimitBy('Popular', 1, 5, 'created_at');
        $lastestPosts = $this->post->findLimitOrderBy('created_at', 3);

        $mostPopularPosts = $this->post->findLimitBy('Popular', 1, 4, 'ViewCount');
        $mostNewPosts = $this->post->findLimitBy('New', 1, 4, 'created_at');
        $mostHotPosts = $this->post->findLimitBy('Hot', 1, 4, 'ViewCount');
        return view('client.pages.home',compact('cates', 'popularPosts', 'lastestPosts', 'mostPopularPosts', 'mostNewPosts', 'mostHotPosts'));
    }

    public function getPostByUrl($cateUrl, $postUrl, $cateId, $postId)
    {
        $post = $this->post->findBy('id',$postId);
        $mostHotPosts = $this->post->findLimitBy('Hot', 1, 4, 'ViewCount');
        $mostRelatePosts = $this->post->findWhereLimit(['New'=> 1,'Category_Id'=>$cateId], 4);
        //lay tag
        $tags =DB::table('tags')->where('posts.id', $postId)->join('post_tag', 'tags.id', '=', 'post_tag.Tag_Id')->join('posts', 'posts.id', '=', 'post_tag.Post_Id')->get(['tags.*']);
        
        return view('client.pages.single', compact('post', 'tags', 'mostRelatePosts', 'mostHotPosts'));
    }

    public function getCateByUrl($cateUrl, $cateId)
    {
        $cate = $this->category->findBy('Url', $cateUrl);
        
        if($cate->count()==0 || $cate->posts->count()==0){
            return view('client.pages.category',['key'=>$cateUrl]);
        } else {
            $listPost = $this->post->findWherePaginate(['Category_Id'=>$cate->id, 'Status'=>1], 10);
            return view('client.pages.category',compact('cate','listPost'));
        }
        
    }

    public function getSearch(Request $request){
        $key = $request->textSearch;
        $postSearch = $this->post->findWherePaginate(['Status'=>1,['Headline','like',"%$key%"]], 10);

        if($postSearch->count()==0){
            return view('client.pages.search',['key'=>$key]);
        } else {
            $mostPopularPosts = $this->post->findLimitBy('Popular', 1, 4, 'ViewCount');
            $mostNewPosts = $this->post->findLimitBy('New', 1, 4, 'created_at');
            $mostHotPosts = $this->post->findLimitBy('Hot', 1, 4, 'ViewCount');
            
            return view('client.pages.search',compact('key','postSearch', 'mostPopularPosts', 'mostNewPosts', 'mostHotPosts'));
        }
    }

    public function getTag($tag)
    {
        $tags = $this->tag->findBy('FriendlyTitle',$tag);
        if($tags){
            $tag = $tags->Title;
            $posts = $tags->posts;
            return view('client.pages.tag',compact('posts', 'tag'));    
        }
        return view('client.pages.tag',['tag'=>$tag]);;
        
    }
}
