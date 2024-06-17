<x-guest-layout>
    {{-- <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                <x-guest.sidenav-guest />
            </div>
        </div>
    </div> --}}

    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <h1 class="font-weight-black text-dark display-4">CALENDASH</h1>
                                    <p class="mb-0">Create a new account<br></p>
                                    <p class="mb-0">Or Sign in with your existing account.</p>
                                </div>
                                <!-- Card Body -->
                                <div class="text-center">
                                    <!-- Status Message -->
                                    @if (session('status'))
                                        <div class="mb-4 font-medium text-sm text-green-600">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <!-- Error Message -->
                                    @error('message')
                                        <div class="alert alert-danger text-sm" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Form -->
                                <div class="card-body">
                                    <form class="text-start" method="POST" action="{{ route('login') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <label>Email Address</label>
                                        <div class="mb-3">
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Enter your email address" aria-label="Email"
                                                aria-describedby="email-addon">
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Enter password" aria-label="Password"
                                                aria-describedby="password-addon">
                                        </div>
                                        {{-- <div class="d-flex align-items-center">
                                            <a href="{{ route('password.request') }}"
                                                class="text-xs font-weight-bold ms-auto">Forgot password</a>
                                        </div> --}}
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Sign in</button>
                                            <label>or</label>
                                                
                                            <a href="{{ url('auth/google') }}" type="button"
                                                class="btn btn-white btn-icon w-100 mb-3">
                                                <span class="btn-inner--icon me-1">
                                                    <img class="w-5" src="../assets/img/logos/google-logo.svg"
                                                        alt="google-logo" />
                                                </span>
                                                <span class="btn-inner--text">Continue with Google</span>
                                            </a>
                                        </div>
                                    </form>
                                </div>
                                {{-- <!-- Card Footer -->
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto">
                                        Don't have an account?
                                        <a href="{{ route('sign-up') }}" class="text-dark font-weight-bold">Sign up</a>
                                    </p>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Separator -->
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <div style="height: 100%; width: 2px; background-color: #040c55;"></div>
                        </div>

                        <div class="col-md-7"
                            style="max-width: 900px; 
                                   /* background: rgb(2, 9, 39);  */
                                   padding: 20px; 
                                   text-align: center;">

                            {{-- <div class="container"> --}}
                            {{-- <div class="container-fluid"> --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mx-auto"
                                        style="max-width: 900px; 
                                        max-height: 100vh; 
                                        background: rgb(255, 255, 255); 
                                        padding: 20px; 
                                        text-align: center;
                                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 1px 3px rgba(0, 0, 0, 0.1);">
                                        <div class="card-body">
                                            <img src="../assets/img/calendashlogo.png" class="img-fluid" alt="" style="width: 130px;">
                                            <div id="myCalendar"></div>
                                        </div>
                                        <div class="legend">
                                            <span class="dot" style="background-color: #ecb211;"></span> Pending
                                            <span class="dot" style="background-color: #7fc6f5;"></span> Approved
                                            <span class="dot" style="background-color: #8b8b8b;"></span> OverDued
                                        </div>
                                        <style>
                                        .legend .dot {
                                            margin-left: 20px; /* Adjust the spacing as needed */
                                        }
                                        </style>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                    </div>
        </section>

    </main>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/calendar.js"></script>

    <script type="module">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
            }
        });

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // var events = [];
            var calendarEl = document.getElementById('myCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                initialView: 'dayGridMonth',
                events: 'api/getCalendars',
                eventClick: function(info) {
                    // console.log(info.event.id)
                    var id = info.event.id;
                    $.ajax({
                        url: 'api/getCalendarEvent/' + id,
                        method: 'GET',
                        data: {
                            eventId: info.event.id // Pass any necessary data, such as the event ID
                        },
                        success: function(response) {
                            var data = response;
                            // console.log(data.start_time);
                            // console.log(data.type);
                            const eventStartDate = info.event.start.toISOString().split('T')[0];
                            const eventEndDate = info.event.end.toISOString().split('T')[0];
                            // var startTime = '';
                            // if (data.type === 'whole_day') {
                            //     startTime = 'Whole Day';
                            // } 
                            // else if (data.type === 'whole_week') {
                            //     startTime = 'Whole Week';
                            // }
                            // else if (data.type === 'within_day') {
                            //     startTime = info.event.start.toLocaleTimeString([], {
                            //         hour: '2-digit',
                            //         minute: '2-digit'
                            //     });
                            // }
                            // else{
                            //     var timeString = data.start_time;
                            //     var date = new Date(timeString);
                            //     startTime = date.toLocaleTimeString([], {
                            //         hour: '2-digit',
                            //         minute: '2-digit'
                            //     }); 
                            // }

                            // // Determine end time based on data.type
                            // var endTime = '';
                            // if (data.type === 'whole_day') {
                            //     endTime = 'Whole Day';
                            // } 
                            // else if (data.type === 'whole_week') {
                            //     endTime = 'Whole Week';
                            // }
                            // else if (data.type === 'within_day') {
                            //     endTime = info.event.end.toLocaleTimeString([], {
                            //         hour: '2-digit',
                            //         minute: '2-digit'
                            //     });
                            // }
                            // else{
                            //     var timeString = data.end_time;
                            //     var date = new Date(timeString);
                            //     endTime = date.toLocaleTimeString([], {
                            //         hour: '2-digit',
                            //         minute: '2-digit'
                            //     });
                            // }

                            function formatTime(timeString) {
                            var timeParts = timeString.split(':');
                            var hours = parseInt(timeParts[0], 10);
                            var minutes = timeParts[1];
                            var ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12;
                            hours = hours ? hours : 12; // The hour '0' should be '12'
                            return hours + ':' + minutes + ' ' + ampm;
                        }

                        // Assuming data.start_time and data.end_time are available
                        var timeStringStart = data.start_time; // Example: "05:00:00"
                        var timeStringEnd = data.end_time; // Example: "17:00:00"

                        // Format the start and end times
                        var startTime = formatTime(timeStringStart);
                        var endTime = formatTime(timeStringEnd);

                        console.log('Start Time:', startTime); // This should log the start time in 12-hour format with AM/PM
                        console.log('End Time:', endTime);

                            // var endTime = data.start_time
                            // Get the current date and time
                            var now = new Date();

                            // Compare the current time with the end time of the event
                            var eventEndTime = new Date(endTime);
                            var isEventEnded = now > eventEndTime;
                            
                            // console.log(data.role);
                            if (data.role === 'professor'){
                                Swal.fire({
                                    title: 'Event Details',
                                    html: '<div style="text-align: center;"><img src="https://api.qrserver.com/v1/create-qr-code/?data=' + data.feedback_image + '&amp;size=100x100" style="width: 100px; height: 100px; margin: 0 auto; display: block;"><p>QR Code of Feedback Form</p></div>' +
                                        'Status: <strong style="color: ' + (info.event.extendedProps.status === 'PENDING' ? '#D6AD60' : 'green') + '">' + info.event.extendedProps.status +
                                        '</strong><br>' +
                                        'Event: <strong>' + info.event.title + '</strong><br>' +
                                        'Event Organizer: <strong>' + data.eventOrganizerName + '</strong><br>' +
                                        'Start Time: <strong>' + startTime + '</strong><br>' +
                                        'End Time: <strong>' + endTime + '</strong><br>' +
                                        'Location: <strong>' + (data.roomName ? data.roomName : (data.venueName ? data.venueName : 'Unknown')) + '</strong><br>' +
                                        'Organization: <strong>' + (data.role === 'professor' ? 'FACULTY' : (data.role === 'staff' ? 'STAFF/ADMIN' : (data.role === 'student' ? data.organization : (data.role === 'outsider' ? 'OUTSIDER' : 'UNKNOWN')))) + '</strong><br>' +
                                        'Department: <strong>' + (data.role === 'professor' ? 'FACULTY' : (data.role === 'staff' ? 'STAFF/ADMIN' : (data.role === 'student' ? data.department : (data.role === 'outsider' ? 'OUTSIDER' : 'UNKNOWN')))) + '</strong><br>' +
                                        '<strong>ELEVATOR AND AIRCON SHOULD BE TURNED ON</strong>',
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                });
                            }
                            else{
                                Swal.fire({
                                    title: 'Event Details',
                                    html: '<div style="text-align: center;">' + (data.feedback_image ? 
                                        '<img src="https://api.qrserver.com/v1/create-qr-code/?data=' + data.feedback_image + '&amp;size=100x100" style="width: 100px; height: 100px; margin: 0 auto; display: block;"><p>QR Code of Feedback Form</p>' :
                                        '<p>No QR Code Available</p>') + '</div>' +
                                        'Date: <strong>' + eventStartDate + '</strong><br>' +
                                        'Start Time: <strong>' + startTime + '</strong><br>' +
                                        'End Time: <strong>' + endTime + '</strong><br>' +
                                        'Status: <strong style="color: ' + (info.event.extendedProps.status === 'PENDING' ? '#D6AD60' : 'green') + '">' + info.event.extendedProps.status + '</strong><br>' +
                                        'Event: <strong>' + info.event.title + '</strong><br>' +
                                        'Event Organizer: <strong>' + data.eventOrganizerName + '</strong><br>' +
                                        'Location: <strong>' + (data.roomName ? data.roomName : (data.venueName ? data.venueName : 'Unknown')) + '</strong><br>' +
                                        'Organization: <strong>' + (data.role === 'professor' ? 'FACULTY' : (data.role === 'staff' ? 'STAFF/ADMIN' : (data.role === 'student' ? data.organization : (data.role === 'outsider' ? 'OUTSIDER' : 'UNKNOWN')))) + '</strong><br>' +
                                        'Department: <strong>' + (data.role === 'professor' ? 'FACULTY' : (data.role === 'staff' ? 'STAFF/ADMIN' : (data.role === 'student' ? data.department : (data.role === 'outsider' ? 'OUTSIDER' : 'UNKNOWN')))) + '</strong>',
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                });
                            }
                            // Handle the successful response from the server

                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.error('Error fetching event data:', error);
                            console.log('Error fetching event data:', error);
                        }
                    });
                    // Change the border color to red
                    info.el.style.borderColor = 'red';
                },
                eventTextColor: 'black'
            });
            calendar.render();

            calendar.on('dateClick', function(info) {
                console.log('clicked on ' + info.dateStr);
                // Swal.fire('clicked on ' + info.dateStr);
            });
        });
    </script>


</x-guest-layout>

<style>
    .dot {
  height: 10px;
  width: 10px;
  border-radius: 50%;
  display: inline-block;
  margin-right: 5px;
}
</style>
