<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

use Auth;
use Session;
use App\User;
use Validator;

class ProfileController extends Controller
{
    public function getProfile()
    {
    	$profile = User::find(Auth::user()->id);

    	return view('admin.author.profile',['profile'=>$profile]);
    }

    public function profileUpdate(Request $request)
    {     
        $rules= [
            'name'=>['required','min:6','max:100',Rule::unique('users')->ignore(Auth::user()->id)],
            'email'=> ['required', 'email', Rule::unique('users')->ignore(Auth::user()->id) ],
            'birthday'=> 'date',
        ];
    	
    	$msg = [
			'required'=>'Không được bỏ trống :attribute.',
			'name.unique' => 'Tên này đã bị trùng, vui lòng nhập lại!',
			'name.min'=>'Tên gồm ít nhất 3 ký tự!',
			'name.max'=>'Tên gồm tối đa 100 ký tự!',
			'email'=>'Email không chính xác.',
			'email.unique'=> 'Email đã tồn tại.',
			'birthday.date' => 'Sai định dạng ngày!',
		];
		$validator = Validator::make($request->all(), $rules , $msg);

		if ($validator->fails()) {
		    return redirect()->back()
		                ->withErrors($validator)
		                ->withInput();
		} else {
			$profile = User::find(Auth::user()->id);
			$profile->name = $request->input('name');
	    	$profile->email = $request->input('email');
	    	$profile->birthday = $request->input('birthday');
	    	// $profile->password= bcrypt($request->input('password'));

            //Upload Image
            if($request->hasFile('avatar')){
                $file = $request->file('avatar');
                $file_extension = $file->extension(); // Lấy đuôi của file
                if($file_extension != 'png' && $file_extension != 'jpg' && $file_extension != 'jpeg'){
                    return redirect()->back()->with('errfile','Chưa hỗ trợ định dạng file vừa upload.');
                }

                $file_name = $file->getClientOriginalName();
                $random_file_name = uniqid().'_'.$file_name;
                $path = $file->storeAs('public/uploads', $random_file_name);
                $path = str_replace('public','storage',$path);
                $profile->avatar = $path;
            } 
            
            $profile->save();
	    	Session::flash('flash_success','Thay đổi thành công.');
    		return redirect()->back();
		}
    }
}
