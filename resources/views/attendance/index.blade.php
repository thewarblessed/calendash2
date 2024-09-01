<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="" style="text-align: center">
                                <div>
                                    <strong><h3>Your Ongoing Events</h3></strong>
                                    <p class="text-sm">Click to check attendance</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                {{-- <table class="table align-items-center mb-0" id="eventTable">
                                    
                                    <thead class="bg-gray-100">
                                        <tr>

                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Event Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Venue</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Type</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Status</th>
                                            <th class="text-secondary opacity-7"></th>
                                            


                                        </tr>
                                    </thead>
                                    <tbody id="eventBody">
                                       

                                    </tbody>
                                </table> --}}
                            </div>
                            
                        </div>
                    </div>
                </div>

                {{-- <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    @foreach ($events as $event)
                                        <div class="card" style="width: 15rem; margin-bottom: 30px; border: 2px solid rgb(216, 200, 231)">
                                            <img src="{{ asset('storage/'.$event->image) }}" height="200" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $event->event_name }}</h5>
                                                    <a href="{{ route('singleAttendance', ['id' => $event->id]) }}" class="btn btn-info mr-2" style="flex: 1;">Attendance</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card-body p-3">
                    <div class="row">
                        @if ($events->isEmpty())
                            <div class="col-12 text-center">
                                <img src="https://static.vecteezy.com/system/resources/previews/010/726/317/original/no-event-filled-line-style-icon-empty-states-vector.jpg" width="250" height="250" style="border-radius: 20px" alt="Description of the image">
                                <p>You have no ongoing events yet</p>
                            </div>
                        @else
                            @foreach ($events as $event)
                                <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                                    <div class="card card-background border-radius-xl card-background-after-none align-items-start mb-4">
                                        <div class="full-background bg-cover" style="background-image: url('https://i.pinimg.com/originals/63/be/5f/63be5f30749ff7be7bb4a633ffac763f.gif'); background-size: cover;"></div>
                                        <span class="mask bg-dark opacity-1 border-radius-sm"></span>
                                        <div class="card-body text-start p-3 w-100">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div
                                                        class="blur shadow d-flex align-items-center w-100 border-radius-md border border-white mt-8 p-3">
                                                        <div class="w-50">
                                                            <p class="text-dark text-sm font-weight-bold mb-1">{{ $event->event_name }}</p>
                                                            <p class="text-xs text-secondary mb-0">{{ $event->start_date }}</p>
                                                        </div>
                                                        {{-- <p class="text-dark text-sm font-weight-bold ms-auto">Growth
                                                        </p> --}}
                                                        <a class="text-dark text-sm font-weight-bold ms-auto border border-primary rounded p-1" href="{{ route('singleAttendance', ['id' => $event->id]) }}">
                                                            Check Attendance
                                                            <i class="fas fa-arrow-right-long text-sm ms-1" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('singleAttendance', ['id' => $event->id]) }}">
                                        <h4 class="font-weight-semibold">
                                            {{ $event->event_name }}
                                        </h4>
                                    </a>
                                    <p class="mb-4">
                                        {{ $event->description }}
                                    </p>
                                    
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

           
           
            {{-- <x-app.footer /> --}}
        </div>
    </main>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="sweetalert2.min.js"></script>
    <script src="sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
</x-app-layout>
