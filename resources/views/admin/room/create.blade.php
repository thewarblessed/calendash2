<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4" style="padding: 50px">
                        <div>
                            <h3 style="text-align: center">CREATE ROOM</h3>
                            {{-- method="POST" action="{{ route('storeVenue') }}" enctype="multipart/form-data" --}}
                            <form role="form" id="roomForm" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Room Name</label>
                                    <input type="text" class="form-control" name="roomName" id="roomName" required>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="roomDesc" id="roomDesc" rows="20" required></textarea>
                                </div>


                                <div class="form-group">
                                    <label>Capacity</label>
                                    <input type="number" class="form-control" name="roomCapacity" id="roomCapacity"
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
                                <button type="submit" class="btn btn-primary btn-lg w-100"
                                    id="roomSubmit">SAVE</button>
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
