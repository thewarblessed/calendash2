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
                                    <strong>
                                        <h3>Event Requests list</h3>
                                    </strong>
                                    <p class="text-sm">See information about all events</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
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


                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Event Name
                                            </th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Description</th> --}}
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Venue
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Department</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Type
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start
                                                Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End
                                                Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start
                                                Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End
                                                Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Status</th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-7">Action</th> --}}
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
                                        @foreach ($pending as $event)
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
                                                    <p class="text-sm text-dark font-weight-semibold mb-0"
                                                        style="margin-left: 16px">{{ $event->event_name }}</p>
                                                </td>
                                                <td>
                                                    @if ($event->roomName === null)
                                                        <p class="text-sm text-dark font-weight-semibold mb-0">
                                                            {{ $event->venueName }}</p>
                                                    @else
                                                        <p class="text-sm text-dark font-weight-semibold mb-0">
                                                            {{ $event->roomName }}</p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <p class="text-sm text-dark font-weight-semibold mb-0"
                                                        style="margin-left: 16px">{{ $event->department }}</p>
                                                </td>
                                                <td>
                                                    @if ($event->type === 'whole_day')
                                                        <p class="text-sm text-dark font-weight-semibold mb-0">Whole Day
                                                        </p>
                                                    @endif
                                                    @if ($event->type === 'whole_week')
                                                        <p class="text-sm text-dark font-weight-semibold mb-0">Whole
                                                            Week</p>
                                                    @endif
                                                    @if ($event->type === 'within_day')
                                                        <p class="text-sm text-dark font-weight-semibold mb-0">Within
                                                            the Day</p>
                                                    @endif
                                                    {{-- <p class="text-sm text-dark font-weight-semibold mb-0">{{$event->type}}</p> --}}
                                                </td>
                                                <td>
                                                    <p class="text-sm text-dark font-weight-semibold mb-0">
                                                        {{ Carbon\Carbon::parse($event->start_date)->format('j F, Y') }}
                                                    </p>

                                                </td>
                                                <td>
                                                    <p class="text-sm text-dark font-weight-semibold mb-0">
                                                        {{ Carbon\Carbon::parse($event->end_date)->format('j F, Y') }}
                                                    </p>

                                                </td>
                                                <td>
                                                    <p class="text-sm text-dark font-weight-semibold mb-0">
                                                        {{ Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                                    </p>

                                                </td>
                                                <td>
                                                    <p class="text-sm text-dark font-weight-semibold mb-0">
                                                        {{ Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                                    </p>

                                                </td>
                                                <td hidden>
                                                    <p class="text-sm text-dark font-weight-semibold mb-0">
                                                        {{ $event->sect_head }}</p>
                                                </td>
                                                <td class="align-middle text-center">

                                                    @if ($event->status === 'PENDING')
                                                        <span
                                                            class="badge badge-sm border border-warning text-warning bg-warning border-radius-sm ms-sm-3 px-2">{{ $event->status }}</span>
                                                    @endif

                                                    @if ($event->status === 'PENDING' && Auth::user()->role === 'org_adviser' && $event->org_adviser !== null)
                                                        <span
                                                            class="badge badge-sm border border-success text-success bg-success border-radius-sm ms-sm-3 px-2">APPROVED
                                                            BY YOU</span>
                                                    @endif

                                                    {{-- @if ($event->status === 'PENDING' && Auth::user()->role === 'org_adviser' && $event->org_adviser !== null)
                                                <span class="badge badge-sm border border-success text-success bg-success border-radius-sm ms-sm-3 px-2">APPROVED BY YOU</span>
                                                @endif --}}

                                                    @if ($event->status === 'APPROVED')
                                                        <span
                                                            class="badge badge-sm border border-success text-success bg-success border-radius-sm ms-sm-3 px-2">{{ $event->status }}</span>
                                                    @endif
                                                </td>
                                                {{-- <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">{{$event->name}}</span>
                                                
                                            </td> --}}
                                                <td>
                                                    @if ($event->status === 'APPROVED')
                                                        <div class="text-sm text-dark font-weight-semibold mb-0">
                                                            <button type="button" class="btn btn-dark viewDetailsBtn"
                                                                style="width: 150px; height: 40px;"
                                                                data-bs-toggle="modal" data-id="{{ $event->id }}"
                                                                data-bs-target="#viewDetailsModal"
                                                                id="tableViewDetails">View Details</button>
                                                        </div>
                                                    @else
                                                        <div class="text-sm text-dark font-weight-semibold mb-0">
                                                            <button type="button" class="btn btn-dark approveBtn"
                                                                style="width: 110px; height: 40px;"
                                                                data-bs-toggle="modal" data-id="{{ $event->id }}"
                                                                data-bs-target="#approveRequestModal"
                                                                id="tableApprove">Approve</button>
                                                            <button type="button" class="btn btn-danger rejectBtn"
                                                                style="width: 110px; height: 40px;"
                                                                data-id="{{ $event->id }}"
                                                                id="tableReject">Reject</button>
                                                        </div>
                                                    @endif

                                                    {{-- @if (Auth::user()->role === 'org_adviser' && $event->org_adviser !== null)
                                                    <div>IKAW AY ORG ADIVSER</div>
                                                    <span>IKAW AY ORG ADIVSER</span>
                                                @endif --}}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                                <div class="ms-auto">
                                    <button class="btn btn-sm btn-white mb-0">Previous</button>
                                    <button class="btn btn-sm btn-white mb-0">Next</button>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="approveRequestModal" tabindex="-1" role="dialog"
            aria-labelledby="createeventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="createeventModalLabel">Approve Request</h2>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <p style="margin-left: 20px">Are you sure you want to Approve this Request?</p>
                    </div>
                    <div class="modal-body">

                        <form id="eventApprovalForm" enctype="multipart/form-data" method="POST"
                            action="{{ url('/api/request/approve/{id}') }}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Name of the event</label>
                                <input name="eventAuthId" type="text" class="form-control" id="eventAuthId"
                                    value={{ Auth::user()->id }} hidden>
                                <input name="eventApproveId" type="text" class="form-control" id="eventApproveId"
                                    hidden>
                                <input name="eventApproveName" type="text" class="form-control"
                                    id="eventApproveName" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                {{-- <input  required> --}}
                                <textarea name="eventApproveDesc" type="text" class="form-control" id="eventApproveDesc" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">No. of Participants</label>
                                <input name="eventApproveParticipants" type="text" class="form-control"
                                    id="eventApproveParticipants" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Venue</label>
                                <input name="eventApproveVenue" type="text" class="form-control"
                                    id="eventApproveVenue" disabled>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">Request Letter</label>
                                {{-- <input name="eventApproveVenue" type="file" class="form-control" id="eventApproveVenue" required> --}}
                                {{-- <br><button type="button" class="btn btn-info" id="showLetter">Show Letter</button> --}}
                                <div id="pdfContainer"></div>
                                <u><strong><a href="" id="viewAnotherTab">View Letter Here</a></strong></u>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                                    id="modalClose">Close</button>
                                <a type="" class="btn btn-dark" id="eventApprove">Approve Request</a>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="rejectRequestModal" tabindex="-1" role="dialog"
            aria-labelledby="createeventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="createeventModalLabel">Reject Request</h2>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <p style="margin-left: 20px">Are you sure you want to Reject this Request?</p>
                    </div>
                    <div class="modal-body">

                        <form id="eventApprovalForm" enctype="multipart/form-data" method="POST"
                            action="{{ url('/api/request/approve/{id}') }}">
                            @csrf
                            <div class="form-group">
                                <h4 style="text-align: center">Event Description</h4>
                                <label for="exampleFormControlInput1">Name of the event</label>
                                <input name="eventAuthRejectId" type="text" class="form-control"
                                    id="eventAuthRejectId" value={{ Auth::user()->id }} hidden>
                                <input name="eventRejectId" type="text" class="form-control" id="eventRejectId"
                                    hidden>
                                <input name="eventRejectName" type="text" class="form-control"
                                    id="eventRejectName" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                {{-- <input  required> --}}
                                <textarea name="eventRejectDesc" type="text" class="form-control" id="eventRejectDesc" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">No. of Participants</label>
                                <input name="eventRejectParticipants" type="text" class="form-control"
                                    id="eventRejectParticipants" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Venue</label>
                                <input name="eventRejectVenue" type="text" class="form-control"
                                    id="eventRejectVenue" disabled>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">Request Letter</label>
                                {{-- <input name="eventApproveVenue" type="file" class="form-control" id="eventApproveVenue" required> --}}
                                {{-- <br><button type="button" class="btn btn-info" id="showLetter">Show Letter</button> --}}
                                <div id="pdfContainer"></div>
                                <u><strong><a href="" id="viewRejectAnotherTab">View Letter
                                            Here</a></strong></u>

                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Reason of rejection</label>
                                {{-- <input  required> --}}
                                <textarea name="eventRejectReason" type="text" class="form-control" id="eventRejectReason" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                                    id="modalClose">Close</button>
                                <button type="button" class="btn btn-danger" id="eventReject">Reject</button>
                            </div>
                        </form>

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
