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
                                    <h6 class="font-weight-semibold text-lg mb-0">Events list</h6>
                                    <p class="text-sm">See information about all events</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <a type="button" href="{{ route('createAdminEvents') }}"
                                        class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--text">Add/Create Event</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">


                            <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable1"
                                        autocomplete="off" checked>
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable1">All</label>
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable2"
                                        autocomplete="off">
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable2">Approved</label>
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable3"
                                        autocomplete="off">
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable3">Pending</label>
                                </div>
                            </div>

                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="adminAllEvents">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Event
                                                Name
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Venue
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Event
                                                Type</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Start
                                                Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                End
                                                Date</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                Start Time</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                End Time</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                Department</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                Organization</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                Request Letter</th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>

                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        @foreach ($events as $event)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">

                                                    <div class="d-flex flex-column justify-content-center ms-1">
                                                        <strong>
                                                            <h6>{{ $event->event_name }}</h6>
                                                        </strong>
                                                        {{-- <p class="text-sm text-secondary mb-0">
                                                            laurent@creative-tim.com</p> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-left">
                                                @if($event->venueName === null)
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    {{ $event->roomName }}</p>
                                                @else
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    {{ $event->venueName }}</p>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($event->type === 'whole_day')
                                                <p class="text-sm text-dark font-weight-semibold mb-0">Whole
                                                    Day
                                                </p>
                                                @endif
                                                @if ($event->type === 'whole_week')
                                                <p class="text-sm text-dark font-weight-semibold mb-0">Whole
                                                    Week</p>
                                                @endif
                                                @if ($event->type === 'within_day')
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    Within
                                                    the Day</p>
                                                @endif
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
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    {{ Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    {{ Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    {{ $event->department }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    {{ $event->organization }}</p>
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                @if ($event->status === 'APPROVED')
                                                <span
                                                    class="badge badge-sm border border-success text-success bg-success">
                                                    <svg width="9" height="9" viewBox="0 0 10 9" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg" stroke="currentColor"
                                                        class="me-1">
                                                        <path d="M1 4.42857L3.28571 6.71429L9 1" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    APPROVED
                                                </span>
                                                @endif

                                                @if ($event->status === 'PENDING')
                                                <span style="font-size: 12px"
                                                    class="badge badge-sm border border-warning text-warning bg-warning">
                                                    <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="currentColor" class="me-1ca">
                                                        <path fill-rule="evenodd"
                                                            d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    PENDING
                                                </span>
                                                {{-- <p class="text-secondary text-sm mb-0">{{$status}}</p> --}}
                                                @endif
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                {{-- <p class="text-sm text-dark font-weight-semibold mb-0"
                                                    id="viewRequestLetter">Request Letter</p> --}}
                                                <u><strong><a href="#" style="color: black" id="reqLetter"
                                                            class="viewRequestLetter" data-id="{{ $event->id }}">Request
                                                            Letter</a></strong>
                                            </td>

                                            <td class="align-middle">
                                                <a type="button" class="btn btn-dark btn-sm adminViewStatus"
                                                    data-id="{{ $event->id }}">View Status
                                                </a>
                                            </td>

                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold "
                                                    data-bs-toggle="tooltip" data-bs-title="Edit event">
                                                    <i class="fa-solid fa-pen-to-square fa-xl"
                                                        style="color:#774dd3"></i>
                                                </a>
                                            </td>
                                            {{-- <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold "
                                                    data-bs-toggle="tooltip" data-bs-title="Delete event">
                                                    <i class="fa-solid fa-trash fa-xl" style="color:red"></i>
                                                </a>
                                            </td> --}}
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="pagination"></div> --}}
                            <div class="border-top py-3 px-3 d-flex align-items-center" id="pagination">
                                <p class="font-weight-semibold mb-0 text-dark text-sm" id="page-info">Page 1 of 10
                                </p>
                                <div class="ms-auto">
                                    <button class="btn btn-sm btn-white mb-0" id="previous-btn">Previous</button>
                                    <button class="btn btn-sm btn-white mb-0" id="next-btn">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="adminAllEventStatus" tabindex="-1" role="dialog"
                    aria-labelledby="createVenueModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createVenueModalLabel">Status of Event</h5>
                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                    aria-label="Close">
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

                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Date Requested:</label>
                                    <span id="eventDateRequestedText" name="eventStatusText" style="font-size: 16px">

                                    </span>
                                </div>

                                <div style="font-size: 14px; background-color:rgb(1, 49, 49); border-radius: 25px; ">
                                    <div class="rightbox">
                                        <div class="rb-container">
                                          <ul class="rb" id="adminStatusList">
        
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

                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Name of the event</label>
                                    <input name="eventStatusName" type="text" class="form-control" id="eventStatusName"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Venue</label>
                                    <input name="eventStatusVenue" type="text" class="form-control"
                                        id="eventStatusVenue" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Event DateType</label>
                                    <input name="eventStatusDateType" type="text" class="form-control"
                                        id="eventStatusDateType" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Start Date</label>
                                            <input name="eventStatusStartDate" type="text" class="form-control"
                                                id="eventStatusStartDate" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">End Date</label>
                                            <input name="eventStatusEndDate" type="text" class="form-control"
                                                id="eventStatusEndDate" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Start Time</label>
                                            <input name="eventStatusSTime" type="text" class="form-control"
                                                id="eventStatusSTime" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">End Time</label>
                                            <input name="eventStatusETime" type="text" class="form-control"
                                                id="eventStatusETime" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Description</label>
                                    {{-- <input required> --}}
                                    <textarea name="eventStatusDesc" type="text" class="form-control"
                                        id="eventStatusDesc" readonly></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">No. of Participants</label>
                                    <input name="eventStatusParticipants" type="text" class="form-control"
                                        id="eventStatusParticipants" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


                

                <x-app.footer />
            </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
    <script>
        // $(document).ready(function() {
        //   var events = <?php echo json_encode($events); ?>;
        //   console.log(events)
        //   var itemsPerPage = 5;
        //   var totalPages = Math.ceil(events.length / itemsPerPage);
        //   var currentPage = 1;

        //   function showItems(page) {
        //     var startIndex = (page - 1) * itemsPerPage;
        //     var endIndex = startIndex + itemsPerPage;
        //     var slicedEvents = events.slice(startIndex, endIndex);

        //     $('#table-body').empty();
        //     slicedEvents.forEach(function(event) {
        //       var row = `
    //         <tr>
    //           <td class"align-left">${event.event_name}</td>
    //           <td>${event.name}</td>
    //           <td>${event.type}</td>
    //           <td>${event.start_date}</td>
    //           <td>${event.end_date}</td>
    //           <td>${event.start_time}</td>
    //           <td>${event.end_time}</td>
    //           <td>${event.target_dept}</td>
    //           <td>${event.target_org}</td>
    //           <td>${event.status}</td>
    //           <td><a href="#" class="edit-event">Edit</a></td>
    //           <td><a href="#" class="delete-event">Delete</a></td>
    //         </tr>
    //       `;
        //       $('#table-body').append(row);
        //     });
        //   }

        //   function updatePageInfo() {
        //     $('#page-info').text('Page ' + currentPage + ' of ' + totalPages);
        //   }

        //   function updatePaginationButtons() {
        //     $('#previous-btn').prop('disabled', currentPage === 1);
        //     $('#next-btn').prop('disabled', currentPage === totalPages);
        //   }

        //   $('#previous-btn').click(function() {
        //     if (currentPage > 1) {
        //       currentPage--;
        //       showItems(currentPage);
        //       updatePageInfo();
        //       updatePaginationButtons();
        //     }
        //   });

        //   $('#next-btn').click(function() {
        //     if (currentPage < totalPages) {
        //       currentPage++;
        //       showItems(currentPage);
        //       updatePageInfo();
        //       updatePaginationButtons();
        //     }
        //   });

        //   showItems(currentPage);
        //   updatePageInfo();
        //   updatePaginationButtons();
        // });
    </script>
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
        font-size: 18px;
        font-weight: 900;
    }
    
    </style>

</x-app-layout>