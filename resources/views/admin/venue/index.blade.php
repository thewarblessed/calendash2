<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Venues list</h6>
                                    <p class="text-sm">See information about all members</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-white me-2">
                                        View all
                                    </button>
                                    <a type="button"
                                    href="{{ route('adminVenueCreate') }}" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                                <path
                                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                            </svg>
                                        </span>
                                        <span class="btn-inner--text">Add venue</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable1"
                                        autocomplete="off" checked>
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable1">All</label>
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable2"
                                        autocomplete="off">
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable2">Monitored</label>
                                    <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable3"
                                        autocomplete="off">
                                    <label class="btn btn-white px-3 mb-0" for="btnradiotable3">Unmonitored</label>
                                </div>
                                <div class="input-group w-sm-25 ms-auto">
                                    <span class="input-group-text text-body">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="text" class="form-control" placeholder="Search">
                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="venueTable">
                                    <thead class="bg-gray-100">
                                        <tr>       
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15" >VENUE NAME
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-2">
                                                Description
                                            </th>
               
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">
                                                Capacity</th>
                                            
                                            <th class="text-secondary opacity-7"></th>
                                            
                                        </tr>
                                        
                                    </thead>
                                    <tbody id="venueBody">
                                        @foreach($venues as $venue)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex align-items-center" style="margin-right: 40px">
                                                        
                                                        <img src="{{ asset('storage/'.$venue->image) }}" width="100" height="100" style="border-radius: 50%;"/>
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center ms-1">
                                                        <h6 class="mb-0 text-sm font-weight-semibold">{{$venue->name}}</h6>
                                                        <p class="text-sm text-secondary mb-0">
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
                                                    <ul>
                                                        @foreach (explode("\n", $venue->description) as $line)
                                                            <ol>{{ $line }}</ol>
                                                        @endforeach
                                                    </ul>
                                                </p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="text-sm text-dark font-weight-semibold mb-0">{{$venue->capacity}}</span>
                                            </td>
                                            {{-- <td class="align-middle text-center">
                                                <span class="text-secondary text-sm font-weight-normal">{{$venue->name}}</span>
                                                
                                            </td> --}}
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs editBtn"
                                                    data-bs-toggle="tooltip" data-bs-title="Edit user" data-id="{{$venue->id}}">
                                                    <i id="editVenue" class="fa-solid fa-pen-to-square fa-2xl" style="color: #5a38b7;"></i>
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs deleteBtn"
                                                    data-bs-toggle="tooltip" data-bs-title="Delete user" data-id="{{$venue->id}}">
                                                    <i id="deleteVenue" class="fa-solid fa-trash fa-2xl" style="color: #e10505;"></i>
                                                </a>
                                            </td>
                                            
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                                <div class="ms-auto">
                                    <button class="btn btn-sm btn-white mb-0">Previous</button>
                                    <button class="btn btn-sm btn-white mb-0">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="createVenueModal" tabindex="-1" role="dialog" aria-labelledby="createVenueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h2 class="modal-title" id="createVenueModalLabel" >Edit Venue</h2>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="venueUpdateForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                              <label for="exampleFormControlInput1">Name of the venue</label>
                              <input name="venueEditId" type="text" class="form-control" id="venueEditId" hidden>
                              <input name="venueEditName" type="text" class="form-control" id="venueEditName" required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleFormControlInput1">Description</label>
                                <input name="venueEditDesc" type="text" class="form-control" id="venueEditDesc" required>
                            </div>   --}}
                             
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="venueEditDesc" id="venueEditDesc" rows="20" required></textarea>
                                </div>

                            
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Capacity</label>
                                <input name="venueEditCapacity" type="text" class="form-control" id="venueEditCapacity" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Upload Image</label>
                                <input name="venueEditImage" type="file" class="form-control" id="venueEditImage" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-dark" id="venueUpdate">Save changes</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
                </div>
            </div>
           
            <x-app.footer />
        </div>
    </main><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>
