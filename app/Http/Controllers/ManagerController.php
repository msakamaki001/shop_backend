<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Items;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ManagerController extends Controller
{
    public function index()
    {
        $items = Items::join('category','items.category_id','=','category.id')->select('items.id as id','items.name as item_name','price','num','category.name as category_name')->Paginate(10);
        return view('top', compact('items'));
    }

    // api
    public function item_list() {
        $items = Items::join('category','items.category_id','=','category.id')->select('items.id as id','items.name as item_name','price','num','category_id','category.name as category_name','image_path')->Paginate(10);
        return $items;
    }

    // api
    public function category_list() {
        $category_list = Category::all();
        return $category_list;
    }

    // api
    public function category_list_paginate() {
        $category_list = Category::Paginate(10);
        return $category_list;
    }

    // api
    public function change_item_name(Request $request, Items $items) {
        return $items::where('id',$request->id)->update(['name' => $request->item_name]);
    }

    // api
    public function change_item_price(Request $request, Items $items) {
        return $items::where('id',$request->id)->update(['price' => $request->item_price]);
    }

    // api
    public function change_item_num(Request $request, Items $items) {
        return $items::where('id',$request->id)->update(['num' => $request->item_num]);
    }

    // api
    public function change_item_category(Request $request, Items $items) {
        return $items::where('id',$request->id)->update(['category_id' => $request->item_category]);
    }

    // api
    public function change_item_image(Request $request, Items $items) {
        Log::info($request->file('file')->getClientOriginalName());
        
        $file = $request->file('file');
        $path = Storage::disk("public")->putFile('images', $file);
        $remove_name = basename($items::where('id',$request->id)->select('image_path')->first()->image_path);
        Log::info($remove_name);
        if ($remove_name != 'noimage.png') {
            if (Storage::exists('public/images/'. $remove_name)) {
                Storage::delete('public/images/' . $remove_name);
            } else {
                Log::info('存在しない');
            }
        }
        $image_path = "http://localhost/storage/".$path;
        $items::where('id',$request->id)->update(['image_path' => $image_path]);
        return $image_path;
    }

    // api
    public function remove_item(Request $request, Items $items) {
        return $items::where('id',$request->id)->delete();
    }

    // api
    public function create_item(Request $request, Items $items) {
        Log::info($request->file('file')->getClientOriginalName());
        $file = $request->file('file');
        $path = Storage::disk("public")->putFile('images', $file);
        $image_path = "http://localhost/storage/".$path;
        return $items::insert(['name' => $request->item_name, 'price' => $request->item_price, 'num' => $request->item_num, 'category_id' => $request->item_category, 'image_path' => $image_path]);
    }

    // api
    public function change_category_name(Request $request, Category $category) {
        return $category::where('id',$request->id)->update(['name' => $request->category_name]);
    }

    // api
    public function create_category(Request $request, Category $category) {
        return $category::insert(['name' => $request->category_name]);
    }

    // api
    public function remove_category(Request $request, Category $category) {
        return $category::where('id',$request->id)->delete();
    }
}
