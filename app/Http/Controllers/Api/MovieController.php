<?php

namespace App\Http\Controllers\Api;

use App\Models\Movie;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MovieRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MovieResource;

class MovieController extends Controller
{
    use FileHandler;
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::with('categories')->get();

        return response()->json(['data'=>MovieResource::collection($movies)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request)
    { 
    DB::transaction(function ()use($request){
       $image =  Self::save_img($request->image,'movies');
        $movie = Movie::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'rate'=>$request->rate,
            'image'=>$image,
            'user_id'=>Auth::id(),
        ]);
        $movie->categories()->sync($request->categories);
    });

        return response()->json(['message'=>'movie created'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $movie = Movie::findOrFail($id);

        return response()->json(['data'=>new MovieResource($movie)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieRequest $request, string $id)
    {     
        $movie = Movie::findOrFail($id);    
        
        if ($movie->user_id == Auth::id()) {
            
            DB::transaction(function ()use($request,$id,$movie){

                $image = str_replace('\\', '/', public_path()) .$movie->image;
    
                if (file_exists($image)) {
                    unlink($image);
                }
    
                $image =  Self::save_img($request->image,'movies');
       
                $movie->update([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'rate'=>$request->rate,
                    'image'=>$image,
                ]);
    
                $movie->categories()->sync($request->categories);
             });
    
            return response()->json(['message'=>'movie updated'],201);
        }
        else
        {
            return response()->json(['message'=>'you are not the owner of this movie'],401);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
          $movie = Movie::findOrFail($id);

           if ($movie->user_id == Auth::id()) {

            $image = str_replace('\\', '/', public_path()) .$movie->image;

            if (file_exists($image)) {
                unlink($image);
            }

            $movie->delete();

            return response()->json(['message'=>'movie deleted'],200);
            }
            else
            {
                return response()->json(['message'=>'you are not the owner of this movie'],401);
            }
    }
}
