<nav class="navbar navbar-main navbar-expand-lg mx-5 px-0 shadow-none rounded" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-2">
        <div class="sidenav-header text-center" style="margin-top: 5px;">
            <img src="../assets/img/Tuplogo.png" class="img-fluid" alt="" style="width: 100px;">
        </div><br><br><br>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                <ul class="navbar-nav  justify-content-end">
                    <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown pe-2 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor" class="cursor-pointer">
                                <path fill-rule="evenodd"
                                    d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span id="badge"
                                class="position-absolute top-0 start-100 translate-middle badge badge-primary rounded-pill"></span>
                        </a>
                        <ul id="notificationList" class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton">

                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto">
                                            <img src="../assets/img/team-2.jpg"
                                                class="avatar avatar-sm border-radius-sm  me-3 ">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span class="font-weight-bold"></span>
                                            </h6>
                                            <p class="text-xs text-secondary mb-0 d-flex align-items-center ">
                                                <i class="fa fa-clock opacity-6 me-1"></i>

                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>       
                        </ul>
                    </li>
                    <li class="nav-item ps-2 d-flex align-items-center">
                        <a class="nav-link text-body p-0">
                            <strong style="color: black">{{ Auth::user()->name }}</strong>
                            <input type="text" id="authUserID" value="{{ Auth::user()->id }}" hidden>
                        </a>
                    </li>
                    {{-- <li class="nav-item ps-2 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0">
                            <img src="../assets/img/team-2.jpg" class="avatar avatar-sm" alt="avatar" />
                        </a>
                    </li> --}}
                </ul>

                <div class="mb-0 font-weight-bold breadcrumb-text text-white" style="margin-left: 10px">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a href="login"
                            onclick="event.preventDefault();
                this.closest('form').submit();">
                            <button class="btn btn-sm  btn-primary  mb-0 me-1" type="submit">Log out</button>
                        </a>
                    </form>
                </div>

            </div>
        </div>
</nav>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {

        var existingNotifications = []; // Array to store existing notification IDs
        var id = $('#authUserID').val();
        // console.log(id);
        // alert(id)
        function fetchNotifications() {
            $.ajax({
                url: '/api/notif/request/' + id, // Update the URL to your endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#notificationList').empty(); // Clear existing notifications
                    console.log(response)
                    // if (response.user === 'student' || response.user === 'prof' || response.user === 'staff' )
                    // {   
                    //     console.log(response.msg.length)
                    //     if (response.msg.length === 0) {
                    //     $('#notificationList').append('<li class="text-center">No notifications</li>');
                    //     } else {
                    //         response.msg.forEach(function(notification) {
                    //             // console.log(notification);
                    //             var timeAgo = moment(notification.created_at).fromNow(); // Use moment.js to calculate time ago
                    //             var listItem = '<li class="mb-2">' +
                    //                 '<a class="dropdown-item border-radius-md" href="{{ url('/request') }}">' +
                    //                 '<div class="d-flex py-1">' +
                    //                 '<div class="my-auto">' +
                    //                 '<img src="../assets/img/team-2.jpg" class="avatar avatar-sm border-radius-sm me-3">' +
                    //                 '</div>' +
                    //                 '<div class="d-flex flex-column justify-content-center">' +
                    //                 '<h6 class="text-sm font-weight-normal mb-1">' +
                    //                 '<span class="font-weight-bold">New request</span> from ' + notification.name +
                    //                 '</h6>' +
                    //                 '<p class="text-xs text-secondary mb-0 d-flex align-items-center">' +
                    //                 '<i class="fa fa-clock opacity-6 me-1"></i>' + timeAgo +
                    //                 '</p>' +
                    //                 '</div>' +
                    //                 '</div>' +
                    //                 '</a>' +
                    //                 '</li>';

                    //             // Check if the notification ID is in the existingNotifications array
                    //             if (!existingNotifications.includes(notification.id)) {
                    //                 $('#notificationList').append(listItem); // Append new notification to the list
                    //                 existingNotifications.push(notification.id); // Add the ID to the existingNotifications array
                    //             }
                    //         });
                    //     }
                    // }
                    console.log(response.length);

                    if (response.length === 0) {
                        $('#notificationList').append(
                            '<li class="text-center">No notifications</li>');
                    } else {
                        response.forEach(function(notification) {
                            console.log(notification);
                            var timeAgo = moment(notification.created_at)
                                .fromNow(); // Use moment.js to calculate time ago
                            var listItem = '<li class="mb-2">' +
                                '<a class="dropdown-item border-radius-md" href="{{ url('/request') }}">' +
                                '<div class="d-flex py-1">' +
                                '<div class="my-auto">' +
                                '<img src="../assets/img/team-2.jpg" class="avatar avatar-sm border-radius-sm me-3">' +
                                '</div>' +
                                '<div class="d-flex flex-column justify-content-center">' +
                                '<h6 class="text-sm font-weight-normal mb-1">' +
                                '<span class="font-weight-bold">New request</span> from ' +
                                notification.name +
                                '</h6>' +
                                '<p class="text-xs text-secondary mb-0 d-flex align-items-center">' +
                                '<i class="fa fa-clock opacity-6 me-1"></i>' + timeAgo +
                                '</p>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '</li>';

                            // Check if the notification ID is in the existingNotifications array
                            if (!existingNotifications.includes(notification.id)) {
                                $('#notificationList').append(
                                    listItem); // Append new notification to the list
                                existingNotifications.push(notification
                                    .id); // Add the ID to the existingNotifications array
                            }
                        });
                    }

                    addBadge(); // Update the badge count
                }
            });
        }

        // Fetch notifications initially
        fetchNotifications();

        // Fetch notifications every minute
        setInterval(fetchNotifications, 60000); // Update every minute (60000 milliseconds)

        function addBadge() {
            var count = $('#notificationList li').length;
            $('#badge').text(count).show();
            // if (count === 0) {
            //     $('#badge').hide(); // Hide the badge if count is zero
            // } else {
            //     $('#badge').text(count).show(); // Update and show the badge
            // }
        }

        function removeBadge() {
            $('#badge').hide();
        }

        $('#notificationList').on('click', 'li', function() {
            updateBadge();
            $.ajax({
                url: '/api/notif/read-request/' + id, // Update the URL to your endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    console.log(response);

                }
            });
        });

        $('#dropdownMenuButton').on('click', function() {
            // console.log('notif clicked')
            $.ajax({
                url: '/api/notif/read-request/' + id, // Update the URL to your endpoint
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {

                    console.log(response);
                    removeBadge();
                }
            });

        });
    });
</script>
<!-- End Navbar -->
