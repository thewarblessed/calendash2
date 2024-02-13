<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="container-xl px-4 mt-4">
                <h2>PLEASE COMPLETE YOUR PROFILE FIRST</h2>
                <hr class="mt-0 mb-4">
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <!-- Profile picture image-->
                                <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                <!-- Profile picture help block-->
                                <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                <!-- Profile picture upload button-->
                                <button class="btn btn-primary" type="button">Upload new image</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">Profile Details</div>
                            <div class="card-body">
                                <form role="form" id="compeleteProfileForm" enctype="multipart/form-data">
                                    <!-- Form Group (username)-->
                                    {{-- <div class="mb-3">
                                        <label class="small mb-1" for="inputUsername">Username (how your name will appear to other users on the site)</label>
                                        <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" value="username">
                                    </div> --}}
                                    <!-- Form Row-->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (first name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputFirstName">First name</label> 
                                            <input class="form-control" id="inputFirstName" name="firstname" type="text" placeholder="Enter your first name" value="{{Auth::user()->name}}" required>
                                            <input class="form-control" id="inputFirstName" name="user_id" type="text" placeholder="Enter your first name" value="{{Auth::user()->id}}" hidden>
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputLastName">Last name</label>
                                            <input class="form-control" id="inputLastName" name="lastname" type="text" placeholder="Enter your last name" value="" required>
                                        </div>
                                    </div>
                                    <!-- Form Row        -->
                                    <div class="row gx-3 mb-3">
                                        <!-- Form Group (department)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputDepartment">Select Department</label>
                                            <select class="form-control form-control-lg" id="department" name="department">
                                                <option value="BASD">BASD</option>
                                                <option value="CAAD">CAAD</option>
                                                <option value="EAAD">EAAD</option>
                                                <option value="MAAD">MAAD</option>
                                                <option value="STAFF">STAFF/ADMIN</option>
                                              </select>
                                        </div>
                                        <!-- Form Group (organization name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputOrgName">Organization name</label>
                                            <input class="form-control" id="inputOrgName" name="organization" type="text" placeholder="Enter your organization name" value="" required>
                                        </div>
                                    </div>
                                    <!-- Form Group (email address)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputEmailAddress">TUP ID</label>
                                        <input class="form-control" id="inputEmailAddress" name="tupID" type="text" placeholder="Enter your TUP ID (ex. TUPT-XX-XXXX)" value="" required>
                                    </div>
                                    <!-- Form Row-->
                                    {{-- <div class="row gx-3 mb-3">
                                        <!-- Form Group (phone number)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputPhone">Phone number</label>
                                            <input class="form-control" id="inputPhone" type="tel" placeholder="Enter your phone number" value="">
                                        </div>
                                        <!-- Form Group (birthday)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputBirthday">Birthday</label>
                                            <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder="Enter your birthday" value="">
                                        </div>
                                    </div> --}}
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="button" id="completeProfileSubmit">Save changes</button>
                                </form>
                            </div>
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
