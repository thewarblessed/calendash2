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
                                    <h6 class="font-weight-semibold text-lg mb-0">Pending Users list</h6>
                                    <p class="text-sm">See information about all members</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-white me-2">
                                        View all
                                    </button>
                                    {{-- <a type="button"
                                    href="" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                        <span class="btn-inner--icon">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                                <path
                                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                            </svg>
                                        </span>
                                        <span class="btn-inner--text">Add Users</span>
                                    </a> --}}
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
                                <table class="table align-items-center mb-0" id="pendingUsersTable">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-15" >TUP ID</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-15">Last Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-15">First Name</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-15">Email</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-15">Organization</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-15">Department</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-15 ps-15">Section</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Role</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="pendingUsersBody">
                                        @foreach($pendingUsers as $pendingUser)
                                        <tr>
                                            <td>
                                                @if($pendingUser->tupID === '0')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">N/A</span>
                                                @else
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$pendingUser->tupID}}</p>
                                                @endif
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">{{$pendingUser->lastname}}</p>
                                                
                                            </td>
                                            <td class="align-left text-sm">
                                                <span
                                                    class="text-sm text-dark font-weight-semibold mb-0">{{$pendingUser->firstname}}</span>
                                            </td>
                                            <td class="align-left text-sm">
                                                <span
                                                    class="text-sm text-dark font-weight-semibold mb-0">{{$pendingUser->email}}</span>
                                            </td>
                                            <td class="align-left text-sm">
                                                @if($pendingUser->organization === null)
                                                <span class="text-sm text-dark font-weight-semibold mb-0">N/A</span>
                                                @else
                                                <span class="text-sm text-dark font-weight-semibold mb-0">{{$pendingUser->organization}}</span>
                                                @endif
                                            </td>
                                            <td class="align-left text-sm">
                                                @if($pendingUser->department === null)
                                                <span class="text-sm text-dark font-weight-semibold mb-0">N/A</span>
                                                @else
                                                <span class="text-sm text-dark font-weight-semibold mb-0">{{$pendingUser->department}}</span>
                                                @endif
                                            </td>
                                            <td class="align-left text-sm">
                                                @if($pendingUser->section === null)
                                                <span class="text-sm text-dark font-weight-semibold mb-0">N/A</span>
                                                @else
                                                <span class="text-sm text-dark font-weight-semibold mb-0">{{$pendingUser->section}}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if($pendingUser->role === 'student')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">STUDENT</span>
                                                @elseif($pendingUser->role === 'professor')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">FACULTY</span>
                                                @elseif($pendingUser->role === 'staff')
                                                <span class="text-sm text-dark font-weight-semibold mb-0">STAFF</span>
                                                @else
                                                <span class="text-sm text-dark font-weight-semibold mb-0">OUTSIDE</span>
                                                @endif
                                            </td> 
                                                  
                                            <td class="align-middle text-center text-sm">
                                                {{-- <span class="text-sm text-dark font-weight-semibold mb-0">{{$pendingUser->role}}</span> --}}
                                                {{-- <button type="button" class="btn btn-dark btn-sm editRole"
                                                            data-bs-toggle="modal" data-id="{{ $pendingUser->user_id }}"
                                                            data-bs-target="#checkStatusModal">Edit Role</button> --}}
                                                @if($pendingUser->email_verified_at === null)
                                                <button type="button" class="btn btn-dark btn-sm approveAccounts" data-id="{{ $pendingUser->user_id }}" data-bs-toggle="modal" data-bs-target="#approveUserModal">Approve Account</button>
                                                @endif
                                            </td> 
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                {{ $pendingUsers->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="checkStatusModal" tabindex="-1" role="dialog" aria-labelledby="createVenueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h2 class="modal-title" id="createVenueModalLabel" >Edit Role</h2>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="roleUpdateForm" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputDepartment">Change Role</label>
                                <select class="form-control form-control-lg" id="role" name="role">
                                    <option value="student">STUDENT</option>
                                    <option value="professor">FACULTY</option>
                                    <option value="staff">ADMIN/STAFF</option>
                                  </select>
                            </div>
                            <div class="form-group">
                              <label for="exampleFormControlInput1">Last Name</label>
                              <input name="userId" type="text" class="form-control" id="userId" hidden>
                              <input name="userLastname" type="text" class="form-control" id="userLastname" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">First Name</label>
                                <input name="userFirstname" type="text" class="form-control" id="userFirstname" readonly>
                            </div>
                            <div class="form-group" id="orgDivCheckStatus">
                                <label for="exampleFormControlInput1">Organization</label>
                                <input name="userOrganization" type="text" class="form-control" id="userOrganization" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlInput1">Department</label>
                                <input name="userDepartment" type="text" class="form-control" id="userDepartment" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-dark" id="roleUpdate">Save changes</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
                </div>
            </div>

            <div class="modal fade" id="approveUserModal" tabindex="-1" role="dialog" aria-labelledby="createVenueModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h2 class="modal-title" id="createVenueModalLabel" >User Details</h2>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form id="roleUpdateForm" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Last Name:</label>
                                        <input name="userId" type="text" class="form-control" id="userApproveId" hidden>
                                        <p style="color: black" id="userApproveLastname" ></p>
                                      </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">First Name:</label>
                                        <p style="color: black" id="userApproveFirstname" ></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="orgDeptRowDiv">
                                <div class="col-md-6" id="orgDiv">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Organization:</label>
                                        <p style="color: black" id="userApproveOrganization" ></p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Department:</label>
                                        <p style="color: black" id="userApproveDepartment" ></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Role:</label>
                                        <p style="color: black" id="userApproveRole" ></p>
                                    </div>
                                </div>

                                <div class="col-md-6" id="sectionDiv">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Section:</label>
                                        <p style="color: black" id="userApproveSection" ></p>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group" id="tupIDdiv">
                                <label for="exampleFormControlInput1">TUP ID:</label>
                                <p style="color: black" id="userApproveTupID" ></p>
                            </div>

                              <div class="form-group text-center">
                                <label for="exampleFormControlInput1">TUP ID PHOTO:</label>
                                <div class="d-flex justify-content-center">
                                    <div id="userApproveTupIDPhoto"></div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger" id="rejectAccount">Reject account</button>
                                <button type="submit" class="btn btn-dark" id="approveAccount">Approve account</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
                </div>
            </div>
           
            {{-- <x-app.footer /> --}}
        </div>
    </main><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>
