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
                                    <h6 class="font-weight-semibold text-lg mb-0">Officials list</h6>
                                    <p class="text-sm">See information about all members</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-white me-2">
                                        View all
                                    </button>
                                    <a type="button"
                                    href="{{ route('AdminCreateOfficials') }}" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                                <path
                                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                            </svg>
                                        </span>
                                        <span class="btn-inner--text">Add officials</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            {{-- <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
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
                            </div> --}}
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="officialTable">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15" >NAME
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-15">Email</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">Position</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">Department</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-15">Organization</th>
                                            <th class="text-secondary opacity-7"></th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="officialBody">
                                        @foreach($officials as $official)
                                        <tr>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$official->name}}</p>
                                                
                                            </td>
                                            <td class="align-left text-sm">
                                                <span
                                                    class="text-sm text-dark font-weight-semibold mb-0">{{$official->email}}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($official->role === 'org_adviser')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">Organization Adviser</span>
                                                @elseif($official->role === 'section_head')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">Section Head</span>
                                                @elseif($official->role === 'department_head')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">Department Head</span>
                                                @elseif($official->role === 'osa')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">OSA</span>
                                                @elseif($official->role === 'atty')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">ATTY</span>
                                                @elseif($official->role === 'adaa')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">ADAA</span>
                                                @elseif($official->role === 'campus_director')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">Campus Director</span>
                                                @elseif($official->role === 'business_manager')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">Business Manager</span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                @if($official->department === null)
                                                <span class="text-sm text-dark font-weight-semibold mb-0">None</span>
                                                @else
                                                <span class="text-sm text-dark font-weight-semibold mb-0">{{$official->department}}</span>
                                                @endif
                                            </td>

                                            <td class="align-middle text-center text-sm">
                                                @if($official->organization === null)
                                                <span class="text-sm text-dark font-weight-semibold mb-0">None</span>
                                                @else
                                                <span class="text-sm text-dark font-weight-semibold mb-0">{{$official->organization}}</span>
                                                @endif
                                            </td>

                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold editOfficial"
                                                    data-bs-toggle="tooltip" data-id="{{$official->id}}" data-bs-title="Edit official">
                                                    <i class="fa-solid fa-pen-to-square fa-xl"
                                                        style="color:#774dd3"></i>    
                                                </a>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold deleteOfficial"
                                                    data-bs-toggle="tooltip" data-id="{{$official->id}}" data-bs-title="Delete official">
                                                    <i class="fa-solid fa-trash fa-xl" style="color:red"></i>
                                                </a>
                                            </td>
                                            
                                            
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                {{-- <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                                <div class="ms-auto">
                                    <button class="btn btn-sm btn-white mb-0">Previous</button>
                                    <button class="btn btn-sm btn-white mb-0">Next</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editOfficialModal" tabindex="-1" role="dialog" aria-labelledby="createVenueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h2 class="modal-title" id="createVenueModalLabel" >Edit Official</h2>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="officialUpdateForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                              <label for="exampleFormControlInput1">Name</label>
                              <input name="officialEditId" type="text" class="form-control" id="officialEditId" hidden>
                              <input name="officialEditName" type="text" class="form-control" id="officialEditName" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Email</label>
                                <input name="officialEditEmail" type="text" class="form-control" id="officialEditEmail" required>
                            </div>
                            

                            {{-- <div class="form-group">
                                <label for="exampleFormControlInput1">Department</label>
                                <input name="officialEditDepartment" type="text" class="form-control" id="officialEditDepartment" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput1">Organization</label>
                                <input name="officialEditOrganization" type="text" class="form-control" id="officialEditOrganization" required>
                            </div> --}}

                            <div class="form-group" style="display: ;" id="officialSelectOrgDiv">
                                <label for="organization_id">Organization</label>
                                <select class="form-control" id="organization_id" name="organization_id">
                                  @foreach ($organizations as $id => $organization)
                                  <option value="{{ $id }}">{{ $organization }}</option>
                                  @endforeach
                                </select>
                              </div>
              
                              <div class="form-group" style="display: ;" id="officialSelectDeptDiv">
                                <label for="organization_id">Department</label>
                                <select class="form-control" id="department_id" name="department_id">
                                  @foreach ($departments as $id => $department)
                                    @if ($id >= 1 && $id <= 5)
                                            <option value="{{ $id }}">{{ $department }}</option>
                                    @endif
                                  @endforeach
                                </select>
                              </div>
                            
                          
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-dark" id="officialUpdate">Save changes</button>
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
