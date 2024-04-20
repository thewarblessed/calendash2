<x-app-layout>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                                        <input type="date" class="form-control form-control-sm"
                                            id="start-date-picker" placeholder="Search">
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-sm"
                                    onclick="window.location.href='{{ route('createAdminEvents') }}'">
                                    <span>Create Event</span>
                                </button>

                            </div>
                        </div>



                        <div class="card-body px-0 py-0">

                            {{-- <div class="border-bottom py-3 px-3 d-sm-flex justify-content-end">
                                <div class="input-group input-group-sm" style="max-width: 200px;">
                                    <input type="date" class="form-control" id="start-date-picker"
                                        placeholder="Select start date">
                                    <button class="btn btn-primary id=" fetch-events-btn">Fetch Events</button>
                                </div>
                            </div> --}}

                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="adminAllEvents">
                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">Event Name
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Venue
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Organization</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Department</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Event
                                                Type</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start
                                                Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End
                                                Date</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                Start Time</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                End Time</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                Status</th>
                                            <th
                                                class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                                Request Letter</th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>

                                        </tr>
                                    </thead>
                                    <tbody id="adminAllEventsBody">
                                        <tr>

                                        </tr>

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

                    <div id="pdfViewer"></div>
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
                                    <input name="eventStatusName" type="text" class="form-control"
                                        id="eventStatusName" readonly>
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
                                    <textarea name="eventStatusDesc" type="text" class="form-control" id="eventStatusDesc" readonly></textarea>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- jspdf --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    {{-- /tapos --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js">
    </script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script type="text/javascript" src="/js/alert.js"></script>

    <script>
        // Initialize the datetime picker
        $(document).ready(function() {
            $('#start-date-picker').datetimepicker({
                format: 'YYYY-MM-DD', // Adjust the format as needed
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-crosshairs',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                }
            });
        });
        $(document).ready(function() {
            // Handle fetch button click event
            $('#start-date-picker').change(function() {
                // Get the selected date from the datetime picker
                var startDate = $('#start-date-picker').val();
                console.log(startDate);

                // Perform an AJAX request to fetch events based on the selected date
                $.ajax({
                    type: "POST",
                    url: '/api/events', // Adjust the URL to your backend endpoint
                    data: JSON.stringify({
                        start_date: startDate
                    }),
                    contentType: 'application/json', // Set content type to JSON
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(response) {
                        // Update the table with the fetched events
                        $('#table-body').empty();
                        response.forEach(function(event) {
                            var row = `
                <tr>
                    <td class"align-left">${event.event_name}</td>
                    <td>${event.venueName}</td>
                    <td>${event.type}</td>
                    <td>${event.start_date}</td>
                    <td>${event.end_date}</td>
                    <td>${event.start_time}</td>
                    <td>${event.end_time}</td>
                    <td>${event.department}</td>
                    <td>${event.organization}</td>
                    <td>${event.status}</td>     
                    <td>${event.event_letter}</td>                
                </tr>
            `;
                            $('#table-body').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(error);
                    }
                });

            });
        });
    </script>


    <script>
        $(function() {
            $('#search_button').click(function() {
                var selectedDate = $('#start_date').val(); // Get the selected date
                filterEventsByStartDate(selectedDate);
            });

            function filterEventsByStartDate(selectedDate) {
                $('#adminAllEvents tbody tr').each(function() {
                    var start_date = $(this).find('td:eq(3)').text()
                        .trim(); // Get the start date from the table
                    if (start_date.includes(selectedDate)) {
                        $(this).show(); // Show the row if the start date matches the selected date
                    } else {
                        $(this).hide(); // Hide the row if the start date does not match the selected date
                    }
                });
            }
        });
    </script>

    {{-- AdminEventModal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editAdminEvents');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const eventId = this.getAttribute('data-id');
                    //   console.log(response);
                    // AJAX request to fetch event data
                    $.ajax({
                        url: '/api/admin/allEvents/' +
                            eventId, // Replace '/events/' with your actual endpoint
                        type: 'GET',
                        success: function(response) {
                            console.log(response);
                            // Populate the modal fields with the fetched data
                            $('#AdminEventsEditId').val(response.id);
                            $('#AdminEventsEditName').val(response.event_name);
                            $('#AdminEventsEditVenue').val(response.venueName);
                            $('#AdminEventsEditType').val(response.type);
                            $('#AdminEventsEditStartDate').val(response.start_date);
                            $('#AdminEventsEditEndDate').val(response.end_date);
                            $('#AdminEventsEditStartTime').val(response.start_time);
                            $('#AdminEventsEditEndTime').val(response.end_time);
                            $('#AdminEventsEditDepartment').val(response.department);
                            $('#AdminEventsEditOrganization').val(response
                                .organization);

                            // Show the edit modal
                            $('#editAdminEventsModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        });
    </script>


    {{-- DATATABLES --}}
    <script>
        // Define the generatePDF function
        $(document).ready(function() {
            
            $("#adminAllEvents").DataTable({
                "pageLength": 5,
                ajax: {
                    url: "/api/admin/all-events",
                    method: "GET",
                    dataSrc: "",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },      
                dom: 'Bfrtip',
                layout: {
                    topStart: {
                        buttons: [
                            'copy',
                            'print',
                            {
                                extend: 'spacer',
                                style: 'bar',
                                text: 'Export files:'
                            },
                            'csv',
                            'excel',
                            'spacer',
                            'pdf'
                        ]
                    }
                },
                columns: [{
                        data: "event_name",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + data +
                                "</span>";
                        }
                    },
                    {
                        data: "venueName",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + data +
                                "</span>";
                        }
                    },
                    {
                        data: "organization",
                        render: function(data, type, row) {
                            if (data === null) {
                                return "<span style='color: black; font-weight: bold;'>N/A</span>";
                            } else {
                                return "<span style='color: black; font-weight: bold;'>" + data +
                                    "</span>";
                            }

                        }
                    },
                    {
                        data: "department",
                        render: function(data, type, row) {
                            if (data === null) {
                                return "<span style='color: black; font-weight: bold;'>OUTSIDER</span>";
                            } else {
                                return "<span style='color: black; font-weight: bold;'>" + data +
                                    "</span>";
                            }

                        }
                    },
                    {
                        data: "type",
                        render: function(data, type, row) {
                            if (data === "whole_day") {
                                return "<span style='color: black; font-weight: bold;'>Whole Day</span>";
                            } else if (data === "whole_week") {
                                return "<span style='color: black; font-weight: bold;'>Whole Week</span>";
                            } else if (data === "within_day") {
                                return "<span style='color: black; font-weight: bold;'>Within the Day</span>";
                            }
                        }
                    },
                    {
                        data: "start_date",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data)
                                .format('MMMM D, YYYY') + "</span>";
                        }
                    },
                    {
                        data: "end_date",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data)
                                .format('MMMM D, YYYY') + "</span>";
                        }
                    },
                    {
                        data: "start_time",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data,
                                'HH:mm').format('h:mm A') + "</span>";
                        }
                    },
                    {
                        data: "end_time",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data,
                                'HH:mm').format('h:mm A') + "</span>";
                        }
                    },
                    {
                        data: "status",
                        render: function(data, type, row) {
                            if (data === "APPROVED") {
                                return "<span style='color: green; font-weight: bold;'>APPROVED</span>";
                            } else if (data === "PENDING") {
                                return "<span style='color: orange; font-weight: bold;'>PENDING</span>";
                            } else if (data === "REJECTED") {
                                return "<span style='color: red; font-weight: bold;'>REJECTED</span>";
                            }
                        }
                    },
                    {
                        data: "event_letter",
                        render: function(data, type, row) {
                            return "<a href='/storage/" + data + "' target='_blank'>Open PDF</a>";
                        }
                    }

                ],
            });

        })
    </script>


</x-app-layout>