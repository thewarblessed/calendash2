<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h3>Venues list</h3>
                                    <p class="text-sm">See information about all venues</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="container">
                                    <div class="row">
                                        @foreach($venues as $venue)
                                            <div class="col-sm">
                                                <div class="card" style="width: 15rem; margin-bottom: 30px; border: 2px solid rgb(216, 200, 231)">
                                                    <img src="{{asset('storage/'.$venue->image)}}" height="200" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                    <h5 class="card-title">{{$venue->name}}</h5>
                                                    <p class="card-text">{{$venue->description}}</p>
                                                    <a href="#" class="btn btn-info">Info</a>
                                                    <a href="#" class="btn btn-primary">Check</a>
                                                    </div>
                                                </div>       
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

</x-app-layout>
