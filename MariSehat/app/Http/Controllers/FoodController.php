<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;
class FoodController extends Controller
{
    public function AllFood(){
        $foods = Food::latest()->paginate(5);
        return view('food', compact('foods'));

    }
    public function AddFood(Request $request){
        $validated = $request->validate([
            'foodName' => 'required|unique:food|max:255',
            'foodCalorie' => 'required|numeric|between:0,99.99',
            'foodInformation' => 'required|max:255',
            'foodImage' => 'required|mimes:jpg,jpeg,png',

        ],
        [
            'foodName.required' => 'Please input food name',
            'foodCalorie.required' => 'Please input food calorie',
            'foodInformation.required' => 'Please input food information',
            'foodCalorie.between'=>'The food calorie must be between 0 and 100',
            'foodName.max' => 'Food name should be less than 255',
            'foodInformation.max' => 'Food information should be less than 255',

        ]
        );
        $foodImage = $request->file('foodImage');
        $nameGen = hexdec(uniqid());
        $imgExt = strtolower($foodImage->getClientOriginalExtension());
        $imgName = $nameGen.'.'.$imgExt;
        $upLocation = 'header/';
        $lastImg = $upLocation.$imgName;
        $foodImage->move( $upLocation,$imgName);

        Food::insert([
            'foodName'=> $request -> foodName,
            //  'user_id' => Auth::user() ->id,
            'foodCalorie'=> $request -> foodCalorie,
            'foodInformation'=> $request -> foodInformation,
            'foodImage' => $lastImg,


        ]);

        // $category =  new Category;
        // $category->category_name = $request -> category_name;
        // $category->user_id = Auth::user() ->id;
        // $category->save();

        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->insert($data);

        return Redirect()->back()->with('success','Food Inserted Succesfully');
    }
}