<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="container-xl px-4 mt-4">
                <h2>PLEASE COMPLETE YOUR PROFILE FIRST</h2>
                <hr class="mt-0 mb-4">
                <div class="row">
                    {{-- <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <!-- Profile picture image-->
                                <img class="img-account-profile rounded-circle mb-2"
                                    src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                <!-- Profile picture help block-->
                                <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                <!-- Profile picture upload button-->
                                <button class="btn btn-primary" type="button">Upload new image</button>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-xl-8">
                        <!-- Account details card-->

                    </div>

                </div>
                <div class="card mb-4" style="padding: 30px">
                    <h2 class="card-header">Profile Details</h2>
                    <div class="card-body">
                        <form role="form" id="compeleteProfileForm" enctype="multipart/form-data">
                            @csrf
                            <!-- Form Group (username)-->
                            {{-- <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Username (how your name will appear to
                                    other users on the site)</label>
                                <input class="form-control" id="inputUsername" type="text"
                                    placeholder="Enter your username" value="username">
                            </div> --}}
                            <!-- Form Row-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Select Role:</label>
                                <select class="form-control" id="user_role" name="user_role">
                                    <option value="student">STUDENT</option>
                                    <option value="professor">FACULTY</option>
                                    <option value="staff">STAFF/ADMIN</option>
                                    <option value="outsider">OUTSIDE THE TUP</option>
                                </select>
                            </div>
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputFirstName">First name</label>
                                    <input class="form-control" id="inputFirstName" name="firstname" type="text"
                                        placeholder="Enter your first name" value="{{ Auth::user()->name }}" required>
                                    <input class="form-control" id="inputFirstName" name="user_id" type="text"
                                        placeholder="Enter your first name" value="{{ Auth::user()->id }}" hidden>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                    <input class="form-control" id="inputLastName" name="lastname" type="text"
                                        placeholder="Enter your last name" value="" required>
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (department)-->
                                <div class="col-md-6" style="display: block;" id="depDivCompleteProfile">
                                    <label for="organization_id">Select Department</label>
                                    <select class="form-control" id="department_id_user" name="department_id_user">
                                        @foreach ($departments as $id => $department)
                                            @if ($id >= 1 && $id <= 5)
                                                <option value="{{ $id }}">{{ $department }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6" style="display: block;" id="orgDivCompleteProfile">
                                    <label for="organization_id">Select Organization</label>
                                    <select class="form-control" id="organization_id_user" name="organization_id_user">
                                        @foreach ($organizations as $id => $organization)
                                            <option value="{{ $id }}">{{ $organization }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6" style="display: none;" id="depDivStaffCompleteProfile">
                                    <label for="organization_id">Select Department</label>
                                    <select class="form-control" id="department_id_staff" name="department_id_staff">
                                        @foreach ($departments as $id => $department)
                                            @if ($id >= 6 && $id <= 13)
                                                <option value="{{ $id }}">{{ $department }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="display: block;" id="sectDivCompleteProfile">
                                <label for="organization_id">Select Section</label>
                                <select class="form-control" id="section_id_user" name="section_id_user">
                                    @foreach ($sections as $id => $section)
                                        <option value="{{ $id }}">{{ $section }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3" id="tupIDdiv">
                                <label class="small mb-1" for="inputEmailAddress">TUP ID NO.</label>
                                <input class="form-control" id="inputEmailAddress" name="tupID" type="text"
                                    placeholder="Enter your TUP ID (ex. TUPT-XX-XXXX)" value="">
                            </div>

                            <div class="mb-3" id="tupIDphotoDiv">
                                <label class="small mb-1" for="inputImageID">Upload Image of your TUP ID</label>
                                <input class="form-control" id="inputImageID" name="image" type="file"
                                    placeholder="Enter your TUP ID (ex. TUPT-XX-XXXX)" value="">
                            </div>

                            {{-- <div class="mb-3" id="validIDphotoDiv" style="display: none;">
                                <label class="small mb-1" for="inputValidID">Upload image of any Valid ID</label>
                                <input class="form-control" id="inputValidID" name="validIDimage" type="file"
                                    placeholder="Enter your TUP ID (ex. TUPT-XX-XXXX)" value="" >
                            </div> --}}

                            <div class="mb-3" id="validIDphotoDiv" style="display: none;">
                                <label class="small mb-1" for="inputValidID">Upload image of any Valid ID</label>
                                <input class="form-control" id="inputValidID" name="validIDimage" type="file"
                                    placeholder="Enter your TUP ID (ex. TUPT-XX-XXXX)" value="">
                                    <h6 class="text-muted">Please upload a clear photo of a valid government ID. Accepted
                                        IDs include: </h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul>
                                            <li>e-Card / UMID</li>
                                            <li>Driver’s License</li>
                                            <li>Passport</li>
                                            <li>Senior Citizen ID</li>
                                            <li>SSS ID</li>
                                            <li>COMELEC / Voter’s ID </li>
                                            <li>Pag-ibig ID</li>
                                            <li>Philippine Identification (PhilID / ePhilID)</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <ul>   
                                            <li>Integrated Bar of the Philippines (IBP) ID</li>
                                            <li>BIR (TIN)</li>
                                            <li>Solo Parent ID</li>
                                            <li>Pantawid Pamilya Pilipino Program (4Ps) ID *</li>
                                            <li>Barangay ID</li>
                                            <li>Philippine Postal ID</li>
                                            <li>Phil-health ID</li>
                                            <li>Other valid government-issued IDs or Documents with picture and signature</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                                // Script to show/hide the list of valid IDs based on selected role
                                $(document).ready(function() {
                                    $('#user_role').on('change', function() {
                                        if (this.value === 'outsider') {
                                            $('#validIDphotoDiv').show();
                                        } else {
                                            $('#validIDphotoDiv').hide();
                                        }
                                    });
                                });
                            </script>
                            
                            
                    </div>
                </div>




                <!-- Form Row-->
                {{-- <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                    <input class="form-control" id="inputPhone" type="tel"
                                        placeholder="Enter your phone number" value="">
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputBirthday">Birthday</label>
                                    <input class="form-control" id="inputBirthday" type="text" name="birthday"
                                        placeholder="Enter your birthday" value="">
                                </div>
                            </div> --}}
                <!-- Save changes button-->
                <button class="btn btn-primary" type="button" id="completeProfileSubmit">Save
                    changes</button>
                </form>
            </div>
        </div>
        </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>
