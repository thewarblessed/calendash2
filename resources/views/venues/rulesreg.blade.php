<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card my-5"><br>

                        @foreach ($venues as $venue)
                            <h5 id="venueName" class="card-title" style="text-align: center">{{ $venue->name }}</h5>
                            <div class="text-center"> <!-- Added text-center class here -->
                                <img src="{{ asset('storage/' . $venue->image) }}" width="500" height="300"
                                    style="border-radius: 8px;" />
                            </div><br>

                            <!-- Button for modal -->
                            <div class="card-body text-center">
                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                    <label class="font-weight-normal text-dark mb-0" for="terms">
                                        <button type="button" id="processLetter"
                                            class="btn btn-primary text-white font-weight-bold no-hover">
                                            <a href="#" class="btn-link text-white"
                                                onclick="showProcessLetterModal()">PROCESS OF THE LETTER CLICK HERE</a>
                                        </button>
                                    </label>
                                </p>
                            </div>

                            <!-- Modal for Process of letter -->
                            <div class="modal fade" id="processLetterModal" tabindex="-1" role="dialog"
                                aria-labelledby="processLetterModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="processLetterModalLabel">Process of the Letter
                                                for
                                                this Venue</h5>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div style="text-align: justify; text-justify: inter-word; padding: 20px;">
                                                <p>ORGANIZATION ADVISER</p>
                                                <p>SECTION HEAD</p>
                                                <p>DEPARTMENT HEAD</p>
                                                <p>OSA</p>
                                                <p>ADAA</p>
                                                <p id="campusDirector" style="display: none;">CAMPUS DIRECTOR</p>
                                                <p id="adaf" style="display: none;">ADAF</p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"
                                                data-bs-dismiss="modal">Close</button>
                                            <span aria-hidden="true"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function showProcessLetterModal() {
                                    $('#processLetterModal').modal('show');
                                    var venueName = document.getElementById('venueName').innerText.trim();
                                    var campusDirector = document.getElementById('campusDirector');
                                    var adaf = document.getElementById('adaf');

                                    // Check condition and toggle visibility
                                    if (venueName === 'IT Auditorium') {
                                        adaf.style.display = 'block';
                                    } else {
                                        campusDirector.style.display = 'block';
                                    }
                                }
                            </script>

                            <div class="card-header">
                                <h5 class="card-title">Policies and Guidelines:</h5>
                            </div>
                            <div class="card" style="margin-left: 45px; margin-right: 45px;"><br>
                                <ul>
                                    {!! nl2br($venue->description) !!}
                                </ul>
                            </div>
                        @endforeach
                        <br>

                    </div>

                    <div class="card-footer">
                        <a href="{{ url('venues') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
        </div>
</x-app-layout>
