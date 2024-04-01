<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
            <div class="pt-7 pb-6 bg-cover"
                style="background-image: url('../assets/img/header-orange-purple.jpg'); background-position: bottom;">
            </div>
        <div class="container-fluid py-4 px-5">
            <div class="container">
                <div class="card card-body py-2 bg-transparent shadow-none">
                    <div class="row">
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h3 class="mb-0 font-weight-bold">
                                    {{ $user->name }}
                                </h3>
                                <p class="mb-0">
                                    {{ $user->email }}
                                </p>
                            </div>
                        </div>
                        {{-- <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3 text-sm-end">
                            <a href="javascript:;" class="btn btn-sm btn-white">Cancel</a>
                            <a href="javascript:;" class="btn btn-sm btn-dark">Save</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="container my-3 py-3">
                <div class="card border shadow-xs h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 col-9">
                                <h6 class="mb-0 font-weight-semibold text-lg">Profile information</h6>
                                <p class="text-sm mb-1">Edit the information about you.</p>
                            </div>
                            <div class="col-md-4 col-3 text-end">
                                <button type="button" class="btn btn-white btn-icon px-2 py-2" onclick="window.location.href='{{ url('/laravel-examples/user-profile') }}'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        {{-- <p class="text-sm mb-4">
                            Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two equally
                            difficult paths, choose the one more painful in the short term (pain avoidance is
                            creating an illusion of equality).
                        </p> --}}
                        <ul class="list-group">
                            <li
                                class="list-group-item border-0 ps-0 text-dark font-weight-semibold pt-0 pb-1 text-sm">
                                <span class="text-secondary">Name:</span> &nbsp; {{ $user->name }} 
                            </li>
                            <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                <span class="text-secondary">Email:</span> &nbsp; {{ $user->email }}
                            </li>
                                @if ($role === 'student')
                                    <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                        <span class="text-secondary">Department:</span> &nbsp; {{ $student->department }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                        <span class="text-secondary">Organization:</span> &nbsp; {{ $student->organization }}
                                    </li>
                                    <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                        <span class="text-secondary">Course:</span> &nbsp; {{ $student->section }}
                                    </li>
                                @elseif ($role === 'professor')
                                    <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                        <span class="text-secondary">Department:</span> &nbsp; Faculty
                                    </li>
                                @elseif ($role === 'staff')
                                    <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                        <span class="text-secondary">Department:</span> &nbsp; {{ $student->department }}
                                    </li>
                                @endif
                            <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
                                <span class="text-secondary">TUP ID:</span> &nbsp; {{ $student->tupID }}
                            </li>
                        </ul>
                    </div>
                </div>
                
                <footer class="footer pt-3  ">
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-lg-between">
                            <div class="col-lg-6 mb-lg-0 mb-4">
                                <div class="copyright text-center text-xs text-muted text-lg-start">
                                    Copyright
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>
                                    Corporate UI by
                                    <a href="https://www.creative-tim.com" class="text-secondary"
                                        target="_blank">Creative Tim</a>.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com" class="nav-link text-xs text-muted"
                                            target="_blank">Creative Tim</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/presentation"
                                            class="nav-link text-xs text-muted" target="_blank">About Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/blog" class="nav-link text-xs text-muted"
                                            target="_blank">Blog</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/license"
                                            class="nav-link text-xs pe-0 text-muted" target="_blank">License</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <div class="pt-7 pb-6 bg-cover"
                style="background-image: url('../assets/img/header-orange-purple.jpg'); background-position: bottom;">
        </div>
    </main><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/alert.js"></script>
</x-app-layout>
