<?php

namespace App\Repositories\Eloquent;
use App\Models\Category;
use App\Repositories\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return Category::class;
    }

    public function getCateParent()
    {
        return $this->model->where('Category_Id', null)->get();
    }
}