<style>
#containerfluid{

}

</style>

<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" id="main">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5" id="containerfluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-xs border">
                        <div class="card-header pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h3 class="mb-0 font-weight-semibold">Create an Event</h3>
                                    <p class="text-sm mb-sm-0 mb-2">Please fill out the forms below.</p>
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                  <label for="eventName">Name of the Event</label>
                                  <input type="text" class="form-control" id="eventName" >
                                </div>

                                <div class="form-group">
                                    <label for="filterCapacity">Filter by Capacity</label>
                                    <input type="number" class="form-control" id="filterCapacity" min="0">
                                </div>                                

                                  <div class="form-group">
                                    <label for="exampleFormControlInput1">Role: </label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" disabled value="{{auth()->user()->role}}">
                                  </div>

                                  <div class="form-group">
                                    <label for="exampleFormControlSelect1">Estimated no. of participants </label>
                                    <input id="numOfpart" type="number" class="form-control" id="participants" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                  </div>

                                  <div class="form-group">
                                        <h6 style="text-align: center; padding: 10px">AVAILABLE VENUES</h6>
                                        <div class="container">
                                            <div class="row">
                                                @foreach($venues as $venue)
                                                    <div class="col-sm">
                                                        {{-- <div id="venue{{$venue->id}}" class="card" style="width: 15rem; margin-bottom: 20px; border: 4px solid rgb(53, 9, 86)"> --}}
                                                        <div id="venue{{$venue->id}}" data-capacity="{{$venue->capacity}}" class="card_capacity" style="width: 15rem; margin-bottom: 20px; border: 4px solid rgb(53, 9, 86)">
                                                            <img src="{{asset('storage/'.$venue->image)}}" height="180" class="card-img-top" alt="...">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{$venue->name}}</h5>
                                                                <p class="card-text">{{$venue->description}}</p>
                                                                <p class="card-text">Capacity: {{$venue->capacity}}</p>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="customRadio2">
                                                                        <label class="custom-control-label" for="customRadio2" style="color: blue; font-size: 18px"><strong>SELECT</strong> </label>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                  </div>
                                
                                  <div class="text-center">
                                    <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Next</button>
                                </div>
                            </form>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>