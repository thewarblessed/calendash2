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
                                    <strong><h3>Events list</h3></strong>
                                    <p class="text-sm">See information about all events</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-white me-2">
                                        View all
                                    </button>
                                    <a type="button"
                                    href="" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                                <path
                                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                            </svg>
                                        </span>
                                        <span class="btn-inner--text">Add event</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable1"
                                        autocomplete="off" checked>
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable1">Pending</label>

                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable2"
                                        autocomplete="off">
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable2">Approved by Me</label>

                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable3"
                                        autocomplete="off">
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable3">Approved Events</label>

                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable4"
                                        autocomplete="off" >
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable4">All</label>

                                </div>

                                <div class="input-group w-sm-25 ms-auto">
                                    <span class="input-group-text text-body">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search">
                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="eventTable">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-15" >Event Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >Description</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >Event Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >Start Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >End Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >Status</th>
                                            <th class="text-xs font-weight-semibold opacity-15" >Action</th> --}}


                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Event Name</th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Description</th> --}}
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Event Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-9">Status</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-7">Action</th>
                                            <th class="text-secondary opacity-7"></th>


                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2">Description</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">Capacity</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">Capacity</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">Capacity</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">Capacity</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">Capacity</th> --}}
                                            
                                            
                                            {{-- <th class="text-secondary opacity-7"></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody id="eventBody">
                                        @foreach($events as $event)
                                        <tr>
                                            {{-- <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex align-items-center" style="margin-right: 40px">
                                                        
                                                        <img src="{{ asset('storage/'.$event->image) }}" width="100" height="100" style="border-radius: 50%;"/>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center ms-1">
                                                        <h6 class="mb-0 text-sm font-weight-semibold">{{$event->name}}</h6>
                                                        <p class="text-sm text-secondary mb-0">
                                                        </p>
                                                    </div>
                                                </div>
                                            </td> --}}
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0" style="margin-left: 16px">{{$event->event_name}}</p>
                                                
                                            </td>
                                            {{-- <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$event->description}}</p>
                                                
                                            </td> --}}
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{Carbon\Carbon::parse($event->event_date)->format('j F, Y')}}</p>
                                                
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{Carbon\Carbon::parse($event->start_time)->format('g:i A')}}</p>
                                                
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{Carbon\Carbon::parse($event->end_time)->format('g:i A')}}</p>
                                                
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($event->status === "PENDING")
                                                <span class="badge badge-sm border border-warning text-warning bg-warning border-radius-sm ms-sm-3 px-2">{{$event->status}}</span>
                                                @endif

                                                @if($event->status === "APPROVED")
                                                <span class="badge badge-sm border border-success text-success bg-success border-radius-sm ms-sm-3 px-2">{{$event->status}}</span>
                                                @endif
                                            </td>
                                            {{-- <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">{{$event->name}}</span>
                                                
                                            </td> --}}
                                            <td >
                                                <div class="text-sm text-dark font-weight-semibold mb-0">
                                                    <button type="button" class="btn btn-dark approveBtn" style="width: 110px; height: 40px;" data-bs-toggle="modal" data-id="{{$event->id}}" data-bs-target="#approveRequestModal" id="tableApprove">Approve</button>
                                                    <button type="button" class="btn btn-danger rejectBtn" style="width: 110px; height: 40px;" data-id="{{$event->id}}">Reject</button>
                                                </div>
                                            </td>
                                            
                                            
                                            
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                                <div class="ms-auto">
                                    <button class="btn btn-sm btn-white mb-0">Previous</button>
                                    <button class="btn btn-sm btn-white mb-0">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="approveRequestModal" tabindex="-1" role="dialog" aria-labelledby="createeventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h2 class="modal-title" id="createeventModalLabel" >Approve Request</h2>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div>
                        <p style="margin-left: 20px">Are you sure you want to Approve this Request?</p>
                    </div>
                    <div class="modal-body">
               
                        <form id="eventUpdateForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                              <label for="exampleFormControlInput1">Name of the event</label>
                              <input name="eventApproveId" type="text" class="form-control" id="eventApproveId" hidden>
                              <input name="eventApproveName" type="text" class="form-control" id="eventApproveName" disabled >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                {{-- <input  required> --}}
                                <textarea name="eventApproveDesc" type="text" class="form-control" id="eventApproveDesc" disabled ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">No. of Participants</label>
                                <input name="eventApproveParticipants" type="text" class="form-control" id="eventApproveParticipants" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Venue</label>
                                <input name="eventApproveVenue" type="text" class="form-control" id="eventApproveVenue" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Request Letter</label>
                                {{-- <input name="eventApproveVenue" type="file" class="form-control" id="eventApproveVenue" required> --}}
                                {{-- <br><button type="button" class="btn btn-info" id="showLetter">Show Letter</button> --}}
                                <div id="pdfContainer"></div>
                                <u><strong><a href="" id="viewAnotherTab">View Letter Here</a></strong></u>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal" id="modalClose">Close</button>
                                <button type="submit" class="btn btn-dark" id="eventUpdate">Approve Request</button>
                                <button type="button" class="btn btn-danger" id="eventReject">Reject</button>
                            </div>
                        </form>
                
                    </div>
                    
                </div>
                </div>
            </div>
           
            {{-- <x-app.footer /> --}}
        </div>
    </main><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>
