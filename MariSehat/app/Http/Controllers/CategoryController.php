<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function addCategoryPage(){
        $category = Category::all();
        return view('/addCategory')->with('category', $category);

    }
    public function addCategory(Request  $request){
        $rules = [
            'category' => 'required|unique:categories,category'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $category = new Category();
        $category->category = $request->category;

        $category->save();
        return redirect()->back();
    }
    public function updateCategoryPage($id){
//        $product = Product::find($id);
        $category = Category::find($id);
        return view('/updateCategory')->with('category', $category);
    }

    public function updateCategory(Request $request, $id){
        $rules = [
            'category' => 'required|unique:categories,category'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withErrors($validator);
        }

        $category = Category::find($id);
        if($category != null) {
            $category->category = $request->category;

            $category->save();
        }else{
            $category = Category::all();
            return view('/addCategory')->with('success','Category updated successfully')->with('category', $category);

        }

        $category = Category::all();

        return view('/addCategory')->with('success','Category updated successfully')->with('category', $category);
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        if($category != null) {
            $category->delete();
        }else{
            $category = Category::all();
            return view('/addCategory')->with('success','Category deleted successfully')->with('category', $category);
        }

        $category = Category::all();
        return view('/addCategory')->with('success','Category deleted successfully')->with('category', $category);
    }
}
