<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg" id="main">
        <x-app.navbar />
        <div class="container" style="margin-top: 20px">
            <form class="card">
                <div class="card-header">
                    <nav class="nav nav-pills nav-fill">
                        <a class="nav-link tab-pills" href="#">Personal Details</a>
                        <a class="nav-link tab-pills" href="#">Address Details</a>
                        <a class="nav-link tab-pills" href="#">Company Details</a>
                        <a class="nav-link tab-pills" href="#">Finish</a>
                    </nav>
                </div>
                <div class="card-body">
                    {{-- EVENT DETAILS --}}
                    <div class="tab d-none">
                        <h3 style="text-align: center">Event Details</h3>

                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" name="eventName" id="eventName"
                                placeholder="Please enter event name">
                        </div>
                        <div class="mb-3">
                            <label for="numParticipants" class="form-label">No. of participants</label>
                            <input type="number" class="form-control" name="numParticipants" id="numParticipants"
                                placeholder="Please enter no. of participants (ex. 100)">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Please enter password">
                        </div> --}}
                    </div>

                    {{-- VENUE DETAILS --}}
                    <div class="tab d-none">
                        <h3 style="text-align: center">Available Venues</h3>
                        <div class="form-group">
                            <div class="container">
                                <div class="row">
                                    {{-- @foreach ($venues as $venue)
                                        <div class="col-sm">
                                            <div id="venue{{ $venue->id }}" class="card"
                                                style="width: 15rem; margin-bottom: 20px; border: 4px solid rgb(53, 9, 86)">
                                                <div id="venue{{ $venue->id }}"
                                                    data-capacity="{{ $venue->capacity }}" class="card_capacity"
                                                    style="width: 15rem; box-shadow: rgba(0, 0, 0, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px; border-radius: 8px">
                                                    <img src="{{ asset('storage/' . $venue->image) }}" height="180"
                                                        class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $venue->name }}</h5>
                                                        <p class="card-text">{{ $venue->description }}</p>
                                                        <p class="card-text">Capacity: {{ $venue->capacity }}</p>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="flexRadioDefault" id="customRadio2">
                                                            <label class="custom-control-label" for="customRadio2"
                                                                style="color: blue; font-size: 18px"><strong>SELECT</strong>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SET DATE DETAILS --}}
                <div class="tab d-none">
                    <h3 style="text-align: center">Set Date and Time</h3>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Set Date</label>
                        <input type="date" class="form-control" name="event_date" id="event_date"
                            placeholder="Please enter company name">
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="start_time" class="form-label">Set Start Time</label>
                            <input type="time" class="form-control" name="start_time" id="start_time"
                                placeholder="Please enter city">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="end_time" class="form-label">Set End Time</label>
                            <input type="time" class="form-control" name="end_time" id="end_time"
                                placeholder="Please enter state">
                        </div>
                    </div>
                </div>

                {{-- GENERATE LETTER DETAILS --}}
                <div class="tab d-none">
                    <h3>Generate Letter</h3>
                    <p>All Set! Please submit to continue. Thank you</p>

                    <div class="container p-4 ">
                        <textarea id="editor"></textarea>
                    </div>

                </div>
        </div>
        <div class="card-footer text-end">
            <div class="d-flex">
                <button type="button" id="back_button" class="btn btn-link" onclick="back()">Back</button>
                <button type="button" id="next_button" class="btn btn-primary ms-auto"
                    onclick="next()">Next</button>
                <button type="submit" id="submit_button" class="btn btn-primary ms-auto"
                    onclick="next()">Submit</button>
            </div>
        </div>
        </form>
        </div>
    </main>
    <script src="https://cdn.tiny.cloud/1/efy9kqrdbnc5rwfbz3ogkw1784y0tm6sphy6xvo6iq7azwcf/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#editor',
            plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                "See docs to implement AI Assistant")),
        });
    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"
        integrity="sha512-BmM0/BQlqh02wuK5Gz9yrbe7VyIVwOzD1o40yi1IsTjriX/NGF37NyXHfmFzIlMmoSIBXgqDiG1VNU6kB5dBbA=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script>
        $("#submit_button").hide()
        var current = 0;
        var tabs = $(".tab");
        var tabs_pill = $(".tab-pills");

        loadFormData(current);

        function loadFormData(n) {

            $(tabs_pill[n]).addClass("active");
            $(tabs[n]).removeClass("d-none");
            $("#back_button").attr("disabled", n == 0 ? true : false);
            n == tabs.length - 1 ?
                $("#next_button").hide() && $("#submit_button").show() :
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
            $("#submit_button").hide()
            current--;
            loadFormData(current);
        }
    </script>
</x-app-layout>
