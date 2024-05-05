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
                                    <strong><h3>Events list</h3></strong>
                                    <p class="text-sm">See information about all events</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="eventOutsiderTable">
                                    
                                    <thead class="bg">
                                        <tr>

                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Event Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Venue</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Requester Name</th>
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
                                        @foreach($pending as $event)
                                        <tr>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0" style="margin-left: 16px">{{$event->event_name}}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$event->name}}</p>
                                                
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$event->eventOrganizer}}</p>
                                                
                                            </td>
                                            <td>
                                                @if ($event->type === 'whole_day')
                                                <p class="text-sm text-dark font-weight-semibold mb-0">Whole Day</p>
                                                @endif
                                                @if ($event->type === 'whole_week')
                                                <p class="text-sm text-dark font-weight-semibold mb-0">Whole Week</p>
                                                @endif
                                                @if ($event->type === 'within_day')
                                                <p class="text-sm text-dark font-weight-semibold mb-0">Within the Day</p>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{Carbon\Carbon::parse($event->start_date)->format('j F, Y')}}</p>
                                                
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{Carbon\Carbon::parse($event->end_date)->format('j F, Y')}}</p>
                                                
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{Carbon\Carbon::parse($event->start_time)->format('g:i A')}}</p>
                                                
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{Carbon\Carbon::parse($event->end_time)->format('g:i A')}}</p>
                                                
                                            </td>
                                            <td hidden>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$event->sect_head}}</p>
                                            </td>
                                            <td class="align-left">
                                                    @if($event->receipt_image != null) 
                                                    <span class="badge badge-sm border border-success text-success bg-success border-radius-sm ms-sm-3 px-2">RECEIPT RECEIVED</span>
                                                    @else
                                                    <span class="badge badge-sm border border-warning text-warning bg-warning border-radius-sm ms-sm-3 px-2">WAITING FOR RECEIPT</span>
                                                    @endif
                                            </td>
                                            {{-- <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">{{$event->name}}</span>
                                                
                                            </td> --}}
                                            <td>
                                                @if($event->receipt_image != null) 
                                                <div class="text-sm text-dark font-weight-semibold mb-0">
                                                    <button type="button" class="btn btn-dark approveBtnOutsiderReceipt" style="width: 110px; height: 40px;" data-id="{{$event->id}}" id="tableApprove">Approve</button>
                                                    {{-- <button type="button" class="btn btn-danger rejectBtn" style="width: 110px; height: 40px;" data-id="{{$event->id}}" id="tableReject">Reject</button> --}}
                                                @else
                                                <div class="text-sm text-dark font-weight-semibold mb-0">
                                                    {{-- <button type="button" class="btn btn-dark approveBtnOutsider" style="width: 110px; height: 40px;" data-id="{{$event->id}}" id="tableApprove">Approve</button>
                                                    <button type="button" class="btn btn-danger rejectBtn" style="width: 110px; height: 40px;" data-id="{{$event->id}}" id="tableReject">Reject</button> --}}
                                                </div>
                                                @endif

                                                {{-- @if(Auth::user()->role === 'org_adviser' && $event->org_adviser !== null)
                                                    <div>IKAW AY ORG ADIVSER</div>
                                                    <span>IKAW AY ORG ADIVSER</span>
                                                @endif --}}
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

            <div class="modal fade" id="approveOutsiderReceiveReceiptModal" tabindex="-1" role="dialog" aria-labelledby="createeventModalLabel" aria-hidden="true">
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
               
                        <form id="eventApprovalForm" enctype="multipart/form-data" method="POST" action="{{ url('/api/request/approve/{id}') }}" >
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Name of the event:</label>
                                        <p style="color: black" id="eventApproveName" ></p>
                                        <input name="eventOutsiderId" type="text" class="form-control" id="eventOutsiderId" value={{Auth::user()->id}} hidden>
                                        <input name="eventApproveId" type="text" class="form-control" id="eventApproveId" hidden>
                                        {{-- <input name="eventApproveName" type="text" class="form-control" id="eventApproveName" disabled > --}}
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Venue</label>
                                        <p style="color: black" id="eventApproveVenue" ></p>
                                        {{-- <input name="eventApproveVenue" type="text" class="form-control" id="eventApproveVenue" disabled> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                {{-- <input  required> --}}
                                <textarea name="eventApproveDesc" type="text" class="form-control" id="eventApproveDesc" disabled ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Requester</label>
                                <p style="color: black" id="eventApproveRequester" ></p>
                                {{-- <input name="eventApproveParticipants" type="text" class="form-control" id="eventApproveParticipants" disabled> --}}
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">No. of Participants</label>
                                <p style="color: black" id="eventApproveParticipants" ></p>
                                {{-- <input name="eventApproveParticipants" type="text" class="form-control" id="eventApproveParticipants" disabled> --}}
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="exampleFormControlInput1" style="font-size: 18px">Please input the amount to be paid:</label>
                                {{-- <input  required> --}}
                                <input name="amount" type="number" class="form-control" id="amount" min="0" autofocus placeholder="Enter amount...">
                            </div>

                            {{-- <div class="form-group">
                                <label for="exampleFormControlInput1" style="font-size: 18px">Upload Quotation:</label>
                                <input name="quotation" type="file" class="form-control" id="amount" min="0" placeholder="Uplaod Quotation">
                            </div> --}}
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal" id="modalClose">Close</button>
                                <a type="" class="btn btn-dark" id="eventOutsiderApprove">Approve Request</a>
                                {{-- <button type="button" class="btn btn-danger" id="eventReject">Reject</button> --}}
                            </div>
                        </form>
                
                    </div>
                    
                </div>
                </div>
            </div>

            <div class="modal fade" id="checkReceiptModal" tabindex="-1" role="dialog" aria-labelledby="createeventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="createeventModalLabel" >Uploaded Receipt</h2>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
               
                        <form id="eventApprovalForm" enctype="multipart/form-data" method="POST" action="{{ url('/api/request/approve/{id}') }}" >
                            @csrf

                            <div class="form-group">
                                <input name="event_id" type="text" class="form-control" id="event_id_of_outsider" hidden>
                                <div id="checkReceiptIdContainer">

                                </div>
                              </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal" id="modalClose">Close</button>
                                <a type="" class="btn btn-dark" id="eventOutsiderApproveReceipt">Approve Request</a>
                                {{-- <button type="button" class="btn btn-danger" id="eventReject">Reject</button> --}}
                            </div>
                        </form>
                
                    </div>
                    
                </div>
                </div>
            </div>
           
            {{-- <x-app.footer /> --}}
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</x-app-layout>
