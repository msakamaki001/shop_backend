<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Items;

class ManagerController extends Controller
{
    public function index()
    {
        $items = Items::join('category','items.category_id','=','category.id')->select('items.id as id','items.name as item_name','price','num','category.name as category_name')->Paginate(10);
        return view('top', compact('items'));
    }
}
