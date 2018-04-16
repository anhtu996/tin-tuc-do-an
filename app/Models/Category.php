<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'Name', 'Url', 'Category_Id', 'IsSubCategory',
    ];

    public function sub_category()
    {
        return $this->hasMany('App\Models\Category','Category_Id','id');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post','Category_Id','id');
    }

    public function hasChilCate(){
        $list = Category::where('Category_Id', $this->id)->pluck('id')->toArray();
        if ($list) {
            return true;
        }
        return false;
    }

    public static function getChilCateId($id){
        $list = Category::where('Category_Id', $id)->pluck('id')->toArray();
        if ($list) {
            return $list;
        }
        
        return $list = array($id);
    }

    public function getChilCate(){
        if ($this->hasChilCate()) {
            $list = Category::where('Category_Id', $this->id)->get();
            return $list;           
        }
    }


    public function getParentCate(){
        $cate = Category::where('id', $this->Category_Id)->get();  
        return $cate[0];
    }

     public function setNameAttribute($value)
    {
        $this->attributes['Name'] = ucwords($value);
    }
    

    

    

}
