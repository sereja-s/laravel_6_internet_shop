<?php


namespace App\ViewComposers;

use App\Models\Category;
use Illuminate\View\View;

// Laravel: интернет магазин ч.31: ViewComposer, Collection (map, flatten, take, mapToGroups)

/** 
 * Класс отвечает за добавление категорй
 */
class CategoriesComposer
{
	public function compose(View $view)
	{
		$categories = Category::get();
		$view->with('categories', $categories);
	}
}
