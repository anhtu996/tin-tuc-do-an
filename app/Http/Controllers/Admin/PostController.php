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

class PostController extends Controller
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
        $posts = $this->post->all();

        if(Auth::user()->role[0]->id==ROLE_USER){
            $posts = $posts->where('CreatedBy_Id',Auth::user()->id);
        }

        return view('admin.post.list',['posts'=>$posts]);
    }

    public function getAdd()
    {
        $cates = $this->category->all();
        $cates = get_options($cates);
        
        // $tags = $this->tag->;
        return view('admin.post.add',['cates'=>$cates]);
    }


    
    public function postAdd(Request $request)
    {
        $rules= [
                'Title'=>'required|min:3|max:100',
                'Headline' =>'required|max:180',
                'Category_Id'=> 'required| integer',
                'Content'=> 'required',
                'FriendlyTitle'=> 'required|unique:posts,FriendlyTitle|alpha_dash',
                ];
        $msg = [
                'Title.required'=>'Không được bỏ trống tiêu đề.',
                'Title.unique' => 'Tin này đã bị trùng, vui lòng nhập lại!',
                'Title.min'=>'Tên tin tức gồm ít nhất 3 ký tự!',
                'Title.max'=>'Tên tin tức gồm tối đa 100 ký tự!',
                'Headline.required'=>'Không được bỏ trống tóm tắt.',
                'Content.required'=>'Không được bỏ trống nội dung',
                'Category_Id.required'=> 'Không được bỏ trống chuyên mục.',
                'Category_Id.integer'=> 'Chọn sai chuyên mục.',
                'FriendlyTitle.unique' => 'Url đã tồn tại, vui lòng nhập lại tiều đề!',
                'FriendlyTitle.required'=> 'Không được bỏ trống url',
                'FriendlyTitle.alpha_dash'=> 'Sai định dạng slug.',
                ];
        $validator = Validator::make($request->all(), $rules , $msg);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {
            $data = [];
            $data['Title'] = $request->Title;
            $data['FriendlyTitle'] = $request->FriendlyTitle;
            $data['Category_Id'] = $request->Category_Id;
            $data['Headline'] = $request->Headline;
            $data['Content'] = $request->Content;
            if(strlen($data['Title'] > 50))
                $data['SubTitle'] = str_pad($data['Title'],50,".");
            else{
                $data['SubTitle'] = $data['Title'];
            }
            $data['New'] = 1;
            $data['Status'] = 0;
            if(Auth::user()->role =='admin'){
                $data['Status'] = 1;
            }
            $data['CreatedBy_Id'] = Auth::user()->id;
            $data['LastUpdateBy_Id'] = Auth::user()->id;
            

            //Upload Image
            if($request->hasFile('Thumbnail')){
                $file = $request->file('Thumbnail');
                $path = uploadImage($file);
                $data['Thumbnail'] = $path;
            }else{  
                $data['Thumbnail'] = '';
            }

            $post = $this->post->create($data);
            $post->tags()->sync( $request->input('tags') ,false);
        }

        Session::flash('flash_success','Thêm tin tức thành công.');
        return redirect()->route('list-post');
    }

    public function getDelete($id)
    {
        $post = $this->post->find($id);

        if( $post ){
                if( $post->CreatedBy_Id == Auth::user()->id || Auth::user()->role[0]->id == ROLE_ADMIN ){
                    $post->tags()->detach();
                    $post->delete();
                    Session::flash('flash_success','Xóa thành công.');
                    return redirect()->route('list-post');
                } else {
                    Session::flash('flash_err','Bạn không có quyền xóa bài.');
                    return redirect()->route('list-post');
                }
         } else {
             Session::flash('flash_err','Bài viết không tồn tại.');
         }
         return redirect()->route('list-post');
    }
    
    public function getUpdate($id)
    {
        $post = $this->post->find($id);
        if($post){
            if($post->CreatedBy_Id == Auth::user()->id){
                $cates = $this->category->all();
                $cates = get_options($cates);
                return view('admin.post.edit',['post'=>$post,'cates'=>$cates]);
            } else {
                 Session::flash('flash_err','Bạn không có quyền thay đổi.');
                return redirect()->route('list-post');
            }
        }
        else {
            Session::flash('flash_err','Sai Thông tin Bài Viết.');
            return redirect()->route('list-post');
        }
    }

    public function postUpdate(Request $request,$id)
    {
        $post = $this->post->find($id);
        if( $post ) {
            if($post->CreatedBy_Id == Auth::user()->id){
                $rules= [
                     'Title'=>['required','min:3','max:100', Rule::unique('posts')->ignore($post->id)],
                     'Headline' =>'required|max:180',
                     'Category_Id'=> 'required| integer',
                     'Content'=> 'required',
                     'FriendlyTitle'=> ['required','alpha_dash',Rule::unique('posts')->ignore($post->id)],
                ];
                $msg = [
                    'Title.required'=>'Không được bỏ trống tiêu đề.',
                    'Title.unique' => 'Tin này đã bị trùng, vui lòng nhập lại!',
                    'Title.min'=>'Tên tin tức gồm ít nhất 3 ký tự!',
                    'Title.max'=>'Tên tin tức gồm tối đa 100 ký tự!',
                    'Headline.required'=>'Không được bỏ trống tóm tắt.',
                    'Content.required'=>'Không được bỏ trống nội dung',
                    'Category_Id.required'=> 'Không được bỏ trống chuyên mục.',
                    'Category_Id.integer'=> 'Chọn sai chuyên mục.',
                    'FriendlyTitle.unique' => 'Url đã tồn tại, vui lòng nhập lại tiều đề!',
                    'FriendlyTitle.required'=> 'Không được bỏ trống url',
                    'FriendlyTitle.alpha_dash'=> 'Sai định dạng slug.',
                ];

                $validator = Validator::make($request->all(), $rules , $msg);

                if ($validator->fails()) {
                    return redirect()->back()
                                ->withErrors($validator)
                                ->withInput();
                } else {
                    $post->Title = $request->input('Title');
                    $post->Content = $request->input('Content');
                    $post->Headline = $request->input('Headline');
                    $post->FriendlyTitle = $request->input('FriendlyTitle');
                    $post->CreatedBy_Id = Auth::user()->id;
                    $post->Category_Id = $request->input('Category_Id');
                    if(strlen($post->Title > 50)){
                        $post->SubTitle = str_pad($data['Title'],50,".");
                    }
                    else{
                        $post->SubTitle = $post->Title;
                    }

                    $post->LastUpdateBy_Id = Auth::user()->id;
                        //Upload Image
                    if($request->hasFile('Thumbnail')){
                        $file = $request->file('Thumbnail');
                        $path = uploadImage($file);
                        $data['Thumbnail'] = $path;
                    }

                    $post->save();

                    if($request->input('tags')){
                        $post->tags()->sync( $request->input('tags'));
                    } else {
                        $post->tags()->sync( array() );
                    }
                    Session::flash('flash_success','Thay đổi thành công.');
                    return redirect()->route('list-post');
                }
            } else {
                Session::flash('flash_err','Bạn không có quyền thay đổi.');
                return redirect()->route('list-post');
            }
        } else {
            Session::flash('flash_err','Sai thông tin bài viết.');
            return redirect()->route('list-post');
        }
    }
        
    
    public function updateStatus(Request $request)
    {
        if($request->ajax()){
            $post = $this->post->find($request->input('id'));
            if( $post ){
                if(Auth::user()->role[0]->id == ROLE_ADMIN ){
                    if($request->input('status')== 0 || $request->input('Status')==1 ){
                        $post->status = $request->input('Status');
                        $post->save();
                        return 'ok';
                    } else { return 'Sai trạng thái.';}
                } else { return 'Bạn không đủ quyền'; }
            } else { return 'Bài viết không tồn tại.'; }
        }
    }

    public function updateHot(Request $request)
    {
        if($request->ajax()){
            $post = $this->post->find($request->input('id'));
            if( $post ){
                if(Auth::user()->role[0]->id == ROLE_ADMIN ){
                    if($request->input('Hot')== 0 || $request->input('Hot')==1 ){
                        $post->hot = $request->input('Hot');
                        $post->save();
                        return 'ok';
                    } else { return 'Sai trạng thái.';}
                } else { return 'Bạn không đủ quyền'; }
            } else { return 'Bài viết không tồn tại.'; }
        }
    }
}
