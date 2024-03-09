<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />

        <div class="container-fluid py-4 px-5">
            <div class="py-4"> <!-- Add padding to create space -->
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Approved Events in {{$venue->name}}
                </h2>
            </div>
            <div class="py-4">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            @if ($events->count() > 0)
                                <div class="table-responsive"> <!-- Add this div for responsiveness -->
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    Event Name
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    Description
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    Type
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    Start Date
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    Start Time
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    End Date
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    End Time
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    Participants
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    Department
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-sm font-semibold text-white bg-dark bg-blue-500 uppercase tracking-wider">
                                                    Organization
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($events as $event)
                                                {{-- @if ($event->venue_id == $selectedVenue->id) --}}
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->event_name }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->description }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->type }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->start_date }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->start_time }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->end_date }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->end_time }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->participants }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->target_dept }}
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="px-6 py-4 whitespace-nowrap text-dark">
                                                        <div class="text-sm text-gray-900">{{ $event->target_org }}
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{-- @endif --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class=text-center>
                                        <p>No approved events found for this venue.</p>
                                    </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ url('venues') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </main>
</x-app-layout>
