<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Eloquent\CategoryRepository as Category;
class MenuComPoser
{
	protected $categories;
	public function __construct(Category $cateRepo)
	{
		$this->categories = $cateRepo->getCateParent();
	}

	public function compose(View $view)
	{            
		
		$view->with('categories', $this->categories);
	}
}