<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" id="main">
        <x-app.navbar />
        <div class="container" style="margin-top: 30px">
            <form class="card" id="createEventFormAdmin" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    {{-- EVENT DETAILS --}}
                    <div class="tab d-none">
                        <h3 style="text-align: center">Event Details</h3>

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

                        <h3 style="text-align: center">Department Details</h3>


                        <div class="mb-3">
                            <label for="name" class="form-label">Department</label>
                            <input type="text" class="form-control" name="event_dept" id="event_dept"
                                placeholder="Please enter department name" required>
                        </div>

                        <div class="mb-3">
                            <label for="eventDesc" class="form-label">Organization</label>
                            <input type="text" class="form-control" name="event_org" id="event_org"
                                placeholder="Please enter organization name" required>
                        </div>
                    </div>

                    {{-- VENUE DETAILS --}}
                    <div class="tab d-none">
                        <h3 style="text-align: center">Choose Available Venues</h3>
                        <div class="container">
                            <div class="row">
                                @foreach ($venues as $venue)
                                <div class="col-sm">
                                    <div id="venue{{ $venue->id }}" data-capacity="{{ $venue->capacity }}"
                                        class="card_capacity"
                                        style="width: 15rem; margin-top: 30px; box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px; border-radius: 8px">
                                        <img src="{{ asset('storage/' . $venue->image) }}" height="180"
                                            class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $venue->name }}</h5>
                                            <p class="card-text">{{ $venue->description }}</p>
                                            <p class="card-text">Capacity: {{ $venue->capacity }}</p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="event_venue"
                                                    id="event_venue" value="{{ $venue->id }}" required>
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

                    {{-- SET DATE DETAILS --}}
                    <div class="tab d-none">

                        
                        
                        <h3 style="text-align: center">Set Date and Time</h3>

                        <div class="radiobuttons">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="event_type" value="withinDay" id="withinDay" required>
                                <label class="custom-control-label" for="withinDay">Within the Day</label>
                            </div>
                        
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="event_type" value="wholeDay" id="wholeDay" required>
                                <label class="custom-control-label" for="wholeDay">Whole Day</label>
                            </div>
                        
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="event_type" value="wholeWeek" id="wholeWeek" required>
                                <label class="custom-control-label" for="wholeWeek">Whole Week</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="event_type" value="dateRanges"
                                    id="dateRanges" required>
                                <label class="custom-control-label" for="dateRanges" >Date Range</label>
                            </div>
                        </div>
                        
                        <div id="withinTheDayDiv" class="withinTheDay" style="display:none;">
                            <h5 style="text-align: center">Within the Day</h5>
                            <div class="form-group">
                                <label for="example-datetime-local-input" class="form-control-label">Datetime</label>
                                <input class="form-control" type="date" value="" name="event_date" id="event_date">
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="start_time" class="form-label">Set Start Time</label>
                                    <input type="time" class="form-control" name="start_time_withinDay" id="start_time_withinDay" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="end_time" class="form-label">Set End Time</label>
                                    <input type="time" class="form-control" name="end_time_withinDay" id="end_time_withinDay" required>
                                </div>
                            </div>
                        </div>

                        <div id="wholeDayDiv" class="wholeDay" style="display:none;">
                            <h5 style="text-align: center">Whole Day</h5>
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Set Date</label>
                                <input type="date" class="form-control" name="event_date_wholeDay" id="event_date_wholeDay">
                            </div>
                        </div>

                        <div id="wholeWeekDiv" class="wholeWeek" style="display:none;">
                            <h5 style="text-align: center">Whole Week</h5>
                            <div class="form-group">
                                <label for="example-week-input" class="form-control-label">Week</label>
                                <input class="form-control" type="week" name="event_date_wholeWeek" id="event_date_wholeWeek">
                            </div>
                        </div>

                        <div id="dateRangeDiv" class="dateRanges" style="display:none;">
                            <h5 style="text-align: center">Date Range</h5>
                            <div class="form-group" style="text-align: center">
                                <label for="example-week-input" class="form-control-label"></label>
                                <input type="text" name="daterange" value="" id="date_range"/>
                            </div>
                        </div>

                    </div>

                    {{-- GENERATE LETTER DETAILS --}}
                    <div class="tab d-none">
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
                        <div class="" style="align-self: center">
                                <label for="request_letter" class="form-label" style="font-size: 25px; text-align:center; color:blueviolet" >Upload Request Letter</label>
                                <input type="file" class="form-control" name="request_letter" id="request_letter" required>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-end">
                    <div class="d-flex">
                        <button type="button" id="back_button" class="btn btn-link" onclick="back()">Back</button>
                        <button type="button" id="next_button" class="btn btn-primary ms-auto"
                            onclick="next()">Next</button>
                        <button type="submit" id="createAdminEvent_submit" class="btn btn-primary ms-auto">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <script src="https://cdn.tiny.cloud/1/e705kagjcg1ew4r2d9lhy91xvaqjjtltd3e4mqs6jmvldw5f/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
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
        $("#createAdminEvent_submit").hide()
        var current = 0;
        var tabs = $(".tab");
        var tabs_pill = $(".tab-pills");

        loadFormData(current);

        function loadFormData(n) {

            $(tabs_pill[n]).addClass("active");
            $(tabs[n]).removeClass("d-none");
            $("#back_button").attr("disabled", n == 0 ? true : false);
            n == tabs.length - 1 ?
                $("#next_button").hide() && $("#createAdminEvent_submit").show() :
                $("#next_button")
                .attr("type", "button")
                .text("Next")
                .attr("onclick", "next()");
        }

        function next() {
            $(tabs[current]).addClass("d-none");
            $(tabs_pill[current]).removeClass("active");

            current++;
            loadFormData(current);
        }

        function back() {
            $(tabs[current]).addClass("d-none");
            $(tabs_pill[current]).removeClass("active");
            $("#next_button").show()
            $("#createAdminEvent_submit").hide()
            current--;
            loadFormData(current);
        }

        ////// DATE  ///////
        // const today = new Date().toISOString().split('T')[0];
        // document.getElementById('event_date').min = today;
         // Get the current date and time in ISO format

        /// FOR INPUT TYPE DATE ONLY
        const today = new Date();
        const oneWeekLater = new Date(today.getTime() + 7 * 24 * 60 * 60 * 1000); // Calculate one week later
        const minDate = oneWeekLater.toISOString().split('T')[0];
        document.getElementById('event_date_withinDay').min = minDate;
        document.getElementById('event_date_wholeDay').min = minDate;
        document.getElementById('event_date_wholeWeek').min = minDate;

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
            opens: 'right',
            minDate: moment().add(1, 'weeks').startOf('day'), // Set minDate to start of day one week from now
            locale: {
                format: 'YYYY-MM-DD'
            }
            }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
</x-app-layout>