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
                                <a type="button"
                                    href="{{ route('createAdminEvents') }}" 
                                    class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--text">Add/Create Event</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">

                        
                            <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable1" autocomplete="off" checked>
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable1">All</label>
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable2" autocomplete="off">
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable2">Approved</label>
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable3" autocomplete="off">
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable3">Pending</label>
                                </div>
                            </div>
                
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="adminAllEvents">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Event Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Venue</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Event Type</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End Date</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Start Time</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">End Time</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Department</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Organization</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Request Letter</th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        @foreach($events as $event)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    
                                                    <div class="d-flex flex-column justify-content-center ms-1">
                                                        <strong><h6>{{$event->event_name}}</h6></strong>
                                                        {{-- <p class="text-sm text-secondary mb-0">laurent@creative-tim.com</p> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-left">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{ $event->name }}</p>
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
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{ Carbon\Carbon::parse($event->start_date)->format('j F, Y') }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{ Carbon\Carbon::parse($event->end_date)->format('j F, Y') }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{ Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{ Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$event->target_dept}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$event->target_org}}</p>
                                            </td>
                                            
                                            <td class="align-middle text-center text-sm">
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
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                {{-- <p class="text-sm text-dark font-weight-semibold mb-0" id="viewRequestLetter">Request Letter</p> --}}
                                                <u><strong><a href="#" style="color: black" id="reqLetter" class="viewRequestLetter" data-id="{{$event->id}}" >Request Letter</a></strong>
                                            </td>

                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold "
                                                    data-bs-toggle="tooltip" data-bs-title="Edit event">
                                                    <i class="fa-solid fa-pen-to-square fa-xl" style="color:#774dd3"></i>
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold "
                                                    data-bs-toggle="tooltip" data-bs-title="Delete event">
                                                    <i class="fa-solid fa-trash fa-xl" style="color:red"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{-- <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex align-items-center">
                                                        <img src="../assets/img/marie.jpg"
                                                            class="avatar avatar-sm rounded-circle me-2"
                                                            alt="user4">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center ms-1">
                                                        <h6 class="mb-0 text-sm font-weight-semibold">Michael Levi</h6>
                                                        <p class="text-sm text-secondary mb-0">michael@creative-tim.com
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">Programator</p>
                                                <p class="text-sm text-secondary mb-0">Developer</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm border border-success text-success bg-success">Online</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">24/12/08</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                    data-bs-toggle="tooltip" data-bs-title="Edit user">
                                                    <svg width="14" height="14" viewBox="0 0 15 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.2201 2.02495C10.8292 1.63482 10.196 1.63545 9.80585 2.02636C9.41572 2.41727 9.41635 3.05044 9.80726 3.44057L11.2201 2.02495ZM12.5572 6.18502C12.9481 6.57516 13.5813 6.57453 13.9714 6.18362C14.3615 5.79271 14.3609 5.15954 13.97 4.7694L12.5572 6.18502ZM11.6803 1.56839L12.3867 2.2762L12.3867 2.27619L11.6803 1.56839ZM14.4302 4.31284L15.1367 5.02065L15.1367 5.02064L14.4302 4.31284ZM3.72198 15V16C3.98686 16 4.24091 15.8949 4.42839 15.7078L3.72198 15ZM0.999756 15H-0.000244141C-0.000244141 15.5523 0.447471 16 0.999756 16L0.999756 15ZM0.999756 12.2279L0.293346 11.5201C0.105383 11.7077 -0.000244141 11.9624 -0.000244141 12.2279H0.999756ZM9.80726 3.44057L12.5572 6.18502L13.97 4.7694L11.2201 2.02495L9.80726 3.44057ZM12.3867 2.27619C12.7557 1.90794 13.3549 1.90794 13.7238 2.27619L15.1367 0.860593C13.9869 -0.286864 12.1236 -0.286864 10.9739 0.860593L12.3867 2.27619ZM13.7238 2.27619C14.0917 2.64337 14.0917 3.23787 13.7238 3.60504L15.1367 5.02064C16.2875 3.8721 16.2875 2.00913 15.1367 0.860593L13.7238 2.27619ZM13.7238 3.60504L3.01557 14.2922L4.42839 15.7078L15.1367 5.02065L13.7238 3.60504ZM3.72198 14H0.999756V16H3.72198V14ZM1.99976 15V12.2279H-0.000244141V15H1.99976ZM1.70617 12.9357L12.3867 2.2762L10.9739 0.86059L0.293346 11.5201L1.70617 12.9357Z"
                                                            fill="#64748B" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="pagination"></div> --}}
                            <div class="border-top py-3 px-3 d-flex align-items-center" id="pagination">
                                <p class="font-weight-semibold mb-0 text-dark text-sm" id="page-info">Page 1 of 10</p>
                                <div class="ms-auto">
                                  <button class="btn btn-sm btn-white mb-0" id="previous-btn">Previous</button>
                                  <button class="btn btn-sm btn-white mb-0" id="next-btn">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="createVenueModal" tabindex="-1" role="dialog" aria-labelledby="createVenueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="createVenueModalLabel">Create Event</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                              <label for="exampleFormControlInput1">Name of the event</label>
                              <input type="text" class="form-control" id="eventName">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">No. of participants</label>
                                <input type="text" class="form-control" id="eventName">
                            </div>
                            <div class="form-group">
                              <label for="exampleFormControlSelect2">Example multiple select</label>
                              <select multiple class="form-control" id="exampleFormControlSelect2">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="exampleFormControlTextarea1">Example textarea</label>
                              <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                          </form>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-dark">Save changes</button>
                    </div>
                </div>
                </div>
            </div>
           
            <x-app.footer />
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

</x-app-layout>
