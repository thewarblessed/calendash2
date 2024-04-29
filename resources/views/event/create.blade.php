<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" id="main">
        <x-app.navbar />
        <div class="container" style="margin-top: 10px">
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                        <div class="full-background"
                            style="background-image: url('../assets/img/header-blue-purple.jpg')"></div>
                        <div class="card-body text-start p-4 w-100">
                            <h3 class="text-white mb-2">Create your event!🎉🤩✨🔥</h3>

                            <img src="../assets/img/puzzle-iso-gradient.png" alt="3d-cube"
                                class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                        </div>
                    </div>
                </div>
            </div>
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
                                                style="width: 20rem; margin-top: 30px; box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px; border-radius: 8px">
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

                        <div class="mb-3 col-md-6" style="align-self: center; margin-top:20px">
                            <label for="feedback_image" class="form-label"
                                style="font-size: 25px; text-align:center; color:blueviolet">Link for feedback
                                form</label>
                            <input type="text" class="form-control" name="feedback_qr_code" id="feedback_qr_code"
                                placeholder="ex. http://docs.google.com/forms/...">
                            {{-- <onchange="validateFile(this)">
                            <!-- Call validateFile function when file selection changes -->
                            <small class="text-danger" id="fileError"></small> <!-- Error message placeholder -->
                            <small class="form-text text-muted">Max file size: 5MB. File type: PDF only.</small>
                            <!-- Additional info --> --}}
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
                            <p>To save the Letter you've created, please follow these steps:</p>
                            <ol style="font-size: 14px">
                                <li>File</li>
                                <li>Print</li>
                                <li>Select the Destination to "Save as PDF"</li>
                                <li>Click "Save"</li>
                                <li>Then upload it at the bottom of this form</li>
                            </ol>
                            <div class="container p-4">
                                <textarea name="letter_generator" id="editor"></textarea>
                            </div>
                            <div class="mb-3 col-md-6" style="align-self: center">
                                <label for="request_letter" class="form-label"
                                    style="font-size: 25px; text-align:center; color:blueviolet">Upload Request
                                    Letter</label>
                                <input type="file" class="form-control" name="request_letter" id="request_letter"
                                    required accept=".pdf">
                                <small class="text-danger" id="fileError"></small> <!-- Error message placeholder -->
                                <small class="form-text text-muted">Max file size: 5MB. File type: PDF only.</small>
                            </div>
                            <script>
                                function validateFile(input) {
                                    const file = input.files[0];
                                    const maxSize = 5 * 1024 * 1024; // 5MB in bytes

                                    if (file.size > maxSize) {
                                        document.getElementById('fileError').textContent = 'File size exceeds 5MB limit.';
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

                        <div class="form-check form-check-info text-left mb-0">
                            <input class="form-check-input" type="checkbox" name="terms" id="termsCheckbox"
                                onchange="toggleSubmitButton()" required>
                            <label class="font-weight-normal text-dark mb-0" for="terms">
                                I agree to the <a href="#" id="termsConditions"
                                    class="text-dark font-weight-bold">Terms and Conditions</a>.
                            </label>
                        </div>

                        <script>
                            function toggleSubmitButton() {
                                const submitButton = document.getElementById('createEvent_submit');
                                const submitButtonOutsider = document.getElementById('createEvent_submit_outsider');
                                const termsCheckbox = document.getElementById('termsCheckbox');
                                const requestLetterInput = document.getElementById('request_letter');

                                if (termsCheckbox.checked && requestLetterInput.files.length !== 0) {
                                    submitButton.disabled = false;
                                    submitButtonOutsider.disabled = false;
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: "Please upload a file!"
                                    });
                                    termsCheckbox.checked = false;
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
                                {{-- <button type="button" id="showModal" class="btn btn-primary ms-auto"
                                >Modal</button>     --}}
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
                                    {{-- <span class="" role="status" id="spinner" aria-hidden="true"></span> --}}
                                    <span class="sr-only">Loading...</span>Submit
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <div class="modal fade modal-lg" id="confirmModal" tabindex="-1" role="dialog"
                        aria-labelledby="createeventModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="createeventModalLabel">Confirm Event Details</h2>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {{-- <div>
                                    <p style="margin-left: 20px; text-align:center; margin-top: 10px">EVENT DETAILS</p>
                                </div> --}}
                                <div class="modal-body">
                                    
                                        {{-- <p><strong>Event Name:</strong> John Doe</p>
                                        <p><strong>Event Description:</strong> 123 Main Street</p>
                                        <p><strong>Num. of Participants:</strong> 555-1234</p> --}}

                                        {{-- venue --}}
                                        {{-- <p><strong>Venue Name:</strong> John Doe</p> --}}

{{-- 
                                        <p><strong>Event Type:</strong> 123 Main Street</p>
                                        <p><strong>Start Date:</strong> 555-1234</p>
                                        <p><strong>End Date:</strong> 555-1234</p>
                                        <p><strong>Start Time:</strong> 555-1234</p>
                                        <p><strong>End Time:</strong> 555-1234</p>


                                        <p><strong>Link of the feedback form:</strong> John Doe</p>
                                        <p><strong>Event Requester: </strong> {{ Auth::user()->name }}</p>    --}}
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="venue_id" placeholder="Enter contact number" hidden>
                                                <p id="eventNameOutput"><strong>Event Name:</strong> </p>
                                                <p id="eventDescOutput"><strong>Event Description:</strong> </p>
                                                <p id="numParticipantsOutput"><strong>Num. of Participants:</strong> </p>
                                                <br>
                                                <p id="eventTypeOutput"><strong>Event Type:</strong> </p>
                                                <p id="startDateOutput"><strong>Start Date:</strong> </p>
                                                <p id="endDateOutput"><strong>End Date:</strong> </p>
                                                <p id="startTimeOutput"><strong>Start Time:</strong> </p>
                                                <p id="endTimeOutput"><strong>End Time:</strong> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p id="venueNameOutput"><strong>Venue Name:</strong> </p>
                                                <br>
                                                <p id="linkOutput"><strong>Link of the feedback form:</strong> </p>
                                                <p><strong>Event Requester: </strong> {{ Auth::user()->name }}</p>
                                            </div>
                                        </div>
                                        <p>Please review the event details and click "Confirm" to proceed.</p>
                                        
                                        <div id="itBuilding" style="display: none;">
                                            <h5>Flow of the request letter:</h5>
                                            <ol>
                                                <li>ORGANIZATION ADVISER</li>
                                                <li>SECTION HEAD</li>
                                                <li>DEPARTMENT HEAD</li>
                                                <li>OSA</li>
                                                <li>ADAA</li>
                                                <li>ADAF</li>
                                            </ol>
                                        </div>

                                        <div id="notItBuilding" style="display: none;">
                                            <h5>Flow of the request letter:</h5>
                                            <ol>
                                                <li>ORGANIZATION ADVISER</li>
                                                <li>SECTION HEAD</li>
                                                <li>DEPARTMENT HEAD</li>
                                                <li>OSA</li>
                                                <li>ADAA</li>
                                                <li>CAMPUS DIRECTOR</li>
                                            </ol>
                                        </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal"
                                            id="modalClose">Close</button>
                                        {{-- <a type="" class="btn btn-dark" id="eventApprove">Approve Request</a> --}}
                                        <button type="button" class="btn btn-primary" id="storeCreateEventUser"><span class="" role="status" id="spinner" aria-hidden="true"></span> Confirm</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                </div>
            </form>
        </div>
    </main>
    {{-- tinyMCE --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    {{-- <script src="https://cdn.tiny.cloud/1/e705kagjcg1ew4r2d9lhy91xvaqjjtltd3e4mqs6jmvldw5f/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script> --}}
    <script src="https://cdn.tiny.cloud/1/e705kagjcg1ew4r2d9lhy91xvaqjjtltd3e4mqs6jmvldw5f/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
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

        function validateRadios() {
            const radios = document.getElementsByName('event_type');
            let isChecked = false;

            radios.forEach(radio => {
                if (radio.checked) {
                    isChecked = true;
                }
            });

            return isChecked;
        }

        function validateInput() {
            const input = document.getElementById('feedback_qr_code').value.trim();
            return input !== '';
        }

        function next() {
            // if()
            // console.log(current + ": current page")
            const eventName = $('#eventName').val();
            const eventDesc = $('#eventDesc').val();
            const numParticipants = $('#numParticipants').val();

            if (eventName === '' || eventDesc === '' || numParticipants === '' && current == 0) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please fill out all fields!"
                });
                return false;
            }

            // page 2
            const eventPlace = document.querySelector('input[name="event_place"]:checked');
            const eventVenue = document.querySelector('input[name="event_venue"]:checked');
            
            if (!eventPlace && current == 1) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please select an option for Event Place!"
                });
                return false;
            }

            if (eventPlace && eventPlace.value === 'venue' && !eventVenue && current == 1) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please select a venue!"
                });
                return false;
            }

            if (eventPlace && eventPlace.value === 'room' && !eventVenue && current == 1) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please select a room!"
                });
                return false;
            }

            //page 3
            const radiosChecked = validateRadios();
            const input = document.getElementById('feedback_qr_code').value.trim();
            const isValid = validateInput();
            if (current == 2) {
                if (!radiosChecked) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Please select an option for preferred Date and Time!"
                });
                return false;
                }

                if (!isValid) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please enter a valid feedback form URL!"
                    });
                    return false;
                }
            
                
                const eventType = $('input[name="event_type"]:checked').val();
                if (eventType === 'withinDay') { 
                    const eventDate = $('#event_date_withinDayUser').val();
                    const startTime = $('#start_time_withinDayUser').val();
                    const endTime = $('#end_time_withinDayUser').val();
                    if (eventDate === '' || startTime === '' || endTime === '') {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Please select a date and provide start/end times!"
                        });
                        return false;
                    }
                }
                else if (eventType === 'wholeDay') {
                    const eventDateWholeDay = $('#event_date_wholeDayUser').val();
                    if (eventDateWholeDay === '') {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Please select a date!"
                        });
                        return false;
                    }
                }
                else if (eventType === 'wholeWeek'){
                    const eventDateWholeWeek = $('#event_date_wholeWeekUser').val();
                    if (eventDateWholeWeek === '') {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Please select a week!"
                        });
                        return false;
                    }
                }
                else if (eventType === 'date_range'){
                    const eventDateRange = $('#date_range_User').val();
                    if (eventDateRange === '') {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Please provide a date range for Date Range event!"
                        });
                        return false;
                    }
                }
            }


            // $(tabs[current]).addClass("d-none");
            // $(tabs_pill[current]).removeClass("active");

            // current++;
            // loadFormData(current);
            $(tabs[current]).fadeOut(function() {
                current++;
                loadFormData(current);
                $(tabs[current]).fadeIn();
            });
        }
      

        function back() {
            // Fade out the current step and fade in the previous step
            $(tabs[current]).fadeOut(function() {
                $(tabs_pill[current]).removeClass("active");
                current--;
                loadFormData(current);
                $(tabs[current]).fadeIn();
            });

            // Show or hide buttons based on current step
            if (current == 0) {
                $("#next_button").show();
                $("#createEvent_submit").hide();
            } else {
                $("#next_button").attr("type", "button").text("Next").attr("onclick", "next()").show();
                $("#createEvent_submit").hide();
            }
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
       
    <script>
        $(document).ready(function() {
            var id = "{{ Auth::user()->id }}"
            // console.log(id + ": Please ID NYA TO")
            $.ajax({
                url: '/api/me/check-accomplishments/' + id,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.error === 'No approved events found' || response.success === 'User has pending accomplishment report') {
                        return true;
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Pending Accomplishment Report",
                            text: "Accomplishment report not found!",
                            footer: '<a href="#">Why do I have this issue?</a>'
                        }).then(function() {
                            window.location.href = "/accomplishment";
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error checking accomplishment:', error);
                }
            });
            
            
       })
    </script>
</x-app-layout>
