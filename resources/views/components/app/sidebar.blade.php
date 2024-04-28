<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center m-0"
            href=" https://demos.creative-tim.com/corporate-ui-dashboard/pages/dashboard.html " target="_blank">
            <span class="font-weight-bold" style="font-size: 28px; color:#bfa7f3; ">CALENDASH</span>
        </a>
    </div>
    {{-- class="collapse navbar-collapse px-4 w-auto " id="sidenav-collapse-main" --}}
    <div class="collapse navbar-collapse px-4  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link  {{ is_current_route('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-gauge"
                        style="color: {{ is_current_route('dashboard') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                    <span class="nav-link-text ms-1">DASHBOARD</span>
                </a>
            </li>

            {{-- ADMIN --}}
            @if (auth()->user()->hasRole('admin'))
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('adminVenues') ? 'active' : '' }}"
                        href="{{ route('adminVenues') }}">
                        <i class="fa-solid fa-map-location-dot"
                            style="color: {{ is_current_route('adminVenues') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">VENUES</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('adminRooms') ? 'active' : '' }}"
                        href="{{ route('adminRooms') }}">
                        <i class="fa-solid fa-person-shelter"
                            style="color: {{ is_current_route('adminRooms') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">ROOMS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('AdminAllOfficials') ? 'active' : '' }}"
                        href="{{ route('AdminAllOfficials') }}">
                        <i class="fa-solid fa-users-gear"
                            style="color: {{ is_current_route('AdminAllOfficials') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">OFFICIALS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('pendingUsers') ? 'active' : '' }}"
                        href="{{ route('pendingUsers') }}">
                        {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                        <i class="fa-solid fa-users"
                            style="color: {{ is_current_route('pendingUsers') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">USERS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('AdminIndexSectionHead') ? 'active' : '' }}"
                        href="{{ route('AdminIndexSectionHead') }}">
                        {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                        <i class="fa-solid fa-users"
                            style="color: {{ is_current_route('AdminIndexSectionHead') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">SECTION HEADS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('AdminIndexDepartmentHead') ? 'active' : '' }}"
                        href="{{ route('AdminIndexDepartmentHead') }}">
                        {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                        <i class="fa-solid fa-users"
                            style="color: {{ is_current_route('AdminIndexDepartmentHead') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">DEPARTMENT HEADS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('AdminIndexOrgAdviser') ? 'active' : '' }}"
                        href="{{ route('AdminIndexOrgAdviser') }}">
                        {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                        <i class="fa-solid fa-users"
                            style="color: {{ is_current_route('AdminIndexOrgAdviser') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">ORG ADVISERS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                        href="{{ route('calendar') }}">
                        {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                        <i class="fa-regular fa-calendar-days"
                            style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">EVENT CALENDAR</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('AdminAllEvents') ? 'active' : '' }}"
                        href="{{ route('AdminAllEvents') }}">
                        {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                        <i class="fa-regular fa-calendar-check"
                            style="color: {{ is_current_route('AdminAllEvents') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">EVENTS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('countEventPerOrgReport') ? 'active' : '' }}"
                        href="{{ route('countEventPerOrgReport') }}">
                        {{-- <i class="fa-solid fa-calendar-days"></i> --}}
                        <i class="fa fa-line-chart"
                            style="color: {{ is_current_route('countEventPerOrgReport') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">REPORTS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('accomplishmentreports') ? 'active' : '' }}"
                        href="{{ route('accomplishmentreports') }}">
                        <i class="fa fa-bar-chart"
                            style="color: {{ is_current_route('accomplishmentreports') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">ACCMPLSHMNT REPORTS</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole(['student', 'professor', 'staff']))
                {{-- TABLESSSS --}}
                {{-- <li class="nav-item">
                <a class="nav-link  {{ is_current_route('tables') ? 'active' : '' }}" href="{{ route('tables') }}">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <svg width="30px" height="30px" viewBox="0 0 48 48" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>table</title>
                            <g id="table" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="view-grid" transform="translate(12.000000, 12.000000)" fill="#FFFFFF"
                                    fill-rule="nonzero">
                                    <path class="color-foreground"
                                        d="M3.42857143,0 C1.53502286,0 0,1.53502286 0,3.42857143 L0,6.85714286 C0,8.75069143 1.53502286,10.2857143 3.42857143,10.2857143 L6.85714286,10.2857143 C8.75069143,10.2857143 10.2857143,8.75069143 10.2857143,6.85714286 L10.2857143,3.42857143 C10.2857143,1.53502286 8.75069143,0 6.85714286,0 L3.42857143,0 Z"
                                        id="Path"></path>
                                    <path class="color-background"
                                        d="M3.42857143,13.7142857 C1.53502286,13.7142857 0,15.2492571 0,17.1428571 L0,20.5714286 C0,22.4650286 1.53502286,24 3.42857143,24 L6.85714286,24 C8.75069143,24 10.2857143,22.4650286 10.2857143,20.5714286 L10.2857143,17.1428571 C10.2857143,15.2492571 8.75069143,13.7142857 6.85714286,13.7142857 L3.42857143,13.7142857 Z"
                                        id="Path"></path>
                                    <path class="color-background"
                                        d="M13.7142857,3.42857143 C13.7142857,1.53502286 15.2492571,0 17.1428571,0 L20.5714286,0 C22.4650286,0 24,1.53502286 24,3.42857143 L24,6.85714286 C24,8.75069143 22.4650286,10.2857143 20.5714286,10.2857143 L17.1428571,10.2857143 C15.2492571,10.2857143 13.7142857,8.75069143 13.7142857,6.85714286 L13.7142857,3.42857143 Z"
                                        id="Path"></path>
                                    <path class="color-foreground"
                                        d="M13.7142857,17.1428571 C13.7142857,15.2492571 15.2492571,13.7142857 17.1428571,13.7142857 L20.5714286,13.7142857 C22.4650286,13.7142857 24,15.2492571 24,17.1428571 L24,20.5714286 C24,22.4650286 22.4650286,24 20.5714286,24 L17.1428571,24 C15.2492571,24 13.7142857,22.4650286 13.7142857,20.5714286 L13.7142857,17.1428571 Z"
                                        id="Path"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li> --}}

                @if (auth()->user()->email_verified_at === null)
                    <!-- EVENT CALENDAR -->
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                            href="{{ route('calendar') }}">
                            <i class="fa-solid fa-calendar-days"
                                style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                            <span class="nav-link-text ms-1">Event Calendar</span>
                        </a>
                    </li>
                @else
                    {{-- MY PROFILE --}}
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('usersProfile') || is_current_route('profiles') ? 'active' : '' }}"
                            href="{{ route('profiles') }}">
                            <i class="fa-solid fa-id-card-clip"
                                style="color: {{ is_current_route('usersProfile') || is_current_route('profiles') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">My Profile</span>
                        </a>
                    </li>

                    {{-- CREATE EVENTS --}}
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('createEvent') ? 'active' : '' }}"
                            href="{{ route('createEvent') }}">
                            <i class="fa-solid fa-calendar-plus"
                                style="color: {{ is_current_route('createEvent') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">Create an Event</span>
                        </a>
                    </li>


                    <!-- EVENT CALENDAR -->
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                            href="{{ route('calendar') }}">
                            <i class="fa-solid fa-calendar-days"
                                style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                            <span class="nav-link-text ms-1">Event Calendar</span>
                        </a>
                    </li>

                    <!-- MY EVENTS -->
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('myEvents') ? 'active' : '' }}"
                            href="{{ route('myEvents') }}">
                            <i class="fa-solid fa-circle-check"
                                style="color: {{ is_current_route('myEvents') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">My Status Events</span>
                        </a>
                    </li>

                    <!-- Venues -->
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('venues.indexUser') ? 'active' : '' }}"
                            href="{{ route('venues.indexUser') }}">
                            <i class="fa-solid fa-map-location-dot"
                                style="color: {{ is_current_route('venues.indexUser') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">Venues</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('attendance') ? 'active' : '' }}"
                            href="{{ route('attendance') }}">
                            <i class="fa-solid fa-clock"
                                style="color: {{ is_current_route('attendance') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">Attendance</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('meApproved') ? 'active' : '' }}"
                            href="{{ route('meApproved') }}">
                            <i class="fa-solid fa-square-check"
                                style="color: {{ is_current_route('meApproved') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">My Approved Requests</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('meRejected') ? 'active' : '' }}"
                            href="{{ route('meRejected') }}">
                            <i class="fa-solid fa-square-xmark"
                                style="color: {{ is_current_route('meRejected') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">My Declined Request</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('accomplishment') ? 'active' : '' }}"
                            href="{{ route('accomplishment') }}">
                            <i class="fa-solid fa-clock"
                                style="color: {{ is_current_route('accomplishment') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">Accomplishment</span>
                        </a>
                    </li>
                @endif

            @endif


            {{-- FOR OFFICIALS --}}
            @if (auth()->user()->hasRole(['org_adviser', 'section_head', 'department_head', 'osa', 'adaa', 'atty', 'campus_director']))

                <!-- EVENT CALENDAR -->
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                        href="{{ route('calendar') }}">
                        <i class="fa-solid fa-calendar-days"
                            style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                        <span class="nav-link-text ms-1">Event Calendar</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('adaaRequest') ? 'active' : '' }}"
                        href="{{ route('adaaRequest') }}">
                        <i class="fa-solid fa-bell"
                            style="color: {{ is_current_route('adaaRequest') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">Requests</span>
                    </a>
                </li>

                @if (auth()->user()->hasRole(['section_head']) &&
                        auth()->user()->official &&
                        auth()->user()->official->user_id === 2)
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('pendingRequestRoom') ? 'active' : '' }}"
                            href="{{ route('pendingRequestRoom') }}">
                            <i class="fa-solid fa-person-shelter"
                                style="color: {{ is_current_route('pendingRequestRoom') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                            <span class="nav-link-text ms-1">Requests for Rooms</span>
                        </a>
                    </li>

                    <li class="nav-item mt-2">
                        <div class="d-flex align-items-center nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="ms-2"
                                viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="font-weight-normal text-md ms-2">Rooms</span>
                        </div>
                    </li>
                    <li class="nav-item border-start my-0 pt-2">
                        <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('approvedRoomsView') ? 'active' : '' }}"
                            href="{{ route('approvedRoomsView') }}">
                            <span class="nav-link-text ms-1">Approved Request</span>
                        </a>
                    </li>
                    <li class="nav-item border-start my-0 pt-2">
                        <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('rejectedRoomsView') ? 'active' : '' }}"
                            href="{{ route('rejectedRoomsView') }}">
                            <span class="nav-link-text ms-1">Declined Request</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('myApproved') ? 'active' : '' }}"
                        href="{{ route('myApproved') }}">
                        <i class="fa-regular fa-thumbs-up"
                            style="color: {{ is_current_route('myApproved') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">My Approved Requests</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('myRejected') ? 'active' : '' }}"
                        href="{{ route('myRejected') }}">
                        <i class="fa-solid fa-square-xmark"
                            style="color: {{ is_current_route('myRejected') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">My Declined Requests</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('changePasscodeView') ? 'active' : '' }}"
                        href="{{ route('changePasscodeView') }}">
                        <i class="fa-solid fa-unlock"
                            style="color: {{ is_current_route('changePasscodeView') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">Change Passcode</span>
                    </a>
                </li>

            @endif

            {{-- BUSINESS MANAGER --}}
            @if (auth()->user()->hasRole(['business_manager']))
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('outsideRequest') ? 'active' : '' }}"
                        href="{{ route('outsideRequest') }}">
                        <i class="fa-solid fa-bell"
                            style="color: {{ is_current_route('outsideRequest') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">Requests for Event Rent</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('waitingForReceipt') ? 'active' : '' }}"
                        href="{{ route('waitingForReceipt') }}">
                        <i class="fa-solid fa-bell"
                            style="color: {{ is_current_route('waitingForReceipt') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">Pending Receipt</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('outsideUser') ? 'active' : '' }}"
                        href="{{ route('outsideUser') }}">
                        <i class="fa-solid fa-users"
                            style="color: {{ is_current_route('outsideUser') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">Outside Users</span>
                    </a>
                </li>

                <!-- EVENT CALENDAR -->
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                        href="{{ route('calendar') }}">
                        <i class="fa-solid fa-calendar-days"
                            style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                        <span class="nav-link-text ms-1">Event Calendar</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('approvedEventsBusinessManager') ? 'active' : '' }}"
                        href="{{ route('approvedEventsBusinessManager') }}">
                        <i class="fa-regular fa-thumbs-up"
                            style="color: {{ is_current_route('approvedEventsBusinessManager') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">My Approved Requests</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('rejectedEventsBusinessManager') ? 'active' : '' }}"
                        href="{{ route('rejectedEventsBusinessManager') }}">
                        <i class="fa-solid fa-square-xmark"
                            style="color: {{ is_current_route('rejectedEventsBusinessManager') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">My Declined Requests</span>
                    </a>
                </li>
            @endif

            {{-- OUTSIDER --}}
            @if (auth()->user()->hasRole(['outsider']))
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('outsideCreateRequest') || is_current_route('createEvent') ? 'active' : '' }}"
                        href="{{ route('outsideCreateRequest') }}">
                        <i class="fa-solid fa-calendar-plus"
                            style="color: {{ is_current_route('outsideCreateRequest') || is_current_route('createEvent') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        <span class="nav-link-text ms-1">Venue Request</span>
                    </a>
                </li>
                <!-- EVENT CALENDAR -->
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                        href="{{ route('calendar') }}">
                        <i class="fa-solid fa-calendar-days"
                            style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                        <span class="nav-link-text ms-1">Event Calendar</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('statusOutsiderEvents') ? 'active' : '' }}"
                        href="{{ route('statusOutsiderEvents') }}">
                        <i class="fa-solid fa-circle-check"
                            style="color: {{ is_current_route('statusOutsiderEvents') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                        <span class="nav-link-text ms-1">Status of your request</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('approvedEventsOutsider') ? 'active' : '' }}"
                        href="{{ route('approvedEventsOutsider') }}">
                        <i class="fa-regular fa-thumbs-up"
                            style="color: {{ is_current_route('approvedEventsOutsider') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">My Approved Requests</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('rejectedEventsOutsider') ? 'active' : '' }}"
                        href="{{ route('rejectedEventsOutsider') }}">
                        <i class="fa-solid fa-square-xmark"
                            style="color: {{ is_current_route('rejectedEventsOutsider') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">My Declined Requests</span>
                    </a>
                </li>
            @endif

            {{-- <li class="nav-item mt-2">
                <div class="d-flex align-items-center nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="ms-2" viewBox="0 0 24 24"
                        fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-weight-normal text-md ms-2">REPORTS</span>
                </div>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users.profile') ? 'active' : '' }}"
                    href="{{ route('users.profile') }}">
                    <span class="nav-link-text ms-1">Event Reports</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users-management') ? 'active' : '' }}"
                    href="{{ route('users-management') }}">
                    <span class="nav-link-text ms-1">Venue Reports</span>
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link {{ is_current_route('wallet') ? 'active' : '' }} " href="{{ route('wallet') }}">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <svg width="30px" height="30px" viewBox="0 0 48 48" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>wallet</title>
                            <g id="wallet" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="credit-card" transform="translate(12.000000, 15.000000)" fill="#FFFFFF">
                                    <path class="color-background"
                                        d="M3,0 C1.343145,0 0,1.343145 0,3 L0,4.5 L24,4.5 L24,3 C24,1.343145 22.6569,0 21,0 L3,0 Z"
                                        id="Path" fill-rule="nonzero"></path>
                                    <path class="color-foreground"
                                        d="M24,7.5 L0,7.5 L0,15 C0,16.6569 1.343145,18 3,18 L21,18 C22.6569,18 24,16.6569 24,15 L24,7.5 Z M3,13.5 C3,12.67155 3.67158,12 4.5,12 L6,12 C6.82842,12 7.5,12.67155 7.5,13.5 C7.5,14.32845 6.82842,15 6,15 L4.5,15 C3.67158,15 3,14.32845 3,13.5 Z M10.5,12 C9.67158,12 9,12.67155 9,13.5 C9,14.32845 9.67158,15 10.5,15 L12,15 C12.82845,15 13.5,14.32845 13.5,13.5 C13.5,12.67155 12.82845,12 12,12 L10.5,12 Z"
                                        id="Shape"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">Wallet</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  {{ is_current_route('RTL') ? 'active' : '' }}" href="{{ route('RTL') }}">
                    <div
                        class="icon icon-shape icon-sm px-0 text-center d-flex align-items-center justify-content-center">
                        <svg width="30px" height="30px" viewBox="0 0 48 48" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>rtl</title>
                            <g id="rtl" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="menu-alt-3" transform="translate(12.000000, 14.000000)" fill="#FFFFFF">
                                    <path class="color-foreground"
                                        d="M0,1.71428571 C0,0.76752 0.76752,0 1.71428571,0 L22.2857143,0 C23.2325143,0 24,0.76752 24,1.71428571 C24,2.66105143 23.2325143,3.42857143 22.2857143,3.42857143 L1.71428571,3.42857143 C0.76752,3.42857143 0,2.66105143 0,1.71428571 Z"
                                        id="Path"></path>
                                    <path class="color-background"
                                        d="M0,10.2857143 C0,9.33894857 0.76752,8.57142857 1.71428571,8.57142857 L22.2857143,8.57142857 C23.2325143,8.57142857 24,9.33894857 24,10.2857143 C24,11.2325143 23.2325143,12 22.2857143,12 L1.71428571,12 C0.76752,12 0,11.2325143 0,10.2857143 Z"
                                        id="Path"></path>
                                    <path class="color-background"
                                        d="M10.2857143,18.8571429 C10.2857143,17.9103429 11.0532343,17.1428571 12,17.1428571 L22.2857143,17.1428571 C23.2325143,17.1428571 24,17.9103429 24,18.8571429 C24,19.8039429 23.2325143,20.5714286 22.2857143,20.5714286 L12,20.5714286 C11.0532343,20.5714286 10.2857143,19.8039429 10.2857143,18.8571429 Z"
                                        id="Path"></path>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="nav-link-text ms-1">RTL</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <div class="d-flex align-items-center nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="ms-2" viewBox="0 0 24 24"
                        fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-weight-normal text-md ms-2">Laravel Examples</span>
                </div>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users.profile') ? 'active' : '' }}"
                    href="{{ route('users.profile') }}">
                    <span class="nav-link-text ms-1">User Profile</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('users-management') ? 'active' : '' }}"
                    href="{{ route('users-management') }}">
                    <span class="nav-link-text ms-1">User Management</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <div class="d-flex align-items-center nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="ms-2" viewBox="0 0 24 24"
                        fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd"
                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-weight-normal text-md ms-2">Account Pages</span>
                </div>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('profile') ? 'active' : '' }}"
                    href="{{ route('profile') }}">
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('signin') ? 'active' : '' }}"
                    href="{{ route('signin') }}">
                    <span class="nav-link-text ms-1">Sign In</span>
                </a>
            </li>
            <li class="nav-item border-start my-0 pt-2">
                <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('signup') ? 'active' : '' }}"
                    href="{{ route('signup') }}">
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li> --}}
        </ul>
    </div>
    {{-- <div class="sidenav-footer mx-4 ">

        <div class="card border-radius-md" id="sidenavCard">
            <div class="card-body  text-start  p-3 w-100">
                <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="text-primary"
                        viewBox="0 0 24 24" fill="currentColor" id="sidenavCardIcon">
                        <path
                            d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625z" />
                        <path
                            d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z" />
                    </svg>
                </div>
                <div class="docs-info">
                    <h6 class="font-weight-bold up mb-2">Need help?</h6>
                    <p class="text-sm font-weight-normal">Please check our docs.</p>
                    <a href="https://www.creative-tim.com/learning-lab/bootstrap/installation-guide/corporate-ui-dashboard"
                        target="_blank" class="font-weight-bold text-sm mb-0 icon-move-right mt-auto w-100 mb-0">
                        Documentation
                        <i class="fas fa-arrow-right-long text-sm ms-1" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}
</aside>
