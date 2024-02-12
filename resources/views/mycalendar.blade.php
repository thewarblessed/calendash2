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
                            <h3 class="text-white mb-2">Event Calendar</h3>
                            <p class="mb-4 font-weight-semibold">
                                Check all the pendind and approved events!.
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
                            console.log(data)
                            // Handle the successful response from the server
                            Swal.fire({
                                title: 'Event Details',
                                html:'Status: <strong>' + info.event.extendedProps.status +
                                    '</strong><br>' +
                                    'Event: <strong>' + info.event.title + '</strong><br>' +
                                    'Start Time: <strong>' + info.event.start
                                    .toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    }) + '</strong><br>' +
                                    'End Time: <strong>' + info.event.end
                                    .toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    }) + '</strong><br>' +
                                    'Location: <strong>' + data.name + '</strong><br>' +
                                    'Organization: <strong>' + data.studOrg + '</strong><br>' +
                                    'Department: <strong>' + data.department +'</strong>',  
                                showCloseButton: true,
                                showConfirmButton: false,
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            console.error('Error fetching event data:', error);
                        }
                    });
                    info.el.style.borderColor = 'red';
                },
                eventContent: function(info) {
                    // Create the basic event structure
                    return {
                        html: `
                <span class="event-dot"></span>
                <span class="event-${info.event.extendedProps.status}">${info.event.title}: ${info.event.extendedProps.status}</span> 
                <span class="event-color"></span>
            `,
                        classList: ['event'], // Base class for all events
                        extendedProps: event // Pass event data to the DOM node
                    };
                }
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
