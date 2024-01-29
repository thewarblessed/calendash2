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
                            <h3 class="text-white mb-2">Create your event!🎉🤩✨🔥</h3>
                            <p class="mb-4 font-weight-semibold">
                                Check all the advantages and choose the best.
                            </p>

                            <!-- Button trigger modal -->
                            <button type="button"
                                class="btn btn-outline-white btn-blur btn-icon d-flex align-items-center mb-0"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <span class="btn-inner--icon">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                &nbsp;&nbsp;
                                <span class="btn-inner--text">Create Event</span>
                            </button>
                            <img src="../assets/img/3d-cube.png" alt="3d-cube"
                                class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
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
                    Swal.fire('Event: ' + info.event.title);
                    // alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
                    // alert('View: ' + info.view.type);

                    // change the border color just for fun
                    info.el.style.borderColor = 'red';
                }
                // editable: true,
                // events: [{
                //         title: 'event1',
                //         start: '2024-01-01'
                //     },
                //     {
                //         title: 'event2',
                //         start: '2024-01-05',
                //         end: '2024-01-07'
                //     },
                //     {
                //         title: 'New Event',
                //         start: '2024-01-27T10:00:00', // Replace with the start date and time of your event
                //         end: '2024-01-27T12:00:00', // Replace with the end date and time of your event
                //         editable: true,
                //     },
                //     {
                //         title: 'event3',
                //         start: '2024-01-09T12:30:00',
                //         allDay: false // will make the time show
                //     }
                // ]

            });
            calendar.render();

            calendar.on('dateClick', function(info) {

                console.log('clicked on ' + info.dateStr);
                // Swal.fire('clicked on ' + info.dateStr);
            });


        });
    </script>


</x-app-layout>
