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
                                    <strong><h3>Rejected Request List</h3></strong>
                                    <p class="text-sm">See information about all events</p>
                                </div>
                            </div>
                        </div>
                        @csrf
                        <input name="userRejectUserID" type="text" class="form-control" value="{{ Auth::user()->id }}" id="userRejectUserID" hidden>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="userRejectsTable">
                                    
                                    <thead >
                                        <tr>

                                            <th class="text-secondary text-xs font-weight-semibold opacity-7" style="font-weight: bold; color:black;">Event Name</th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Description</th> --}}
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Venue</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Type</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Status</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Rejected By</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Date Rejected</th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-7">Action</th> --}}
                                            <th class="text-secondary opacity-7">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="officialRejectsBody">
                                        
                                        <tr>
                                        </tr>
                                       

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

            <div class="modal fade" id="approveRequestModal" tabindex="-1" role="dialog" aria-labelledby="createeventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h2 class="modal-title" id="createeventModalLabel" >Rejected Request</h2>
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
                            <div class="form-group">
                              <label for="exampleFormControlInput1">Name of the event</label>
                              <input name="eventAuthId" type="text" class="form-control" id="eventAuthId" value={{Auth::user()->id}} hidden>
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
                                <a type="" class="btn btn-dark" id="eventApprove">Approve Request</a>
                            </div>
                        </form>
                
                    </div>
                    
                </div>
                </div>
            </div>

            <div class="modal fade" id="rejectRequestModal" tabindex="-1" role="dialog" aria-labelledby="createeventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="createeventModalLabel" >Reject Request</h2>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <p style="margin-left: 20px">Are you sure you want to Reject this Request?</p>
                    </div>
                    <div class="modal-body">
               
                        <form id="eventApprovalForm" enctype="multipart/form-data" method="POST" action="{{ url('/api/request/approve/{id}') }}" >
                            @csrf
                            <div class="form-group">
                            <h4 style="text-align: center">Event Description</h4>
                              <label for="exampleFormControlInput1">Name of the event</label>
                              <input name="eventAuthRejectId" type="text" class="form-control" id="eventAuthRejectId" value={{Auth::user()->id}} hidden>
                              <input name="eventRejectId" type="text" class="form-control" id="eventRejectId" hidden>
                              <input name="eventRejectName" type="text" class="form-control" id="eventRejectName" disabled >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                {{-- <input  required> --}}
                                <textarea name="eventRejectDesc" type="text" class="form-control" id="eventRejectDesc" disabled ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">No. of Participants</label>
                                <input name="eventRejectParticipants" type="text" class="form-control" id="eventRejectParticipants" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Venue</label>
                                <input name="eventRejectVenue" type="text" class="form-control" id="eventRejectVenue" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Request Letter</label>
                                {{-- <input name="eventApproveVenue" type="file" class="form-control" id="eventApproveVenue" required> --}}
                                {{-- <br><button type="button" class="btn btn-info" id="showLetter">Show Letter</button> --}}
                                <div id="pdfContainer"></div>
                                <u><strong><a href="" id="viewRejectAnotherTab">View Letter Here</a></strong></u>
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Reason of rejection</label>
                                {{-- <input  required> --}}
                                <textarea name="eventRejectReason" type="text" class="form-control" id="eventRejectReason" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal" id="modalClose">Close</button>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
    $(document).ready(function() {
        var id = $("#userRejectUserID").val();
        console.log(id + 'user_idng nakallogin');
        $("#userRejectsTable").DataTable({
            ajax: {
                url: "/api/user/reject/" + id,
                method: "POST",
                dataSrc: "",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            dom: 'Bfrtip',
            layout: {
                topStart: {
                    buttons: [{
                            extend: 'copyHtml5',
                            footer: true
                        },
                        {
                            extend: 'excelHtml5',
                            footer: true
                        },
                        {
                            extend: 'csvHtml5',
                            footer: true
                        },
                        {
                            extend: 'pdfHtml5',
                            footer: true
                        }
                    ]
                }
            },
            columns: [{ 
                        data: "event_name",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + data + "</span>";
                        }
                    },
                    {
                        data: "venueName",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + data + "</span>";
                        }
                    },
                    {
                        data: "type",
                        render: function(data, type, row) {
                            if (data === "whole_day") {
                                return "<span style='color: black; font-weight: bold;'>Whole Day</span>";
                            } else if (data === "whole_week"){
                                return "<span style='color: black; font-weight: bold;'>Whole Week</span>";
                            }
                            else if (data === "within_day"){
                                return "<span style='color: black; font-weight: bold;'>Within the Day</span>";
                            }
                        }
                    },
                    {
                        data: "start_date",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data).format('MMMM D, YYYY') + "</span>";
                        }
                    },
                    {
                        data: "end_date",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data).format('MMMM D, YYYY') + "</span>";
                        }
                    },
                    {
                        data: "start_time",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data, 'HH:mm').format('h:mm A') + "</span>";
                        }
                    },
                    {
                        data: "end_time",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data, 'HH:mm').format('h:mm A') + "</span>";
                        }
                    },
                    {
                        data: "status",
                        render: function(data, type, row) {
                            return "<span style='color: red; font-weight: bold;'>" + data + "</span>";
                        }
                    },
                    {
                        data: "rejected_by",
                        render: function(data, type, row) {
                            var roleName = '';
                            switch (data) {
                                case 'org_adviser':
                                    roleName = 'Organization Adviser';
                                    break;
                                case 'section_head':
                                    roleName = 'Section Head';
                                    break;
                                case 'department_head':
                                    roleName = 'Department Head';
                                    break;
                                case 'osa':
                                    roleName = 'OSA';
                                    break;
                                case 'adaa':
                                    roleName = 'ADAA';
                                    break;
                                case 'atty':
                                    roleName = 'ADAF';
                                    break;
                                case 'campus_director':
                                    roleName = 'Campus Director';
                                    break;
                                default:
                                    roleName = data; // Use the original value if not found in the switch statement
                                    break;
                            }
                            return "<span style='color: black; font-weight: bold;'>" + roleName + "</span>";
                        }
                    },
                    {
                        data: "updated_at",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(data).format('MMMM D, YYYY') + " " + moment(data).format('h:mm A') + "</span>";
                        }

                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var remarks = null;
                            if (row.remarks_org_adviser !== null) {
                                remarks = row.remarks_org_adviser;
                            } else if (row.remarks_sec_head !== null) {
                                remarks = row.remarks_sec_head;
                            } else if (row.remarks_dept_head !== null) {
                                remarks = row.remarks_dept_head;
                            } else if (row.remarks_osa !== null) {
                                remarks = row.remarks_osa;
                            } else if (row.remarks_adaa !== null) {
                                remarks = row.remarks_adaa;
                            } else if (row.remarks_atty !== null) {
                                remarks = row.remarks_atty;
                            } else if (row.remarks_campus_director !== null) {
                                remarks = row.remarks_campus_director;
                            }
                            return "<span style='color: black; font-weight: normal;'>" + remarks + "</span>";
                        }
                    },
            ],
        });

    })
</script>
