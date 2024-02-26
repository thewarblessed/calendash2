<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card my-5">
                        <div class="card-header">
                            <h5 class="card-title">Rules and Regulations</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                <!-- Fetch and display description from the database -->
                                @foreach ($venues as $venue)
                                    <h5 class="card-title" style="text-align: center">{{$venue->name}}</h5>
                                    <div class="text-center"> <!-- Added text-center class here -->
                                        <img src="{{ asset('storage/'.$venue->image) }}" width="500" height="300" style="border-radius: 8px;"/>
                                    </div>
                                    <br>
                                    <ul>
                                        @foreach (explode("\n", $venue->description) as $bullet)
                                            <li>{{ $bullet }}</li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ url('venues')}}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
