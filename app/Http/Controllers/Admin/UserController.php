<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Repositories\Eloquent\CategoryRepository as Category;
use App\Repositories\Eloquent\PostRepository as Post;
use App\Repositories\Eloquent\TagRepository as Tag;
use Auth;
use Validator;
use Session;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\User as MUser;

class UserController extends Controller
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
    	return view('admin.author.list');
    }

    public function postAdd(Request $request)
    {
    	if($request->ajax()){
    	// $this->validate($req,
    	// 	[
    	// 		'cate_name'=>'required|unique:categories,name|min:3|max:70',
     //            'slug'=> 'required|unique:categories,slug|alpha_dash|max:100',
     //            'parent_id'=> 'integer',
    	// 	],
    	// 	[
    	// 		'cate_name.required'=>'Bạn chưa nhập tên chuyên mục!',
     //            'cate_name.min'=>'Tên chuyên mục gồm ít nhất 3 ký tự!',
     //            'cate_name.max'=>'Tên chuyên mục gồm tối đa 50 ký tự!',
    	// 		'slug.unique' => 'Url chuyên mục đã tồn tại, vui lòng nhập lại tên!',
     //            'slug.required'=> 'Không được bỏ trống url',
     //            'slug.alpha_dash'=> 'Sai định dạng slug.',
     //            'parent_id.integer' => 'Chuyên mục cha phải là số.'
    	// 	]);
	    	$author = new Admin();
	    	$author->name = $request->input('authorname');
	    	$author->password =bcrypt($request->input('password'));
	    	$author->email = $request->input('email');
	    	$author->save();
	        return 'ok';
	    }
    }

    public function dataTable()
    { 
        $model = MUser::whereHas('role', function ($query) {
                    $query->where('id', '!=', ROLE_ADMIN);
                });
        // $model = MUser::has('role')->get();
        // dd($model);
        // $model = MUser::where('quyen','!=','1');
        // dd($model);
    	return DataTables::of($model)
                ->addColumn('post_count', function(MUser $user) {
                    return $user->posts->count().' bài viết';
                })
                ->addColumn('action', '
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#show-delete">
                    	<i class="fa fa-trash" aria-hidden="true"></i> Xoá
                    </button>')
                ->make(true);
    }

    public function delete(Request $request)
    {
    	if($request->ajax()){
    		$author = Admin::find($request->input('id'));
    		if($author->delete()){
    			return 'ok';
    		} else return 'Không thể xóa.';
    	} else return 'err';
    }
}
