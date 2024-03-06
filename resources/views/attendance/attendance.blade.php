<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="card-header border-bottom pb-0">
                <div class="" style="text-align: center">
                    <div>
                        <strong><h3>Events list</h3></strong>
                        <p class="text-sm">See information about all events</p>
                        <button type="button" class="btn btn-dark approveBtn" style="width: 100%; height: 40px;" data-bs-toggle="modal" data-bs-target="#importStudentModal" id="tableApprove">Import File</button>
                    </div>
                </div>
            </div>
            <table id="attendanceTable" class="table table-striped table-hover" style="width:100%;">
                <thead>
                    <tr>
                        <th>TUP ID</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="attendanceBody">
                </tbody>
            </table>
            {{-- <x-app.footer /> --}}

            <div class="modal fade" id="importStudentModal" tabindex="-1" role="dialog" aria-labelledby="createeventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h2 class="modal-title" id="createeventModalLabel" >Import Student List</h2>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
               
                        <form id="eventApprovalForm" enctype="multipart/form-data" method="POST" action="{{ route('studentImport') }}" >
                            @csrf
                            <div class="form-group">
                              <label for="exampleFormControlInput1">Upload excel file</label>
                              <input name="studentList" type="file" class="form-control" id="studentList" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal" id="modalClose">Close</button>
                                <button type="submit" class="btn btn-dark" id="eventApprove">Import</button>
                            </div>
                        </form>
                
                    </div>
                    
                </div>
                </div>
            </div>
        </div>
    </main>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>


    
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script> --}}

</x-app-layout>
<script>
$(document).ready(function () {
    $("#attendanceTable").DataTable({
        ajax: {
            url: "/api/studentlists",
            dataSrc: "",
        },
        dom: 'Bfrtip',
        buttons: [
            {
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
        columns: [
            {
                data: "tupID",
            },
            {
                data: "lastname",
            },
            {
                data: "firstname",
            },
            {
                data: null,
                render: function (data, type, row) {
                    return "<a href='#' class='markedAttendance' id='markedAttendance' data-id=" + data.id + 
                    "><i class='fa-regular fa-square-check' style='color:blue' aria-hidden='true' style='font-size:24px' ></i></a>";
                },
            },
        ],
    });

    $("#attendanceTable tbody").on("click", 'a.markedAttendance ', function (e) {
        
        var table = $('#etable').DataTable();
        var id = $(this).data("id");
        console.log(id);
    })


})
</script>
