<x-app-layout>
       <!-- Search form -->
       <div class="container mt-3">
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>

    <!-- Category Filter form -->
    <div class="container mt-3">
        <form class="form-inline my-2 my-lg-0">
            <select class="form-control mr-sm-2" id="category" name="category">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                <option value="{{$category->name}}">{{$category->name}}</option>
                @endforeach

                <!-- Add as many categories as you need -->
            </select>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filter</button>
        </form>
    </div>

    <!-- Movie list -->
    <div class="container mt-3">
        <div class="row">
            @foreach ($movies as $movie)
            <div class="col-sm-4">
                <div class="card">
                    
                    <a href="{{route('detail',['id'=>$movie->id,'slug'=>Str::slug($movie->name,'-')])}}">  <img class="card-img-top" src="{{asset($movie->image)}}" alt="Movie image" style="height: 250px;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{$movie->name}}</h5></a>
                        <p class="card-text">Rating: <span style="color: rgb(121, 121, 33)">{{$movie->rate}}/10</span></p>
                    </div>
                </div>
            </div>
            @endforeach

          
            <!-- Repeat this div for each movie in your database -->
        </div>
       <div class="p-3">
        {{$movies->links()}}
       </div>
    </div>

  
</x-app-layout>
