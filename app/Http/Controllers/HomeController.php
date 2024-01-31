<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   function home(Request $request) : View {

    $categories = Category::all();

    $movies = Movie::when($request->query('search'),function($q)use($request){
     $q->where('name','like','%'.$request->query('search').'%');
    })
    ->when($request->query('category'),function($q)use($request){
        $q->whereHas('categories',function($q)use($request){
     $q->where('name',$request->query('category'));
        });
       })->latest()->simplePaginate('10');

    return view('home',compact('categories','movies'));
   }


   function detail($id,$slug) : View {
    
    $movie = Movie::with('categories')->findOrFail($id);
   
    return view('details',compact('movie'));

   }
}
