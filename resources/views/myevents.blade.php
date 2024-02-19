<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" id="main">
        <x-app.navbar />
        <div class="container" style="margin-top: 30px">
            <form method="POST" action="{{ route('postCreateMyEvent') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    {{-- SET DATE DETAILS --}}
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

                        <div id="wholeDayDiv" class="wholeDay">
                            <h5 style="text-align: center">Whole Day</h5>
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Set Date</label>
                                <input type="date" class="form-control" name="event_date_wholeDay" id="event_date_wholeDay">
                            </div>
                        </div>

                        <div id="wholeWeekDiv" class="wholeWeek">
                            <h5 style="text-align: center">Whole Week</h5>
                            <div class="form-group">
                                <label for="example-week-input" class="form-control-label">Week</label>
                                <input class="form-control" type="week" name="event_date_wholeWeek" id="event_date_wholeWeek">
                            </div>
                        </div>

                    
                </div>

                <div class="card-footer text-end">
                        <button type="submit" id="" class="btn btn-primary ms-auto">Submit</button>
                </div>
            </form>
        </div>
    </main>
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
    document.addEventListener("DOMContentLoaded", function() {
        const withinDayDiv = document.getElementById('withinTheDayDiv');
        const wholeDayDiv = document.getElementById('wholeDayDiv');
        const wholeWeekDiv = document.getElementById('wholeWeekDiv');

        const eventDate = document.getElementById('event_date');
        const startTimeWithinDay = document.getElementById('start_time_withinDay');
        const endTimeWithinDay = document.getElementById('end_time_withinDay');
        const WholeDay = document.getElementById('event_date_wholeDay');
        const WholeWeek = document.getElementById('event_date_wholeWeek');

        document.querySelectorAll('input[name="event_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.value === 'withinDay') {
                    WholeDay.removeAttribute('required');
                    WholeWeek.removeAttribute('required');

                    eventDate.value = "";
                    startTimeWithinDay.value = "";
                    endTimeWithinDay.value = "";

                    withinDayDiv.style.display = 'block';
                    wholeDayDiv.style.display = 'none';
                    wholeWeekDiv.style.display = 'none';

                    startTimeWithinDay.setAttribute('required', true);
                    endTimeWithinDay.setAttribute('required', true);
                    eventDate.setAttribute('required', true);
                } else if (this.value === 'wholeDay') {
                    startTimeWithinDay.removeAttribute('required');
                    endTimeWithinDay.removeAttribute('required');
                    eventDate.removeAttribute('required');

                    WholeWeek.removeAttribute('required');

                    WholeDay.value = "";

                    wholeWeekDiv.style.display = 'none';
                    withinDayDiv.style.display = 'none';
                    wholeDayDiv.style.display = 'block';
                    WholeDay.setAttribute('required', true);
                } else {
                    startTimeWithinDay.removeAttribute('required');
                    endTimeWithinDay.removeAttribute('required');
                    eventDate.removeAttribute('required');

                    WholeDay.removeAttribute('required');

                    WholeWeek.value = "";

                    wholeWeekDiv.style.display = 'block';
                    withinDayDiv.style.display = 'none';
                    wholeDayDiv.style.display = 'none';

                    WholeWeek.setAttribute('required', true);
                }
            });
        });
    });
    </script>
</x-app-layout>