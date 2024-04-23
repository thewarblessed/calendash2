<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="container-xl px-4 mt-4">
                <h2>ALL APPROVED EVENTS - ACCOMPLISHMENT REPORTS</h2>

                <div class="card-header border-bottom pb-0">
                    <a href="{{ url('/attendance') }}" class="btn btn-primary">Back</a>
                    <div class="" style="text-align: center">
                        <div>
                            @csrf
                            <input class="form-control" id="userAccomplishmentUserID" type="text"
                                placeholder="Enter your username" value="{{ Auth::user()->id }}" hidden>
                        </div>
                    </div>
                </div>
                <table id="userAccomplishmentTable" class="table table-striped table-hover" style="width:100%;">
                    <thead>
                        <tr>
                            {{-- <th>Event ID</th> --}}
                            <th>Event Name</th>
                            <th>Venue Name</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Reports</th>
                            <th>Documents</th>
                        </tr>
                    </thead>
                    <tbody id="userAccomplishmentBody">
                    </tbody>
                </table>
            </div>
        </div>


        {{-- MODAL FOR VIEW DOCUMENTS --}}
        <div class="modal fade" id="uploadDocumentsModal" tabindex="-1" role="dialog"
            aria-labelledby="uploadDocumentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadDocumentsModalLabel">View Documents</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display event ID and event name -->
                        <p>Event ID: <span id="id"></span></p>
                        <p>Event Name: <span id="event_name"></span></p>
                        <div id="imageContainer"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
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
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            // Handle click event on event name to show the modal for uploading documents
            $("#userAccomplishmentTable tbody").on("click", function() {
                var data = $("#userAccomplishmentTable").DataTable().row($(this).closest("tr")).data();
                if (data) {
                    $("#uploadDocumentsModal").modal("show"); // Show the modal
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var id = $("#userAccomplishmentUserID").val();
            console.log(id + 'user_idng nakallogin');
            var table = $("#userAccomplishmentTable").DataTable({
                ajax: {
                    url: "/api/get-all-approved-events",
                    method: "GET",
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
                columns: [
                    // {
                    //     data: "id",
                    //     render: function(data, type, row) {
                    //         return "<span style='color: black; font-weight: bold;'>" + data +
                    //             "</span>";
                    //     }
                    // },
                    {
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
                            return "<span style='color: green; font-weight: bold;'>" + data +
                                "</span>";
                        }
                    },
                    {
                        data: "event_letter",
                        render: function(data, type, row) {
                            return "<a href='/storage/" + data + "' target='_blank'>Open PDF</a>";
                        }
                    },
                    {
                        data: id,
                        render: function(data, type, row) {
                            return "<button class='btn btn-primary viewImage' data-id = '" +
                                data + "' >View</button>";
                        }
                    },

                ],
            });

            // Handle click event on View Documents button
            $('#userAccomplishmentTable tbody').on('click', '.viewImage', function() {
                var data = table.row($(this).parents('tr')).data();
                if (data) {
                    $("#id").text(data.id);
                    $("#event_name").text(data.event_name);
                    $("#imageContainer").empty(); // Clear previous images
                    $.ajax({
                        url: "/api/get-event-images/",
                        method: "GET",
                        success: function(response) {
                            response.forEach(function(image) {
                                console.log(image.image);
                                var img = $("<img>").attr("src",
                                    "/images/documentation/" + image.image).css(
                                    "width", "180px").css("height", "180px").css(
                                    "margin-right", "10px").css("margin-bottom",
                                    "10px");
                                $("#imageContainer").append(img);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log any errors
                        }
                    });
                    $("#uploadDocumentsModal").modal("show"); // Show the modal
                }
            });
        });
    </script>

</x-app-layout>