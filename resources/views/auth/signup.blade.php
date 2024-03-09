<x-guest-layout>

    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-absolute w-40 top-0 start-0 h-100 d-md-block d-none">
                                <div class="oblique-image position-absolute d-flex fixed-top ms-auto h-100 z-index-0 bg-cover me-n8"
                                    style="background-image:url('../assets/img/image-sign-up.jpg')">
                                    <div class="my-auto text-start max-width-350 ms-7">
                                        <h1 class="mt-3 text-white font-weight-bolder">Empowering School Events,<br> Effortlessly Managed.</h1>
                                        <p class="text-white text-lg mt-4 mb-4">"Streamlining School Events for Success."</p>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-group d-flex">
                                                <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                    data-bs-toggle="tooltip" data-original-title="Jessica Rowland">
                                                    <img alt="Image placeholder" src="../assets/img/team-3.jpg"
                                                        class="">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                    data-bs-toggle="tooltip" data-original-title="Audrey Love">
                                                    <img alt="Image placeholder" src="../assets/img/team-4.jpg"
                                                        class="rounded-circle">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                    data-bs-toggle="tooltip" data-original-title="Michael Lewis">
                                                    <img alt="Image placeholder" src="../assets/img/marie.jpg"
                                                        class="rounded-circle">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-sm rounded-circle"
                                                    data-bs-toggle="tooltip" data-original-title="Audrey Love">
                                                    <img alt="Image placeholder" src="../assets/img/team-1.jpg"
                                                        class="rounded-circle">
                                                </a>
                                            </div>
                                            <p class="font-weight-bold text-white text-sm mb-0 ms-2">Join 2.5M+ users
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-start position-absolute fixed-bottom ms-7">
                                        <h6 class="text-white text-sm mb-5">Copyright © 2022 Corporate UI Design System
                                            by Creative Tim.</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-black text-dark display-6">Sign up</h3>
                                    <p class="mb-0">Nice to meet you! Please enter your details.</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="exampleFormControlSelect1">Please select type of user</label>
                                            <select name="roleSelect" class="form-control" id="roleSelect">
                                              <option id="student">Student</option>
                                              <option id="professor">Professor</option>
                                              <option id="admin">Admin/Staff</option>
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>First Name</label>
                                                <div class="mb-3">
                                                    <input type="text" id="firstname" name="firstname" class="form-control"
                                                        placeholder="Enter your first name" value="{{old("firstname")}}" aria-label="Name"
                                                        aria-describedby="name-addon">
                                                    @error('firstname')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Last Name</label>
                                                <div class="mb-3">
                                                    <input type="text" id="lastname" name="lastname" class="form-control"
                                                        placeholder="Enter your last name" value="{{old("lastname")}}" aria-label="Name"
                                                        aria-describedby="name-addon">
                                                    @error('lastname')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="form-group" id="tupIDdiv">
                                          <label>TUP ID</label>
                                            <div class="input-group">
                                              <span class="input-group-text text-body">
                                                TUPT-
                                              </span>
                                              <input type="tupId" id="tupId" name="tupId" class="form-control" placeholder="XX-XXXX">
                                              @error('tupId')
                                                  <span class="text-danger text-sm">{{ $message }}</span>
                                              @enderror
                                            </div>
                                          </div>

                                        <div class="row" id="rowAndCourse">
                                            <div class="col-md-6" id="courseform">
                                                <label>Course</label>
                                                <div class="mb-3">
                                                    <input type="course" id="course" name="course" class="form-control"
                                                        placeholder="ex. BSIT" value="{{old("course")}}" aria-label="course"
                                                        aria-describedby="course-addon">
                                                    @error('course')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6" id="yearform">
                                                <label for="exampleFormControlSelect1">Year Level</label>
                                                    <select name="yearLevel" class="form-control" id="yearLevel">
                                                    <option value="1">1st Year</option>
                                                    <option value="2">2nd Year</option>
                                                    <option value="3">3rd Year</option>
                                                    <option value="4">4th Year</option>
                                                    </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6" id="sectionform">
                                            <label for="exampleFormControlSelect1">Section</label>
                                            <input type="text" id="section" name="section" class="form-control"
                                            placeholder="Enter section" value="{{old("section")}}" aria-label="section"
                                            aria-describedby="section-addon">
                                            @error('section')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        
                                        <div class="row" id="divOrg">
                                            <div class="col-md-6">
                                                <label>Department</label>
                                                    <div class="mb-3">
                                                        <input type="dept" id="dept" name="dept" class="form-control"
                                                            placeholder="ex. Electrical and Allied" value="{{old("dept")}}" aria-label="dept"
                                                            aria-describedby="dept-addon">
                                                        @error('dept')
                                                            <span class="text-danger text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                            </div>

                                            <div class="col-md-6" >
                                                <label>Organization</label>
                                                    <div class="mb-3">
                                                        <input type="organization" id="organization" name="organization" class="form-control"
                                                            placeholder="ex. MTICS" value="{{old("organization")}}" aria-label="organization"
                                                            aria-describedby="organization-addon">
                                                        @error('organization')
                                                            <span class="text-danger text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                            </div>
                                        </div>

                                        <label>Email Address</label>
                                        <div class="mb-3">
                                            <input type="email" id="email" name="email" class="form-control"
                                                placeholder="Enter your email address" value="{{old("email")}}" aria-label="Email"
                                                aria-describedby="email-addon">
                                            @error('email')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input type="password" id="password" name="password" class="form-control"
                                                placeholder="Create a password" aria-label="Password"
                                                aria-describedby="password-addon">
                                            @error('password')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleFormControlSelect1">Please select role</label>
                                            <select class="form-control" name="orgRole" id="orgRole">
                                              <option>Member</option>
                                              <option>Executive</option>                    
                                            </select>
                                        </div>

                                        <div class="form-check form-check-info text-left mb-0">
                                            <input class="form-check-input" type="checkbox" name="terms"
                                                id="terms" required>
                                            <label class="font-weight-normal text-dark mb-0" for="terms">
                                                I agree the <a href="javascript:;"
                                                    class="text-dark font-weight-bold">Terms and Conditions</a>.
                                            </label>
                                            @error('terms')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-dark w-100 mt-4 mb-3">Sign up</button>
                                            <button type="button" class="btn btn-white btn-icon w-100 mb-3">
                                                <span class="btn-inner--icon me-1">
                                                    <img class="w-5" src="../assets/img/logos/google-logo.svg"
                                                        alt="google-logo" />
                                                </span>
                                                <span class="btn-inner--text">Sign up with Google</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-xs mx-auto">
                                        Already have an account?
                                        <a href="{{ route('sign-in') }}" class="text-dark font-weight-bold">Sign
                                            in</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}
    <script type="text/javascript" src="/js/myscript.js"></script>

</x-guest-layout>
