<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" id="main">
        <x-app.navbar />
        <div class="container" style="margin-top: 30px">
            <form class="card" id="createEventForm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    {{-- EVENT DETAILS --}}
                    <div class="tab d-none">
                        <h3 style="text-align: center">Event Details</h3>
                        <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" name="eventName" id="eventName"
                                placeholder="Please enter event name" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventDesc" class="form-label">Event Description</label>
                            <input type="text" class="form-control" name="eventDesc" id="eventDesc"
                                placeholder="Please enter event description" required>
                        </div>
                        <div class="mb-3">
                            <label for="numParticipants" class="form-label">No. of participants</label>
                            <input type="number" class="form-control" name="numParticipants" id="numParticipants"
                                placeholder="Please enter no. of participants (ex. 100)" required>
                        </div>
                    </div>

                    {{-- VENUE DETAILS --}}
                    <div class="tab d-none">
                        <h3 style="text-align: center">Choose Available Venues</h3>
                        <div class="container">

                            {{-- <button type="button" id="requestRoomButton" class="btn btn-link">Request
                                Rooms</button>
                            <button type="button" id="venuesButton" class="btn btn-link"
                                style="display: none;">Venue</button> --}}

                            <div class="radiobuttonsuser">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_place" value="venue"
                                        id="venue" required>
                                    <label class="custom-control-label" for="event_place"
                                        style="font-size: 16px;">VENUES</label>
                                </div>

                                <div class="form-check"
                                    style="{{ Auth::user()->role === 'outsider' ? 'display: none;' : '' }}">
                                    <input class="form-check-input" type="radio" name="event_place" value="room"
                                        id="room" required>
                                    <label class="custom-control-label" for="event_place"
                                        style="font-size: 16px;">REQUEST ROOMS</label>
                                </div>
                            </div>

                            <div style="display: none;" id="venueDiv">
                                <div class="row">
                                    @foreach ($venues as $venue)
                                        <div class="col-sm" style="display: block;" id="venueDiv">
                                            <div id="venue{{ $venue->id }}" data-capacity="{{ $venue->capacity }}"
                                                class="card_capacity"
                                                style="width: 15rem; margin-top: 30px; box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px; border-radius: 8px">
                                                <img src="{{ asset('storage/' . $venue->image) }}" height="180"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h4 class="card-title">{{ $venue->name }}</h4>
                                                    <p1 class="card-subtitle mb-2 text-muted">Rules and Regulations</p1>
                                                    <div class="card-text">
                                                        <ul>
                                                            @foreach (explode("\n", $venue->description) as $item)
                                                                <li>{{ $item }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <p class="card-text">Capacity: {{ $venue->capacity }}</p>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="event_venue" id="event_venue"
                                                            value="{{ $venue->id }}" required>
                                                        <label class="custom-control-label" for="event_venue"
                                                            style="color: blue; font-size: 18px"><strong>SELECT</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div style="display: none;" id="roomDiv">
                                <div class="row">
                                    @foreach ($rooms as $room)
                                        <div class="col-sm">
                                            <div id="venue{{ $room->id }}" data-capacity="{{ $room->capacity }}"
                                                class="card_capacity"
                                                style="width: 15rem; margin-top: 30px; box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px; border-radius: 8px">
                                                <img src="{{ asset('storage/' . $room->image) }}" height="180"
                                                    class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h4 class="card-title">{{ $room->name }}</h4>
                                                    <p1 class="card-subtitle mb-2 text-muted">Rules and Regulations
                                                    </p1>
                                                    <div class="card-text">
                                                        <ul>
                                                            @foreach (explode("\n", $room->description) as $item)
                                                                <li>{{ $item }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <p class="card-text">Capacity: {{ $room->capacity }}</p>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="event_venue" id="event_venue"
                                                            value="{{ $room->id }}" required>
                                                        <label class="custom-control-label" for="event_venue"
                                                            style="color: blue; font-size: 18px"><strong>SELECT</strong>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                        </div>
                    </div>

                    {{-- SET DATE DETAILS --}}
                    <div class="tab d-none">
                        <div class="card-body">
                            <h3 style="text-align: center">Set Date and Time</h3>

                            <div class="radiobuttonsuser">
                                <h4 style="text-align: left">Select preferred Date and Time</h4>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type"
                                        value="withinDay" id="withinDay" required>
                                    <label class="custom-control-label" for="withinDay"
                                        style="font-size: 16px;">Within
                                        the Day</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type"
                                        value="wholeDay" id="wholeDay" required>
                                    <label class="custom-control-label" for="wholeDay" style="font-size: 16px;">Whole
                                        Day</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type"
                                        value="wholeWeek" id="wholeWeek" required>
                                    <label class="custom-control-label" for="wholeWeek"
                                        style="font-size: 16px;">Whole
                                        Week</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="event_type"
                                        value="dateRanges" id="dateRanges" required>
                                    <label class="custom-control-label" for="dateRanges"
                                        style="font-size: 16px;">Date
                                        Range</label>
                                </div>
                            </div>

                            <div id="withinTheDayDivUser" class="withinTheDay" style="display:none;">
                                <h5 style="text-align: center">Within the Day</h5>
                                <div class="form-group">
                                    <label for="example-datetime-local-input"
                                        class="form-control-label">Datetime</label>
                                    <input class="form-control" type="date" value=""
                                        name="event_date_withinDayUser" id="event_date_withinDayUser">
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="start_time" class="form-label">Set Start Time</label>
                                        <input type="time" class="form-control" name="start_time_withinDayUser"
                                            id="start_time_withinDayUser" required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="end_time" class="form-label">Set End Time</label>
                                        <input type="time" class="form-control" name="end_time_withinDayUser"
                                            id="end_time_withinDayUser" required>
                                    </div>
                                </div>
                            </div>

                            <div id="wholeDayDivUser" class="wholeDay" style="display:none;">
                                <h5 style="text-align: center">Whole Day</h5>
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Set Date</label>
                                    <input type="date" class="form-control" name="event_date_wholeDayUser"
                                        id="event_date_wholeDayUser">
                                </div>
                            </div>

                            <div id="wholeWeekDivUser" class="wholeWeek" style="display:none;">
                                <h5 style="text-align: center">Whole Week</h5>
                                <div class="form-group">
                                    <label for="example-week-input" class="form-control-label">Week</label>
                                    <input class="form-control" type="week" name="event_date_wholeWeekUser"
                                        id="event_date_wholeWeekUser">
                                </div>
                            </div>

                            <div id="dateRangeDivUser" class="dateRanges" style="display:none;">
                                <h5 style="text-align: center">Date Range</h5>
                                <div class="form-group" style="text-align: center">
                                    <label for="example-week-input" class="form-control-label"></label>
                                    <input type="text" name="daterange" value="" id="date_range_User" />
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- <h4 style="text-align: left">Terms and Conditions</h4> --}}
                            <div class="col-md-12">
                                <p>*Take note regarding the allotted time for Ingress and Egress.</p>
                                <ul>
                                    <li>Allotted time for Ingress: The time allocated for entering the premises.</li>
                                    <li>Allotted time for Egress: The time allocated for exiting the premises.</li>
                                    <li>Ensure that you adhere to the specified Ingress and Egress timings.</li>
                                    <li>Failure to comply with the allotted timings may result in penalties or
                                        restrictions.</li>
                                </ul>
                            </div>
                        </div>

                    </div>


                    {{-- GENERATE LETTER DETAILS --}}
                    <div class="tab d-none">
                        @if (Auth::user()->role === 'outsider')
                            <h3 style="text-align: center">Upload receipt</h3>
                            <div class="mb-3 col-md-6 d-flex justify-content-center">
                                <label for="request_letter" class="form-label"
                                    style="font-size: 16px; text-align:center; color:blueviolet">Upload Photo of
                                    Receipt</label>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center">
                                <input type="file" class="form-control" name="receipt" id="receipt" required>
                            </div>
                        @else
                            <h3>Generate Letter</h3>
                            <p>To save the Letter in you've created, please these steps.</p>
                            <ul style="list-style-type: decimal; font-size: 14px">
                                <li>File</li>
                                <li>Print</li>
                                <li>Select the Destination to "Save as PDF"</li>
                                <li>then click "Save"</li>
                                <li>then upload it to the bottom of this form</li>
                            </ul>
                            <div class="container p-4 ">
                                <textarea name="letter_generator" id="editor"></textarea>
                            </div>
                            {{-- <div class="mb-3 col-md-6" style="align-self: center">
                            <label for="request_letter" class="form-label"
                                style="font-size: 25px; text-align:center; color:blueviolet">Upload Request
                                Letter</label>
                            <input type="file" class="form-control" name="request_letter" id="request_letter" required>
                        </div> --}}
                            <div class="mb-3 col-md-6" style="align-self: center">
                                <label for="request_letter" class="form-label"
                                    style="font-size: 25px; text-align:center; color:blueviolet">Upload Request
                                    Letter</label>
                                <input type="file" class="form-control" name="request_letter" id="request_letter"
                                    required accept=".pdf">
                                <onchange="validateFile(this)">
                                <!-- Call validateFile function when file selection changes -->
                                <small class="text-danger" id="fileError"></small> <!-- Error message placeholder -->
                                <small class="form-text text-muted">Max file size: 25MB. File type: PDF only.</small>
                                <!-- Additional info -->
                            </div>
                            <script>
                                function validateFile(input) {
                                    const file = input.files[0];
                                    const maxSize = 25 * 1024 * 1024; // 25MB in bytes

                                    if (file.size > maxSize) {
                                        document.getElementById('fileError').textContent = 'File size exceeds 25MB limit.';
                                        input.value = ''; // Clear the file input
                                    } else if (!file.type.includes('pdf')) {
                                        document.getElementById('fileError').textContent = 'Only PDF files are allowed.';
                                        input.value = ''; // Clear the file input
                                    } else {
                                        document.getElementById('fileError').textContent = ''; // Clear any previous error message
                                    }
                                }
                            </script>
                        @endif

                        {{-- <div class="card-footer text-end" style="position: absolute; bottom: 5px; right: 0;">
                            <div class="d-flex mt-2">
                                <input type="checkbox" id="termsCheckbox" onchange="toggleSubmitButton()">
                                <label for="termsCheckbox" class="form-check-label" style="font-size: 16px;">I agree to
                                    the terms and conditions</label>
                            </div>
                        </div> --}}

                        <div class="form-check form-check-info text-left mb-0">
                            <input class="form-check-input" type="checkbox" name="terms" id="termsCheckbox"
                                onchange="toggleSubmitButton()" required>
                            <label class="font-weight-normal text-dark mb-0" for="terms">
                                I agree the <a href="#" id="termsConditions"
                                    class="text-dark font-weight-bold">Terms
                                    and Conditions</a>.
                            </label>
                        </div>

                        <script>
                            function toggleSubmitButton() {
                                const submitButton = document.getElementById('createEvent_submit');
                                const submitButtonOutsider = document.getElementById('createEvent_submit_outsider');
                                const termsCheckbox = document.getElementById('termsCheckbox');

                                if (termsCheckbox.checked) {
                                    submitButton.disabled = false;
                                    submitButtonOutsider.disabled = false;
                                } else {
                                    submitButton.disabled = true;
                                    submitButtonOutsider.disabled = true;
                                }
                            }
                        </script>
                    </div>

                    <div class="card-footer text-end">
                        <div class="d-flex mt-2">
                            <button type="button" id="back_button" class="btn btn-link"
                                onclick="back()">Back</button>
                            <button type="button" id="next_button" class="btn btn-primary ms-auto"
                                onclick="next()">Next</button>
                        </div>
                    </div>

                    <div class="card-footer text-end" id="submitSection">
                        <div class="d-flex mt-2">
                            @if (Auth::user()->role === 'outsider')
                                <button type="submit" id="createEvent_submit_outsider"
                                    class="btn btn-primary ms-auto" disabled>
                                    <span class="" role="status" id="spinner_outsider"
                                        aria-hidden="true"></span>
                                    <span class="sr-only">Loading...</span>Submit
                                </button>
                            @else
                                <button type="submit" id="createEvent_submit" class="btn btn-primary ms-auto"
                                    disabled>
                                    <span class="" role="status" id="spinner" aria-hidden="true"></span>
                                    <span class="sr-only">Loading...</span>Submit
                                </button>
                            @endif
                        </div>
                    </div>




                </div>
            </form>
        </div>
    </main>
    {{-- tinyMCE --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/efy9kqrdbnc5rwfbz3ogkw1784y0tm6sphy6xvo6iq7azwcf/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"
        integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="/js/alert.js"></script>
    <script>
        $("#createEvent_submit_outsider").hide()

        $("#createEvent_submit").hide()
        var current = 0;
        var tabs = $(".tab");
        var tabs_pill = $(".tab-pills");

        loadFormData(current);

        function loadFormData(n) {
            var role = "{{ Auth::user()->role }}";
            console.log(role);
            if (role === 'outsider') {
                $(tabs_pill[n]).addClass("active");
                $(tabs[n]).removeClass("d-none");
                $("#back_button").attr("disabled", n == 0 ? true : false);
                n == tabs.length - 1 ?
                    $("#next_button").hide() && $("#createEvent_submit_outsider").show() :
                    $("#next_button")
                    .attr("type", "button")
                    .text("Next")
                    .attr("onclick", "next()");
            } else {
                $(tabs_pill[n]).addClass("active");
                $(tabs[n]).removeClass("d-none");
                $("#back_button").attr("disabled", n == 0 ? true : false);
                n == tabs.length - 1 ?
                    $("#next_button").hide() && $("#createEvent_submit").show() :
                    $("#next_button")
                    .attr("type", "button")
                    .text("Next")
                    .attr("onclick", "next()");
            }

        }

        function next() {
            // if()
            const eventName = $('#eventName').val();
            const eventDesc = $('#eventDesc').val();
            const numParticipants = $('#numParticipants').val();
            if (eventName === '' || eventDesc === '' || numParticipants === '') {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please fill out all fields!"
                });
                return false;
            }
            $(tabs[current]).addClass("d-none");
            $(tabs_pill[current]).removeClass("active");

            current++;
            loadFormData(current);
        }

        function back() {
            $(tabs[current]).addClass("d-none");
            $(tabs_pill[current]).removeClass("active");
            $("#next_button").show()
            $("#createEvent_submit").hide()
            current--;
            loadFormData(current);
        }

        ////// DATE  ///////
        // const today = new Date().toISOString().split('T')[0];
        // document.getElementById('event_date').min = today;

        const today = new Date();
        const oneWeekLater = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000); // Calculate one week later
        // const minDate = oneWeekLater.toISOString().split('T')[0];
        const minDateWholeDay = oneWeekLater.toISOString().split('T')[0];
        const minDateWithinDay = oneWeekLater.toISOString().split('T')[0];
        // document.getElementById('event_date').min = minDate;
        document.getElementById('event_date_withinDayUser').min = minDateWholeDay;
        document.getElementById('event_date_wholeDayUser').min = minDateWithinDay;

        // $(function() {
        //     var minDate = new Date();
        //     minDate.setDate(today.getDate() + 7); // Set min date to 7 days ahead

        //     $("#event_date").datepicker({
        //         minDate: minDate
        //     });
        // });

        //// TIME /////
        var blockedTimeRanges = [{
                start: '01:00',
                end: '05:00'
            }, // Block from 1:00 AM to 5:00 AM
            {
                start: '19:00',
                end: '23:00'
            }, // Block from 7:00 PM to 11:00 PM
            // Add more time ranges as needed
        ]; // For example

        function isTimeInRange(time, ranges) {
            var selectedTime = time.split(':').map(Number); // Convert selected time to hours and minutes

            for (var i = 0; i < ranges.length; i++) {
                var startTime = ranges[i].start.split(':').map(Number);
                var endTime = ranges[i].end.split(':').map(Number);

                // Check if selected time falls within the current range
                if (
                    selectedTime[0] > startTime[0] ||
                    (selectedTime[0] === startTime[0] && selectedTime[1] >= startTime[1])
                ) {
                    if (
                        selectedTime[0] < endTime[0] ||
                        (selectedTime[0] === endTime[0] && selectedTime[1] < endTime[1])
                    ) {
                        return true; // Time is within blocked range
                    }
                }
            }

            return false; // Time is not within any blocked range
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('start_time').addEventListener('change', function() {
                var selectedTime = this.value;
                if (isTimeInRange(selectedTime, blockedTimeRanges)) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Thats beyond the school timeframe!"
                    });
                    this.value = '';
                    // Reset the value or perform other actions as needed
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('end_time').addEventListener('change', function() {
                var selectedTime = this.value;
                if (isTimeInRange(selectedTime, blockedTimeRanges)) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Thats beyond the school timeframe!"
                    });
                    this.value = '';
                    // Reset the value or perform other actions as needed
                }
            });
        });
    </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right',
                minDate: moment().add(1, 'weeks').startOf(
                    'day'), // Set minDate to start of day one week from now
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        });

        $(document).ready(function() {
            // $('#dateRangeDivUser').hide();  
            $('#date_range_User').change(function() {

                // dateRanges
                var selectedVenueID = $("input[name='event_venue']:checked").val();
                var selectedRange = $(this).val();
                var selectedVenueType = $("input[name='event_place']:checked").val();
                console.log(selectedRange);

                if (selectedVenueType === 'room') {
                    $.ajax({
                        url: '/api/check-event-conflict',
                        type: 'POST',
                        data: {
                            event_type: 'dateRanges',
                            daterange: selectedRange,
                            room_id: selectedVenueID,
                            selectedVenueType: selectedVenueType
                        },
                        success: function(response) {
                            if (response.conflict) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                                });
                                // alert('');
                                $('#date_range_User').val('');
                            }

                        },
                        error: function(xhr, status, error) {
                            console.error('Error checking event conflict:', error);
                        }
                    });
                } else {
                    $.ajax({
                        url: '/api/check-event-conflict',
                        type: 'POST',
                        data: {
                            event_type: 'dateRanges',
                            daterange: selectedRange,
                            venue_id: selectedVenueID,
                            selectedVenueType: selectedVenueType
                        },
                        success: function(response) {
                            if (response.conflict) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    html: "There is an existing event with the <strong>same venue and time</strong>. Please check the calendar for available dates and time.",
                                });
                                // alert('');
                                $('#date_range_User').val('');
                            }

                        },
                        error: function(xhr, status, error) {
                            console.error('Error checking event conflict:', error);
                        }
                    });
                }

            });
        });
    </script>
</x-app-layout>
