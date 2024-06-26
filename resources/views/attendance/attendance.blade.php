<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="card-header border-bottom pb-0">
                <a href="{{ url('/attendance') }}" class="btn btn-primary">Back</a>
                <div class="" style="text-align: center">
                    <div>
                        {{-- <strong><h3>Events list</h3></strong> --}}
                        <h1>{{ $events->event_name }}</h1>
                        <p class="text-sm">See all participants</p>

                        <button type="button" class="btn btn-dark approveBtn" style="width: 100%; height: 40px;"
                            data-bs-toggle="modal" data-bs-target="#importStudentModal" id="importFile">Import
                            File</button>
                    </div>

                    <!-- Modal for Process of letter -->
                    <div class="modal fade" id="notesModal" tabindex="-1" role="dialog"
                        aria-labelledby="processLetterModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="notesModalLabel">IMPORTANT REMINDERS</h5>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div style="text-align: justify; text-justify: inter-word; padding: 20px;">
                                        <b>
                                            <p style="color: #000000; font-size: 18px; font-weight: bold;">The Excel
                                                file should follow a specific format:</p>
                                        </b>
                                        <p style="color: #000000;">• On the First Column, It should be <b>Year and
                                                Section</b>
                                            <br>• On the Second Column, It should be <b>First name</b>
                                            <br>• On the Third Column, It should be <b>Last name</b> of the
                                            participants.
                                            <b>
                                                <p style="color: #000000; font-size: 18px; font-weight: bold;">You only
                                                    need to include this information without adding any headers like
                                                    "Year and Section," "First name," or "Last name."
                                            </b> Just ensure that the data
                                            is arranged in the specified format without any additional labels.
                                        </p></b>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary"
                                        data-bs-dismiss="modal">Close</button>
                                    <span aria-hidden="true"></span>
                                </div>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#notesModal').modal('show');
                            });
                        </script>
                    </div>
                </div>
            </div>
            <table id="attendanceTable" class="table table-striped table-hover" style="width:100%;">
                <thead>
                    <tr>
                        <th>Year & Section</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Time</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="attendanceBody">
                </tbody>
            </table>
            {{-- <x-app.footer /> --}}

            <div class="modal fade" id="importStudentModal" tabindex="-1" role="dialog"
                aria-labelledby="createeventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="createeventModalLabel">Import Student List</h2>
                            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form id="eventApprovalForm" enctype="multipart/form-data" method="POST"
                                action="{{ route('studentImport') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Upload excel file</label>
                                    <input name="student_event_id" type="text" class="form-control"
                                        value="{{ $event_id }}" id="student_event_id" hidden>
                                    <input name="studentList" type="file" class="form-control" id="studentList"
                                        required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                                        id="modalClose">Close</button>
                                    <button type="submit" class="btn btn-dark" id="studentListImport">Import</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
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



    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script> --}}

</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var id = $("#student_event_id").val();
        console.log(id);
        var table = $("#attendanceTable").DataTable({
            ajax: {
                url: "/api/studentlists/" + id,
                dataSrc: "",
            },
            dom: 'Bfrtip',
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
                    footer: true,            
                },
                {
                    extend: 'print',
                    footer: true,
                    customize: function(win) {
                        // Add your custom logo
                        var logo = '<img src="https://upload.wikimedia.org/wikipedia/en/thumb/c/c8/Technological_University_of_the_Philippines_Seal.svg/1200px-Technological_University_of_the_Philippines_Seal.svg.png" style="width: 100px; height: auto; float: left; margin-right: 10px;">';

                        // Add your custom header
                        var header = '<h4 style="margin-top: 30px; text-align: center; margin-right: 20;">Technological University of the Philippines</h4><br><h4 style="margin-top: 30px; text-align: center; margin-right: 20;">Attendance</h4>';

                        // Wrap logo and header in a container
                        var headerContainer = '<div style="overflow: auto;">' + logo + header + '</div>';

                        // Prepend the container to the document body
                        $(win.document.body).prepend(headerContainer);

                        // Remove the last column of both headers (th) and cells (td) in the table
                        // $(win.document.body).find('table th:last-child, table td:last-child').remove();

                        // Remove the "Calendash" header
                        $(win.document.body).find('h1').remove();
                    }
                }

            ],
            columns: [{
                    data: "yearsection",
                },
                {
                    data: "lastname",
                },
                {
                    data: "firstname",
                },
                {
                    data: "attendance_time",
                    render: function(data) {
                        if (data === null) {
                            return "Absent";
                        } else {
                            const date = new Date(data);
                            const formattedTime = date.toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true
                            });
                            return formattedTime;
                        }
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        var isChecked = data.attendance_time ? 'checked' : '';
                        return "<input type='checkbox' class='markedAttendance' id='markedAttendance_" +
                            data.id +
                            "' data-id='" + data.id + "' " + isChecked + ">";
                    },
                },
            ],
        });

        $("#attendanceTable tbody").on("click", '.markedAttendance', function(e) {
            var id = $(this).data('id');
            var isChecked = $(this).prop('checked');
            var attendanceTime = isChecked ? getCurrentTime() : null;

            $.ajax({
                type: "POST",
                url: '/api/updateAttendance/' + id,
                data: {
                    attendance_time: attendanceTime
                },
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    table.ajax.reload(); // Reload the table data
                },
                error: function(error) {
                    console.log('error');
                }
            });
        });

        $("#importFile").on("click", function(e) {
            console.log('napindot')
        });

    })

    function getCurrentTime() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var time = hours + ':' + (minutes < 10 ? '0' + minutes : minutes); // Format time as h:mm
        return time;
    }

    function formatTime() {
        var now = new Date(); // Get the current date and time
        var hours = now.getHours(); // Get the hours (0-23)
        var minutes = now.getMinutes(); // Get the minutes (0-59)
        var ampm = hours >= 12 ? 'PM' : 'AM'; // Determine AM or PM
        hours = hours % 12 || 12; // Convert hours to 12-hour format
        var formattedHours = hours < 10 ? '0' + hours : hours; // Ensure double digits for hours
        var formattedMinutes = minutes < 10 ? '0' + minutes : minutes; // Ensure double digits for minutes
        var formattedTime = formattedHours + ':' + formattedMinutes + ' ' + ampm; // Combine hours, minutes, and AM/PM
        return formattedTime;
    }
</script>
