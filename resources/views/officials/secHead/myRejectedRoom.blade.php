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
                                    <strong>
                                        <h3>Rejected Rooms List</h3>
                                    </strong>
                                    <p class="text-sm">See information about all events</p>
                                </div>
                            </div>
                        </div>
                        @csrf
                        <div>
                            <label for="min">Start Date:</label>
                            <input type="text" id="min" name="min" class="form-control">
                        </div>
                        <div>
                            <label for="max">End Date:</label>
                            <input type="text" id="max" name="max" class="form-control">
                        </div>
                        <br>
                        <input name="officialRejectUserID" type="text" class="form-control"
                            value="{{ Auth::user()->id }}" id="officialRejectUserID" hidden>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="officialRejectsTable">

                                    <thead>
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7"
                                                style="font-weight: bold; color:black;">Event Name</th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Description</th> --}}
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Venue
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Type
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start
                                                Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End
                                                Date</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Start
                                                Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">End
                                                Time</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Status</th>
                                            {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-7">Action</th> --}}
                                            <th class="text-secondary opacity-7"></th>
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

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.25/range_dates/dataTables.rangeDates.min.js"></script>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        var id = $("#officialRejectUserID").val();
        console.log(id + 'user_id');
        $("#officialRejectsTable").DataTable({
            ajax: {
                url: "/api/rooms/rejected",
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
                            footer: true,
                        },
                        {
                            extend: 'print',
                            footer: true,
                            customize: function(win) {
                                // Add your custom logo
                                var logo =
                                    '<img src="https://upload.wikimedia.org/wikipedia/en/thumb/c/c8/Technological_University_of_the_Philippines_Seal.svg/1200px-Technological_University_of_the_Philippines_Seal.svg.png" style="width: 100px; height: auto; float: left; margin-right: 10px;">';

                                // Add your custom header
                                var header =
                                    '<h4 style="margin-top: 30px; text-align: center; margin-right: 20;">Technological University of the Philippines</h4><br><h4 style="margin-top: 30px; text-align: center; margin-right: 20;">Approved Events</h4>';

                                // Wrap logo and header in a container
                                var headerContainer = '<div style="overflow: auto;">' + logo +
                                    header + '</div>';

                                // Prepend the container to the document body
                                $(win.document.body).prepend(headerContainer);

                                // Remove the last column of both headers (th) and cells (td) in the table
                                // $(win.document.body).find('table th:last-child, table td:last-child').remove();

                                // Remove the "Calendash" header
                                $(win.document.body).find('h1').remove();
                            }
                        }

                    ],
                },
                columns: [{
                        data: "event_name",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + data +
                                "</span>";
                        }
                    },
                    {
                        data: "roomName",
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
                            return "<span style='color: black; font-weight: bold;'>" + moment(
                                    data)
                                .format('MMMM D, YYYY') + "</span>";
                        }
                    },
                    {
                        data: "end_date",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(
                                    data)
                                .format('MMMM D, YYYY') + "</span>";
                        }
                    },
                    {
                        data: "start_time",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(
                                data,
                                'HH:mm').format('h:mm A') + "</span>";
                        }
                    },
                    {
                        data: "end_time",
                        render: function(data, type, row) {
                            return "<span style='color: black; font-weight: bold;'>" + moment(
                                data,
                                'HH:mm').format('h:mm A') + "</span>";
                        }
                    },
                    {
                        data: "status",
                        render: function(data, type, row) {
                            return "<span style='color: red; font-weight: bold;'>" + data +
                                "</span>";
                        }
                    },
                ],
            }
        });

        // Initialize Date Range Filter
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = $('#min').datepicker("getDate");
                var max = $('#max').datepicker("getDate");
                var startDate = new Date(data[4]); // Assuming start_date is the fifth column
                return (min === null || max === null) || (startDate >= min && startDate <= max);
            }
        );

        // Add Datepickers for Date Range
        $('#min, #max').datepicker({
            dateFormat: 'yy-mm-dd',
            onSelect: function() {
                dataTable.draw();
            }
        });

    })
</script>
