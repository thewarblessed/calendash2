<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="container-xl px-4 mt-4">
                <h2>ACCOMPLISHMENT REPORTS</h2>

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
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Venue Name</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Uploads</th>
                        </tr>
                    </thead>
                    <tbody id="userAccomplishmentBody">
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Update the modal form to include a hidden input field for the event ID -->
        <div class="modal fade" id="uploadDocumentsModal" tabindex="-1" role="dialog"
            aria-labelledby="uploadDocumentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadDocumentsModalLabel">Upload Documents</h5>
                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display event ID and event name -->
                        <p>Event ID: <span id="id"></span></p>
                        <p>Event Name: <span id="event_name"></span></p>
                        <form id="uploadDocumentsForm">
                            @csrf
                            <!-- Add a hidden input field to store the event ID -->
                            <input type="hidden" name="eventId" id="eventIdInput">
                            <div class="form-group">
                                <label for="documentPhotos">Upload Photos</label>
                                <input name="images[]" id="images" type="file" class="form-control"
                                    accept="image/*" multiple>
                            </div>
                            <div class="form-group">
                                <label for="accomplishmentReport">Upload Accomplishment Report (PDF)</label>
                                <input name="pdf" id="pdf" type="file" class="form-control"
                                    accept="application/pdf" required>
                            </div>
                            <button id='submitUploadPhoto' class="btn btn-dark">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- </div> --}}


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
            $("#userAccomplishmentTable tbody").on("click", "td:first-child", function() {
                var data = $("#userAccomplishmentTable").DataTable().row($(this).closest("tr")).data();
                if (data) {
                    $("#id").text(data.id); // Set the text content of the span with the event ID
                    $("#event_name").text(data
                        .event_name); // Set the text content of the span with the event name
                    $("#eventIdInput").val(data
                        .id); // Set the value of the hidden input field with the event ID
                    $("#uploadDocumentsModal").modal("show"); // Show the modal
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var id = $("#userAccomplishmentUserID").val();
            console.log(id + 'user_idng nakallogin');
            $("#userAccomplishmentTable").DataTable({
                ajax: {
                    url: "/api/user/get-all-my-approved-events/" + id,
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
                        data: "id",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + data +
                                "</span>";
                        }
                    },
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
                        data: id,
                        render: function(data, type, row) {
                            return "<button class='btn btn-primary uploadImage' data-id = '" +
                                data + "' >Upload</button>";
                        }
                    },

                ],
            });

            //UPLOADS//
            $("#userAccomplishmentTable tbody").on("click", 'button.uploadImage', function(e) {
                e.preventDefault();
                // Open file input dialog
                var data = $("#userAccomplishmentTable").DataTable().row($(this).closest("tr")).data();
                if (data) {
                    $("#id").text(data.id); // Set the text content of the span with the event ID
                    $("#event_name").text(data
                    .event_name); // Set the text content of the span with the event name
                    $("#eventIdInput").val(data
                    .id); // Set the value of the hidden input field with the event ID
                    $("#uploadDocumentsModal").modal("show"); // Show the modal
                }
            });
        })


        // Handle file input change event
        $("#submitUploadPhoto").on("click", function(e) {
            e.preventDefault();
            var id = $("#eventIdInput").val();

            let formData = new FormData($('#uploadDocumentsForm')[0]);

            for (var pair of formData.entries()) {
                console.log(pair[0] + ',' + pair[1]);
            }
            console.log(formData)



            // Send AJAX request to upload images
            $.ajax({
                url: "/api/upload/" + id, // Replace with your upload endpoint
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                dataType: "json",
                success: function(response) {
                    // Handle success response
                    console.log("Images uploaded successfully:", response);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error("Error uploading images:", error);
                }
            });
        });
    </script>
</x-app-layout>
