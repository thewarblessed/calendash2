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
                                <table class="table align-items-center mb-0" id="officialRejectsTable">
                                    
                                    <thead >
                                        <tr>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-15" >Event Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >Description</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >Event Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >Start Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >End Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2" >Status</th>
                                            <th class="text-xs font-weight-semibold opacity-15" >Action</th> --}}


                                            <th class="text-secondary text-xs font-weight-semibold opacity-7" style="font-weight: bold; color:black;">Event Name</th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Description</th> --}}
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Venue</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Orgnanization</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Deparment</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Type</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Status</th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-7">Letter</th> --}}
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

            <div class="modal fade" id="approveRoomModal" tabindex="-1" role="dialog" aria-labelledby="createeventModalLabel" aria-hidden="true">
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
               
                        <form id="roomApprovalForm" enctype="multipart/form-data" method="POST" action="{{ url('/api/request/approve/{id}') }}" >
                            @csrf
                            <div class="form-group">
                              <input name="officialPendingRoomUserID" type="text" class="form-control" value="{{ Auth::user()->id }}" id="officialPendingRoomUserID" hidden>
                              <label for="exampleFormControlInput1">Name of the event</label>
                              <input name="roomAuthId" type="text" class="form-control" id="roomAuthId" value={{Auth::user()->id}} hidden>
                              <input name="roomApproveId" type="text" class="form-control" id="roomApproveId" hidden>
                              <input name="roomApproveName" type="text" class="form-control" id="roomApproveName" disabled >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                {{-- <input  required> --}}
                                <textarea name="roomApproveDesc" type="text" class="form-control" id="roomApproveDesc" disabled ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">No. of Participants</label>
                                <input name="roomApproveParticipants" type="text" class="form-control" id="roomApproveParticipants" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Venue</label>
                                <input name="roomApproveVenue" type="text" class="form-control" id="roomApproveVenue" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Request Letter</label>
                                {{-- <input name="eventApproveVenue" type="file" class="form-control" id="eventApproveVenue" required> --}}
                                {{-- <br><button type="button" class="btn btn-info" id="showLetter">Show Letter</button> --}}
                                <div id="pdfContainer"></div>
                                <u><strong><a href="" id="roomViewAnotherTab">View Letter Here</a></strong></u>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal" id="modalClose">Close</button>
                                <a type="" class="btn btn-dark" id="roomApprove">Approve Request</a>
                            </div>
                        </form>
                
                    </div>
                    
                </div>
                </div>
            </div>

            <div class="modal fade" id="rejectRoomModal" tabindex="-1" role="dialog" aria-labelledby="createeventModalLabel" aria-hidden="true">
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
                              <input name="officialPendingRoomUserID" type="text" class="form-control" value="{{ Auth::user()->id }}" id="officialPendingRoomUserID" hidden>
                              <label for="exampleFormControlInput1">Name of the event</label>
                              <input name="roomAuthRejectId" type="text" class="form-control" id="roomAuthRejectId" value={{Auth::user()->id}} hidden>
                              <input name="roomRejectId" type="text" class="form-control" id="roomRejectId" hidden>
                              <input name="roomRejectName" type="text" class="form-control" id="roomRejectName" disabled >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                {{-- <input  required> --}}
                                <textarea name="roomRejectDesc" type="text" class="form-control" id="roomRejectDesc" disabled ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">No. of Participants</label>
                                <input name="roomRejectParticipants" type="text" class="form-control" id="roomRejectParticipants" disabled>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Venue</label>
                                <input name="roomRejectVenue" type="text" class="form-control" id="roomRejectVenue" disabled>
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
                                <textarea name="roomRejectReason" type="text" class="form-control" id="roomRejectReason" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal" id="modalClose">Close</button>
                                <button type="button" class="btn btn-danger" id="roomReject">Reject</button>
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
    var id = $("#officialPendingRoomUserID").val();
    console.log(id + 'user_id');
    $("#officialRejectsTable").DataTable({
        ajax: {
            url: "/api/my/pendingRooms",
            method: "GET",
            dataSrc: "",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdfHtml5',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: 'excelHtml5',
                className: 'btn btn-success',
                exportOptions: {
                    columns: [0, 1, 2]
                }
            }
        ],
        columns: [{ 
                    data: "event_name",
                    render: function(data, type, row) {
                        return "<span style='color: black; font-weight: bold;'>" + data + "</span>";
                    }
                },
                {
                    data: "roomName",
                    render: function(data, type, row) {
                        return "<span style='color: black; font-weight: bold;'>" + data + "</span>";
                    }
                },
                {
                    data: "organization",
                    render: function(data, type, row) {
                        if (data === null)
                        {
                            return "<span style='color: black; font-weight: bold;'>N/A</span>";
                        }
                        else{
                            return "<span style='color: black; font-weight: bold;'>" + data + "</span>";
                        }
                        
                    }
                },
                {
                    data: "department",
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
                        return "<span style='color: orange; font-weight: bold;'>" + data + "</span>";
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return "<button type='button' class='btn btn-primary approveBtn' data-id='" + data + "' style='width: 100%;'>Approved</button><br><button type='button' class='btn btn-danger rejectBtn' data-id='" + data + "' style='width: 100%;'>Reject</button>";
                    }
                }
        ],
    });

    $("#officialRejectsTable tbody").on("click", 'button.approveBtn', function (e) {
        // var id = $(this)."data".val();
        var id = $(this).data("id");
        console.log(id);
        console.log('approved');

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/my/pendingRooms/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#approveRoomModal').modal('show');
                $('#roomApproveId').val(data.rooms.id);
                $('#roomApproveName').val(data.rooms.event_name);
                $('#roomApproveDesc').val(data.rooms.description);
                $('#roomApproveParticipants').val(data.rooms.participants);
                $('#roomApproveVenue').val(data.rooms.roomName);
            },
            error: function (error) {
                console.log("error");
            },
        });

        // console.log(id)
        // //PDF
        $.ajax({
            type: "GET",
            url: "/api/show/letter/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                var pdfLink = $('<a>', {
                    href: "/storage/" + data,
                    text: "Click here to view Request Letter",
                    target: "_blank",
                });
                // console.log(href)
                $("#roomViewAnotherTab").empty().append(pdfLink);
            },
            error: function (error) {
                console.log(error);
            },
        });

        $("#roomApprove").on("click", async function (e) {
            var user_id = $('#roomAuthId').val()
            console.log(user_id);

            $("#approveRoomModal").modal('hide');
            const { value: password } = await Swal.fire({
                title: "Enter your passcode to confirm approval",
                input: "password",
                inputLabel: "Passcode",
                inputPlaceholder: "Enter your passcode",
                inputAttributes: {
                    maxlength: "10",
                    autocapitalize: "off",
                    autocorrect: "off"
                }
            });
            if (password) {
                console.log(password)
                const dataToSend = {
                    key1: password,
                    key2: user_id
                };
                console.log(dataToSend);
                $.ajax({
                    type: "POST",
                    url: "/api/rooms/approve/" + id,
                    data: dataToSend,
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);

                        setTimeout(function () {
                            window.location.href = '/pending/rooms';
                        }, 1500);

                        Swal.fire({
                            icon: "success",
                            title: "Request has been approved",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    },
                    error: function (error) {
                        console.log('error');
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            footer: '<a href="#">Why do I have this issue?</a>'
                        });

                    }
                });

                // Swal.fire(`Entered password: ${password}`);
            }
        })

    })

    $("#officialRejectsTable tbody").on("click", 'button.rejectBtn', function (e) {
        var id = $(this).data("id");
        console.log(id);
        console.log('reject');

        $.ajax({
            type: "GET",
            enctype: 'multipart/form-data',
            processData: false, // Important!
            contentType: false,
            cache: false,
            url: "/api/my/pendingRooms/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                $('#rejectRoomModal').modal('show');
                $('#roomRejectId').val(data.rooms.id);
                $('#roomRejectName').val(data.rooms.event_name);
                $('#roomRejectDesc').val(data.rooms.description);
                $('#roomRejectParticipants').val(data.rooms.participants);
                $('#roomRejectVenue').val(data.rooms.roomName);
            },
            error: function (error) {
                console.log("error");
            },
        });


        //View PDF
        $.ajax({
            type: "GET",
            url: "/api/show/letter/" + id,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            dataType: "json",
            success: function (data) {
                console.log(data);
                var pdfLink = $('<a>', {
                    href: "/storage/" + data,
                    text: "Click here to view Request Letter",
                    target: "_blank",
                });
                // console.log(href)
                $("#viewRejectAnotherTab").empty().append(pdfLink);
            },
            error: function (error) {
                console.log(error);
            },
        });

        //rejection of request
        $("#roomReject").on("click", async function (e) {
            e.preventDefault();
            var user_id = $('#roomAuthRejectId').val()
            $("#rejectRoomModal").modal('hide');
            var reason = $('#roomRejectReason').val()
            // console.log(reason);
            const { value: password } = await Swal.fire({
                title: "Enter your passcode to confirm approval",
                input: "password",
                inputLabel: "Passcode",
                inputPlaceholder: "Enter your passcode",
                inputAttributes: {
                    maxlength: "256",
                    autocapitalize: "off",
                    autocorrect: "off"
                }
            });

            if (password) {
                console.log(password)
                console.log(user_id)
                const dataToSend = {
                    key1: password,
                    key2: user_id,
                    key3: reason
                };
                $.ajax({
                    type: "POST",
                    url: "/api/rooms/reject/" + id,
                    data: dataToSend,
                    headers: {
                        'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);

                        setTimeout(function () {
                            window.location.href = '/my/rejected';
                        }, 1500);

                        Swal.fire({
                            icon: "success",
                            title: "Request has been declined",
                            showConfirmButton: false,
                            timer: 1500
                        });

                    },
                    error: function (error) {
                        console.log('error');
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                            footer: '<a href="#">Why do I have this issue?</a>'
                        });

                    }
                });

                // Swal.fire(`Entered password: ${password}`);
            }
        });



    })
    

})

</script>
