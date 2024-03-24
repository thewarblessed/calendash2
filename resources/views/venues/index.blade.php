<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h3>Upcoming Events</h3>
                                    <p class="text-sm">List of your approved events</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    @foreach ($approvedVenues as $venue)
                                        @foreach ($venue->events as $event)
                                            <div class="card" style="width: 15rem; border: 2px solid rgb(216, 200, 231)">
                                                <img src="{{ asset('storage/'. $venue->image) }}" height="200" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $event->name }}</h5>
                                                    <p>Venue: {{ $venue->name }}</p> <!-- Display the venue name -->
                                                    <a href="{{ route('venueRulesreg', ['id' => $venue->id]) }}" class="btn btn-info mr-2" style="flex: 1;">Policies</a>
                                                    <a href="{{ route('venueFeedback', ['id' => $venue->id]) }}" class="btn btn-primary ml-2" style="flex: 1;">Feedback</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
