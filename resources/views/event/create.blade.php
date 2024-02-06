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
                                                        id="event_venue" value= "{{ $venue->id }}" required>
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
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Set Date</label>
                            <input type="date" class="form-control" name="event_date" id="event_date" required>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="start_time" class="form-label">Set Start Time</label>
                                <input type="time" class="form-control" name="start_time" id="start_time" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="end_time" class="form-label">Set End Time</label>
                                <input type="time" class="form-control" name="end_time" id="end_time" required>
                            </div>
                        </div>
                    </div>

                    {{-- GENERATE LETTER DETAILS --}}
                    <div class="tab d-none">
                        <h3>Generate Letter</h3>
                        <p>All Set! Please submit to continue. Thank you</p>

                        <div class="container p-4 ">
                            <textarea name="letter_generator" id="editor"></textarea>
                        </div>
                        <div class="mb-3 col-md-6" style="align-self: center">
                            <center>
                                <label for="request_letter" class="form-label" style="font-size: 18px">Upload Request
                                    Letter</label>
                                <input type="file" class="form-control" name="request_letter" id="request_letter"
                                    required>
                            </center>
                        </div>

                    </div>
                </div>

                <div class="card-footer text-end">
                    <div class="d-flex">
                        <button type="button" id="back_button" class="btn btn-link" onclick="back()">Back</button>
                        <button type="button" id="next_button" class="btn btn-primary ms-auto"
                            onclick="next()">Next</button>
                        <button type="submit" id="createEvent_submit"
                            class="btn btn-primary ms-auto">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
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
        $("#createEvent_submit").hide()
        var current = 0;
        var tabs = $(".tab");
        var tabs_pill = $(".tab-pills");

        loadFormData(current);

        function loadFormData(n) {

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
            $("#createEvent_submit").hide()
            current--;
            loadFormData(current);
        }

        ////// DATE  ///////
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('event_date').min = today;

        //// TIME /////
        function isDisabledTime(time) {
            // Add your condition here
            // For example, let's disable times between 12:00 PM and 1:00 PM
            const disabledStart = '12:00';
            const disabledEnd = '13:00';

            return time >= disabledStart && time <= disabledEnd;
        }

        // Attach an event listener to the time picker
        document.getElementById('start_time').addEventListener('input', function() {
            const selectedTime = this.value;

            // Check if the selected time is disabled
            if (isDisabledTime(selectedTime)) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "That time is not available!"
                });
                this.value = ''; // Clear the input value
            }
        });
    </script>
</x-app-layout>
