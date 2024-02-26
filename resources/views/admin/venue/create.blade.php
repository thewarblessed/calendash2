<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4" style="padding: 50px">
                        <div>
                            <h3 style="text-align: center">CREATE VENUE</h3>
                            {{-- method="POST" action="{{ route('storeVenue') }}" enctype="multipart/form-data" --}}
                            <form role="form" id="vForm" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Name of the Venue</label>
                                    <input type="text" class="form-control" name="venueName" id="venueName" required>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="venueDesc" id="venueDesc" rows="20" required></textarea>
                                </div>


                                <div class="form-group">
                                    <label>Capacity</label>
                                    <input type="number" class="form-control" name="venueCapacity" id="venueCapacity"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>Upload Image</label>
                                    <input type="file" class="form-control" id="image" name="image"required>
                                </div>

                                <style>
                                    #venueDesc {
                                        resize: none;
                                        /* Prevent resizing of textarea */
                                    }

                                    #venueDesc::before {
                                        content: "\2022";
                                        /* Bullet point character */
                                        margin-right: 5px;
                                        /* Spacing between bullet point and text */
                                        display: block;
                                        float: left;
                                        font-size: 1.2em;
                                    }

                                    /* Adjust spacing between bullet points */
                                    #venueDesc+#venueDesc::before {
                                        margin-top: 10px;
                                    }
                                </style>
                                {{-- <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group has-success">
                                      <input type="text" placeholder="Success" class="form-control is-valid" />
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group has-danger">
                                      <input type="email" placeholder="Error Input" class="form-control is-invalid" />
                                    </div>
                                  </div>
                                </div> --}}
                                <button type="submit" class="btn btn-primary btn-lg w-100"
                                    id="venueSubmit">SAVE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>
