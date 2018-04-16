<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\CategoryRepository as Category;
use App\Repositories\Eloquent\PostRepository as Post;
use App\Repositories\Eloquent\TagRepository as Tag;
use App\Repositories\Eloquent\UserRepository as User;
use Validator;
use Auth;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
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

    public function getLogin()
    {
    	if (Auth::check())
		{
		   return redirect()->route('dashboard');
		}
    	return view('admin.login');
    }

    public function postLogin(Request $request)
    {

    	$rules = [
    		'email' => 'required | email | max : 25 ',
    		'password' => 'required | min: 8'
    	];

    	$msg = [
		    'required' => ':attribute không được bỏ trống.',
		    'password.min' => 'Password phải lớn hơn :min ký tự.',
		    'email.email' => 'Email phải đúng định dạng.',
		];
	
    	$validator = Validator::make($request->all(), $rules , $msg);

    	if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {
        	$email = $request->input('email');
        	$password = $request->input('password');

        	
        	if( Auth::attempt(['email' => $email, 'password' => $password], $request->input('remember') ) ){
        		return redirect()->route('dashboard');

        	} else {

        		$msg = new MessageBag(['errlogin'=> 'Sai thông tin đăng nhập.']);
        		return redirect()->back()->withErrors($msg);
        	}
        }
    }
    
    public function getLogout()
    {
        if( Auth::check() ) 
            Auth::logout();
        return redirect()->route('login');
    }
}