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
                </div>
            </div>
            <table id="attendanceTable" class="table table-striped table-hover" style="width:100%;">
                <thead>
                    <tr>
                        <th>Year & Section</th>
                        <th>Last Name</th>
                        <th>First Name</th>
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
        $("#attendanceTable").DataTable({
            ajax: {
                url: "/api/studentlists/" + id,
                dataSrc: "",
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
                    data: "yearsection",
                },
                {
                    data: "lastname",
                },
                {
                    data: "firstname",
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        var isChecked = data.is_present !== null ? 'checked' : '';
                        return "<input type='checkbox' class='markedAttendance' id='markedAttendance_" +
                            data.id +
                            "' data-id='" + data.id + "' " + isChecked + ">";
                    },
                },
            ],
        });

        $("#attendanceTable tbody").on("click", '.markedAttendance', function(e) {
            var id = $(this).data('id');
            var isChecked = $(this).prop('checked') ? 1 : 0;

            //console.log('gjdhg'); check mo  nga ulit

            console.log(isChecked); 
            //console.log(id)
            $.ajax({
                type: "POST",
                url: '/api/updateAttendance/' + id,
                data: {
                    is_present: isChecked
                },
                contentType: false,
                processData: false,
                headers: {
                    'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Attendance checked!',
                        showConfirmButton: false,
                        timer: 3000
                    })
                },
                error: function(error) {
                    console.log('error');
                }
            });
        });

        // $(document).on('click', '.markedAttendance', function() {
        //     var id = $(this).data('id');
        //     var isChecked = $(this).prop('checked') ? 1 : 0;

        //     console.log(id)
        //     // Send AJAX request to update the database with the new checkbox status
        //     // $.ajax({
        //     //     url: 'api/update-attendance/' + id,
        //     //     method: 'POST',
        //     //     data: {
        //     //         is_present: isChecked
        //     //     },
        //     //     success: function(response) {
        //     //         // Handle success response
        //     //     },
        //     //     error: function(xhr, status, error) {
        //     //         // Handle error
        //     //     }
        //     // });

        //     $.ajax({
        //         type: "POST",
        //         url: 'api/update-attendance/' + id,
        //         data: {
        //             is_present: isChecked
        //         },
        //         contentType: false,
        //         processData: false,
        //         headers: {
        //             'Authorization': 'Bearer ' + sessionStorage.getItem('token'),
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         dataType: "json",
        //         success: function(data) {
        //             console.log(data);
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Event has been Added!',
        //                 showConfirmButton: false,
        //                 timer: 3000
        //             })
        //         },
        //         error: function(error) {
        //             console.log('error');
        //         }
        //     });
        // });




        $("#importFile").on("click", function(e) {
            // var event_id = $("#studentListEventID").val();
            // console.log(event_id);
            console.log('napindot')
        });


    })
</script>
