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
                                    <strong><h3>Your Events</h3></strong>
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

                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    @foreach ($events as $event)
                                    {{-- <div class="col-sm"> --}}
                                        <div class="card" style="width: 15rem; margin-bottom: 30px; border: 2px solid rgb(216, 200, 231)">
                                            <img src="{{ asset('storage/'.$event->image) }}" height="200" class="card-img-top" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $event->event_name }}</h5>
                                                    <a href="{{ route('singleAttendance', ['id' => $event->id]) }}" class="btn btn-info mr-2" style="flex: 1;">Attendance</a>
                                                    {{-- <a href="{{ route('venueEventlist', ['id' => $event->id]) }}" class="btn btn-primary ml-2" style="flex: 1;">Event List</a> --}}
                                               </div>
                                        </div>
                                    {{-- </div>    --}}
                                    @endforeach
                                </div>
                            </div>
                        </div>
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
