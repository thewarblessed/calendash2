<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card my-5">
                        <div class="card-header">
                            <h5 class="card-title text-center">FEEDBACK QR CODE FOR PARTICIPANTS </h5>
                        </div>

                        <div class="card-body" id="printable-area"> <!-- Add an ID to the card-body to identify it for printing -->
                            <p class="text-sm text-dark font-weight-semibold mb-0">
                                <!-- Fetch and display description from the database -->

                                {{-- <div class="card"> --}}
                            <div class="card-body">
                                {{-- <h5 class="card-title text-center">{{ $venues->name }}</h5> --}}
                                <div class="text-center">
                                    @if ($venues->events->isNotEmpty() && $venues->events->first()->feedback_image)
                                        <img src="{{ asset('storage/' . $venues->events->first()->feedback_image) }}"
                                            width="500" height="300" style="border-radius: 8px;" />
                                    @else
                                        <p>No feedback image available</p>
                                    @endif
                                </div>
                                <br>
                            </div>
                            </p>
                        </div>

                        <div class="card-footer">
                            <a href="{{ url('venues') }}" class="btn btn-primary">Back</a>
                            <button class="btn btn-success" onclick="printCard()">Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>

<script>
    function printCard() {
        var printContents = document.getElementById("printable-area").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<style>
    @media print {
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        @page {
            size: auto;
            margin: 0;
        }
        #printable-area {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    }
</style>
