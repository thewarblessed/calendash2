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
    <script>
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('myCalendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                events: [  // Array of event objects
                    {
                        title: 'Event 1',
                        start: '2024-01-11T10:00:00',  // Start time in ISO format (YYYY-MM-DDTHH:mm:ss)
                        end: '2024-01-11T12:00:00',
                        color: getRandomColor()
                    },
                    {
                        title: 'Event 2',
                        start: '2024-01-11T13:00:00',  // Start time in ISO format (YYYY-MM-DDTHH:mm:ss)
                        end: '2024-01-11T14:00:00',
                        color: getRandomColor()
                    },
                    {
                        title: 'Event 3',
                        start: '2024-01-11T15:00:00',  // Start time in ISO format (YYYY-MM-DDTHH:mm:ss)
                        end: '2024-01-11T16:00:00',
                        color: getRandomColor()
                    },
                    {
                        title: 'Event 4',
                        start: '2024-01-11T17:00:00',  // Start time in ISO format (YYYY-MM-DDTHH:mm:ss)
                        end: '2024-01-11T18:00:00',
                        color: getRandomColor()
                    },
                    {
                        title: 'Event 2',
                        start: '2024-01-15T15:30:00',
                        end: '2024-01-15T17:00:00',
                        color: getRandomColor()
                    },
                    {
                        title: 'ACSO WEEK',
                        start: '2024-01-22',
                        end: '2024-01-27T00:00:00',
                        color: getRandomColor()
                    },
                    {
                        title: 'BATTLE OF THE BANDS',
                        start: '2024-01-22T15:30:00',
                        end: '2024-01-22T17:00:00',
                        color: getRandomColor()
                    },
                    
                    // Add more events as needed
                ]
            });
            calendar.render();
        });
    </script>


</x-app-layout>
