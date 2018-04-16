<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\CategoryRepository as Category;
use App\Repositories\Eloquent\PostRepository as Post;
use App\Repositories\Eloquent\TagRepository as Tag;
use Auth;
use Validator;
use Session;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Models\Tag as MTag;

class TagController extends Controller
{
    private $category;
    private $post;
    private $tag;

    public function __construct(Category $category, Post $post, Tag $tag) {

        $this->category = $category;
        $this->post = $post;
        $this->tag = $tag;
    }

    public function getList()
    {
    	return view('admin.tag.list');
    }

    public function postAdd(Request $request)
    {
    	if($request->ajax()){
    		$data = [];
    		$data['Title'] = $request->Title;
    		$data['FriendlyTitle'] = $request->FriendlyTitle;
    		$data['VisitCount'] = 0;
	    	$this->tag->create($data);
	        return 'ok';
	    }
    }

    public function dataTable()
    { 
    	$model = MTag::query();
    	return DataTables::of($model)
    			->addColumn('post_count', function(MTag $tag) {
                    return $tag->posts->count() . ' bài';
                })
                ->addColumn('action', '
                	<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#show-update">
                		<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Sửa 
                	</button>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#show-delete">
                    	<i class="fa fa-trash" aria-hidden="true"></i> Xoá
                    </button>')
                ->make(true);
    }

    public function putUpdate(Request $request)
    {
   	if($request->ajax()){
	  //       $rules = [
	  //   		'Title' => 'required | max : 25 ',
	  //   		'FriendlyTitle' => 'required'
	  //   	];

	  //   	$msg = [
			//     'required' => ':attribute không được bỏ trống.',
			//     'Title.max' => 'Username phải nhỏ hơn :max ký tự.',
			// ];
		
	  //   	$validator = Validator::make($request->all(), $rules , $msg);

	  //   	if ($validator->fails()) {
	  //           return 'err';
	  //       } else {   
	    		$tag = $this->tag->find($request->input('id'));
	    		if( $tag ) {
	    			if( $request->input('Title') && $request->input('FriendlyTitle')){

	    				$tag->Title = $request->input('Title');
	                    $tag->FriendlyTitle = $request->input('FriendlyTitle');
	                    $tag->save();
	                    return 'ok';
	    			} else return 'Không được bỏ trống tên và đường dẫn.';
	    		} else return 'Sai ID';
	    	//}
    	}
    }

    public function delete(Request $request)
    {
    	if($request->ajax()){
    		$tag = $this->tag->find($request->input('id'));
    		if($tag){
                $tag->posts()->detach();
                $tag->delete();
                return 'ok';
    		}
    		else return 'Không tồn tại tag.';
    	} else return 'err';
    }
}
