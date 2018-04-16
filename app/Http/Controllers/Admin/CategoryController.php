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
use App\Models\Category as MCategory;

class CategoryController extends Controller
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
    	$cates = $this->category->all();
        $cates = get_options($cates);
    	return view('admin.category.list',["cates"=>$cates]);
    }

    public function getAdd()
    {
    	$cates = $this->category->all();
        $cates = get_options($cates);
    	return view('admin.category.add',["cates"=>$cates]);
    }
    public function postAdd(Request $request)
    {
        $rules = [
            'Name'=>['required','unique:categories,Name','min:3','max:100'],
            'Url'=> 'required|unique:categories,Url|alpha_dash|max:100',
            'Category_Id'=> 'integer',
        ];

        $msg = [
            'Name.required'=>'Bạn chưa nhập tên chuyên mục!',
            'Name.min'=>'Tên chuyên mục gồm ít nhất 3 ký tự!',
            'Name.max'=>'Tên chuyên mục gồm tối đa 100 ký tự!',
            'Url.unique' => 'Url chuyên mục đã tồn tại, vui lòng nhập lại tên!',
            'Url.required'=> 'Không được bỏ trống url',
            'Url.alpha_dash'=> 'Sai định dạng Url.',
            'Category_Id.integer' => 'Chuyên mục cha phải là số.'
        ];
    	$validator = Validator::make($request->all(), $rules , $msg);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }else{
            $data = [];
            $data['Name'] = $request->Name;
            $data['Url'] = $request->Url;

            if( $request->Category_Id ){
                $Category_Id = $this->category->find($request->Category_Id);
                if( $Category_Id ){
                    $data['Category_Id'] = $request->Category_Id;
                    $data['IsSubCategory'] = 1;
                }else{
                    $data['IsSubCategory'] = 0;
                }
            }else{
                $data['Category_Id'] = null;
            }

            $this->category->create($data);

            Session::flash('flash_success','Thêm chuyên mục thành công.');
            return redirect('admin/category/add');
        }
    }

    public function dataTable()
    { 
    	
    	$model = MCategory::query();

    	return DataTables::of($model)
                ->addColumn('post_count', function(MCategory $cate1) {
                    return $cate1->posts->count().' bài viết';
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

    public function postUpdate(Request $request)
    {
    	if($request->ajax()){

            
    		$cate = $this->category->find($request->input('id'));
    		if( $cate ) {
    			if( $request->input('Name') && $request->input('Url')){

    				$cate->name = $request->input('Name');
                    $cate->Url = $request->input('Url');
                    $cate->Category_Id = $request->input('Category_Id');
                    if($request->input('Category_Id') ){
                        $cate->IsSubCategory = 1;
                    }else{

                        $cate->IsSubCategory = 0;
                    }
    			} else return 'Không được bỏ trống tên và đường dẫn.';
    			$cate->save();
    			return 'ok';
    		} else return 'Sai ID';
    	}
    }

    public function delete(Request $request)
    {
    	if($request->ajax()){
    		$cate = $this->category->find($request->input('id'));
    		if( $cate ) {
    			$cate->delete();
    			return 'ok';
    		} else return 'err';
    	}
    }

}
