<x-app-layout>
    <div class="container mt-5">
        <div class="card">
            <img class="card-img-top" id="image" src="{{asset($movie->image)}}" alt="Card image cap" style="height: 450px">
            <div class="card-body text-center">
                <h5 class="card-title" id="name">{{$movie->name}}</h5>
                <p class="card-text" id="description">{{$movie->description}}</p>
                <h6 class="mt-2">Categories</h6>
                <ul id="categories">
                    @foreach ($movie->categories as $category)
                    <li class="badge badge-primary">{{$category->name}}</li>
                    @endforeach
                   
                </ul>
                <h6 class="mt-2">Rating</h6>
                <p id="rating" style="color: rgb(121, 121, 33)">{{$movie->rate}}/10</p>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</x-app-layout>