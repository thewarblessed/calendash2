<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                        <div class="full-background"
                            style="background-image: url('../assets/img/header-blue-purple.jpg')"></div>
                        <div class="card-body text-start p-4 w-100">
                            <h3 class="text-white mb-2 text-center">Event Calendar</h3>
                            <p class="mb-4 font-weight-semibold text-center">
                                Check all the pending and approved events
                            </p>

                            <!-- Button trigger modal -->

                            <img src="../assets/img/calender-iso-gradient.png" alt="3d-cube"
                                class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none"
                                style="width: 350px; height: 250px;" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="myCalendar">

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
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
                    console.log(info.event.id)
                    var id = info.event.id;
                    $.ajax({
                        url: 'api/getCalendarEvent/' + id,
                        method: 'GET',
                        data: {
                            eventId: info.event.id // Pass any necessary data, such as the event ID
                        },
                        success: function(response) {
                            var data = response;
                            console.log(data);
                            console.log(data.type);
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
    <style>
        .event {
            display: flex;
            align-items: center;
        }

        .event-dot{
            width: 10px;
            height: 10px;
            margin-right: 5px;
            border-radius: 50%;
            background-color: #6119d6;
        }

        .event-PENDING {
            font-size: 13px;
            font-weight: 600;
            padding: 5px;
            border-radius: 5px;
            background-color: #f9c275;
        }

        .event-APPROVED {
            font-size: 13px;
            font-weight: 600;
            padding: 5px;
            border-radius: 5px;
            background-color: #f9c275;
            background-color: #4caf50;
        }
    </style>
</x-app-layout>
