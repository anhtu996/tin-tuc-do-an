<?php  

define('ROLE_ADMIN', 100);
define('ROLE_USER', 500);

if(!function_exists('get_options')){
  	function get_options($array, $parent=null, $indent="", $forget = null) {
      	// Return variable
      	$return = [];
      	for ($i=0; $i < count($array); $i++) {
          $val = $array[$i];
            if($val->Category_Id == $parent && $val->id != $forget) {
            $return["x".$val->id] = $indent . $val->Name;
            $return = array_merge($return, get_options($array, $val->id, "--".$indent, $forget));
          }
        }
        return $return;
    }
}

if(!function_exists('uploadImage')){
    function uploadImage($file){
      //Upload Image
        $file_extension = $file->extension(); // Lấy đuôi của file
        if($file_extension != 'png' && $file_extension != 'jpg' && $file_extension != 'jpeg'){
            return redirect()->back()->with('errfile','Chưa hỗ trợ định dạng file vừa upload.');
        }

        $file_name = $file->getClientOriginalName();
        $random_file_name = uniqid().'_'.$file_name;
        $path = $file->storeAs('public/uploads', $random_file_name);
        $path = str_replace('public','storage',$path);
        return $path;
    }
}






?>