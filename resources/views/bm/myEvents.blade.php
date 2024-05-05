<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">

            <!-- Create Event Modal -->
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Status of your Request</h6>
                                </div>
                                <div class="ms-auto d-flex">
                                    <div class="input-group input-group-sm ms-auto me-2">
                                        <span class="input-group-text text-body">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                                </path>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control form-control-sm" placeholder="Search">
                                    </div>
                                    {{-- <button type="button"
                                        class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0 me-2">
                                        <span class="btn-inner--icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" class="d-block me-2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </span>
                                        <span class="btn-inner--text">Download</span>
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0" id="eventOutsiderStatus">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">
                                                Event Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start
                                                Time
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End
                                                Time
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Status</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($eventForUser as $event)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2">
                                                        {{-- <div
                                                            class="avatar avatar-sm rounded-circle bg-gray-100 me-2 my-2">
                                                            <img src="../assets/img/small-logos/logo-spotify.svg"
                                                                class="w-80" alt="spotify">
                                                        </div> --}}
                                                        <div class="my-auto">
                                                            <u><strong><a href="" data-bs-toggle="modal"
                                                                        data-bs-target="#checkMoreModal"
                                                                        style="color: black">{{ $event->event_name }}</a></strong>
                                                            </u>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-normal mb-0">
                                                        {{ Carbon\Carbon::parse($event->start_date)->format('j F, Y') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-sm font-weight-normal">{{ Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-sm font-weight-normal">{{ Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</span>
                                                </td>
                                                <td>

                                                    @if ($event->status === 'APPROVED')
                                                        <span
                                                            class="badge badge-sm border border-success text-success bg-success">
                                                            <svg width="9" height="9" viewBox="0 0 10 9"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                stroke="currentColor" class="me-1">
                                                                <path d="M1 4.42857L3.28571 6.71429L9 1"
                                                                    stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg>
                                                            APPROVED
                                                        </span>
                                                    @endif

                                                    @if ($event->status === 'PENDING')
                                                        <span style="font-size: 12px"
                                                            class="badge badge-sm border border-warning text-warning bg-warning">
                                                            <svg width="12" height="12"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" class="me-1ca">
                                                                <path fill-rule="evenodd"
                                                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            PENDING
                                                        </span>
                                                        {{-- <p class="text-secondary text-sm mb-0">{{$status}}</p> --}}
                                                    @endif

                                                    @if ($event->status === 'REJECTED')
                                                        <span style="font-size: 12px"
                                                            class="badge badge-sm border border-danger text-danger bg-danger">
                                                            <svg width="12" height="12"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                fill="currentColor" class="me-1ca">
                                                                <path fill-rule="evenodd"
                                                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            REJECTED
                                                        </span>
                                                        {{-- <p class="text-secondary text-sm mb-0">{{$status}}</p> --}}
                                                    @endif

                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex">
                                                        <div class="ms-2">
                                                                <button type="button" class="btn btn-dark btn-sm checkMore"
                                                                data-bs-toggle="modal" data-id="{{ $event->id }}"
                                                                data-bs-target="#checkMoreModal">View Details</button>

                                                            @php
                                                                $hasOutsideEvent = DB::table('outside_events')->where('event_id', $event->id)->exists();
                                                            @endphp

                                                            @if ($hasOutsideEvent && $event->receipt_image == null)
                                                                <button type="button" class="btn btn-dark btn-sm uploadImgReceipt"
                                                                         data-id="{{ $event->id }}">Upload Receipt</button>
                                                            @endif

                                                            {{-- @if ($event->receipt_image == null)
                                                                <button type="button" class="btn btn-dark btn-sm uploadImg"
                                                                        data-bs-toggle="modal" data-id="{{ $event->id }}"
                                                                        data-bs-target="#checkMoreModal">Upload Receipt</button>
                                                            @endif --}}

                                                            
                                                            {{-- <button type="button" class="btn btn-dark btn-sm checkStatus"
                                                                data-bs-toggle="modal" data-id="{{ $event->id }}"
                                                                data-bs-target="#checkStatusModal">View Status</button> --}}
                                                            {{-- <a type="button" class="btn btn-dark btn-sm checkMore" data-bs-toggle="modal" data-id="{{$event->id}}" data-bs-target="#checkMoreModal" id="checkMoreBtn">Check More</a> --}}
                                                            {{-- <button type="button" class="btn btn-dark approveBtn" style="width: 110px; height: 40px;" data-bs-toggle="modal" data-id="{{$event->id}}" data-bs-target="#approveRequestModal" id="tableApprove">Approve</button> --}}
                                                            {{-- <a class="text-dark text-sm mb-0">CHECK</a> --}}
                                                            {{-- <p class="text-secondary text-sm mb-0">Expiry 06/2026</p> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="border-top py-3 px-3 d-flex align-items-center">
                                <button class="btn btn-sm btn-white d-sm-block d-none mb-0">Previous</button>
                                <nav aria-label="..." class="ms-auto">
                                    <ul class="pagination pagination-light mb-0">
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link font-weight-bold">1</span>
                                        </li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold"
                                                href="javascript:;">2</a></li>
                                        <li class="page-item"><a
                                                class="page-link border-0 font-weight-bold d-sm-inline-flex d-none"
                                                href="javascript:;">3</a></li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold"
                                                href="javascript:;">...</a></li>
                                        <li class="page-item"><a
                                                class="page-link border-0 font-weight-bold d-sm-inline-flex d-none"
                                                href="javascript:;">8</a></li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold"
                                                href="javascript:;">9</a></li>
                                        <li class="page-item"><a class="page-link border-0 font-weight-bold"
                                                href="javascript:;">10</a></li>
                                    </ul>
                                </nav>
                                <button class="btn btn-sm btn-white d-sm-block d-none mb-0 ms-auto">Next</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="checkMoreModal" tabindex="-1" role="dialog"
            aria-labelledby="createeventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="createeventModalLabel">EVENT DETAILS</h2>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <div>
                        <p style="margin-left: 20px; text-align:center; margin-top: 10px">EVENT DETAILS</p>
                    </div> --}}
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Status</label>
                            <span id="eventStatusText" name="eventStatusText" style="font-size: 16px"
                                class="badge badge-sm border border-warning text-warning bg-warning">
                                <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" class="me-1ca">
                                    <path fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Date Requested:</label>
                            <span id="eventDateRequestedText" name="eventStatusText" style="font-size: 16px">
                                
                            </span>
                        </div>

                        <div style="font-size: 14px; background-color:rgb(39, 5, 95); border-radius: 25px; " id="outsiderTimeline">
                            <div class="rightbox">
                                <div class="rb-container">
                                  <ul class="rb" id="statusList">

                                    <li class="rb-item" ng-repeat="itembx">
                                      <div class="timestamp">
                                        <br> <span></span>
                                      </div>
                                      <div class="item-title"></div>
                                    </li>

                                  </ul>
                                </div>
                              </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Name of the event</label>
                            {{-- <input name="eventAuthId" type="text" class="form-control" id="eventAuthId" value={{Auth::user()->id}} hidden> --}}
                            {{-- <input name="eventApproveId" type="text" class="form-control" id="eventApproveId" hidden> --}}
                            <input name="eventStatusName" type="text" class="form-control" id="eventStatusName"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Venue</label>
                            <input name="eventStatusVenue" type="text" class="form-control" id="eventStatusVenue"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Event DateType</label>
                            <input name="eventStatusDateType" type="text" class="form-control" id="eventStatusDateType"
                                readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Start Date</label>
                                    <input name="eventStatusStartDate" type="text" class="form-control" id="eventStatusStartDate"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">End Date</label>
                                    <input name="eventStatusEndDate" type="text" class="form-control" id="eventStatusEndDate"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Start Time</label>
                                    <input name="eventStatusSTime" type="text" class="form-control" id="eventStatusSTime"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">End Time</label>
                                    <input name="eventStatusETime" type="text" class="form-control" id="eventStatusETime"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Description</label>
                            {{-- <input  required> --}}
                            <textarea name="eventStatusDesc" type="text" class="form-control" id="eventStatusDesc" readonly></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">No. of Participants</label>
                            <input name="eventStatusParticipants" type="text" class="form-control"
                                id="eventStatusParticipants" readonly>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                                id="modalClose">Close</button>
                            {{-- <a type="" class="btn btn-dark" id="eventApprove">Approve Request</a>
                            <button type="button" class="btn btn-danger" id="eventReject">Reject</button> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="checkStatusModal" tabindex="-1" role="dialog"
            aria-labelledby="checkStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="createeventModalLabel">EVENT STATUS</h2>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Status</label>
                            <span id="eventStatusText" name="eventStatusText" style="font-size: 16px"
                                class="badge badge-sm border border-warning text-warning bg-warning">
                                <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor" class="me-1ca">
                                    <path fill-rule="evenodd"
                                        d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>

                        <div style="font-size: 14px; background-color:rgb(1, 49, 49); border-radius: 25px; ">
                            <div class="rightbox">
                                <div class="rb-container">
                                  <ul class="rb" id="statusList">

                                    <li class="rb-item" ng-repeat="itembx">
                                      <div class="timestamp">
                                        3rd May 2020<br> <span>7:00 PM</span>
                                      </div>
                                      <div class="item-title">Approved by OSA.</div>
                                    </li>

                                  </ul>
                                </div>
                              </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                                id="modalClose">Close</button>
                            {{-- <a type="" class="btn btn-dark" id="eventApprove">Approve Request</a>
                            <button type="button" class="btn btn-danger" id="eventReject">Reject</button> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="uploadReceipt" tabindex="-1" role="dialog"
            aria-labelledby="checkStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="createeventModalLabel">Upload Photo of Receipt</h2>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="uploadReceiptForm" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlInput1" style="font-size: 18px">Upload photo:</label>
                                <input name="id" type="text" class="form-control" id="outsider_event_id" hidden>
                                <input name="image" type="file" class="form-control" id="image" accept="image/*" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                                    id="modalClose">Close</button>
                                <a type="" class="btn btn-dark" id="outsiderSubmitReceipt">Submit</a>
                                {{-- <button type="button" class="btn btn-danger" id="eventReject">Reject</button> --}}
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="checkReceipt" tabindex="-1" role="dialog"
            aria-labelledby="checkStatusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="createeventModalLabel">Photo of Receipt</h2>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div id="imageReceiptContainer"></div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
    <script src="sweetalert2.all.min.js"></script>
</x-app-layout>

<style>
    .rightbox {
  padding: 0;
  height: 0%;
}

/* .rb-container {
  font-family: "PT Sans", sans-serif;
  width: 50%;
  margin: auto;
  display: block;
  position: relative;
} */

.rb-container ul.rb {
  margin: 2.5em 0;
  padding: 0;
  display: inline-block;
}

.rb-container ul.rb li {
  list-style: none;
  margin: auto;
  margin-left: 5em;
  min-height: 50px;
  border-left: 3px dashed #fff;
  padding: 0 0 50px 30px;
  position: relative;
}

.rb-container ul.rb li:last-child {
  border-left: 0;
}

.rb-container ul.rb li::before {
  position: absolute;
  left: -18px;
  top: -5px;
  content: " ";
  border: 8px solid rgba(255, 255, 255, 1);
  border-radius: 500%;
  background: #50d890;
  height: 20px;
  width: 20px;
  transition: all 500ms ease-in-out;
}

.rb-container ul.rb li:hover::before {
  border-color: #f5f105;
  transition: all 1000ms ease-in-out;
}

ul.rb li .timestamp {
  color: #00ff77;
  position: relative;
  /* width: 100px; */
  font-size: 13px;
}

.item-title {
  color: #fff;
}

.rb-container ul.rb li:first-child {
    margin-left: 70px;
    font-size: 16px;
    font-weight: 700;
}

</style>
