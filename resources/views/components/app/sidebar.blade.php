<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start " id="sidenav-main">
    <div class="sidenav-header text-center" style="margin-top: -50px;">
        <img src="../assets/img/calendash.png" class="img-fluid" alt="" style="width: 230px;"> 
    </div><br><br><br>

        {{-- class="collapse navbar-collapse px-4 w-auto " id="sidenav-collapse-main" --}}
    <div class="collapse navbar-collapse px-4  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link  {{ is_current_route('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-home"
                        style="color: {{ is_current_route('dashboard') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                    <span class="nav-link-text ms-1">HOME</span>
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
                        <span class="nav-link-text ms-1">ALL ACCOMPLISHMENT</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->hasRole(['student', 'professor', 'staff']))
                @if (auth()->user()->email_verified_at === null)
                    <!-- EVENT CALENDAR -->
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                            href="{{ route('calendar') }}">
                            <i class="fa-solid fa-calendar-days"
                                style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                            <span class="nav-link-text ms-1">EVENT CALENDAR</span>
                        </a>
                    </li>
                @else
                    {{-- MY PROFILE --}}
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('usersProfile') || is_current_route('profiles') ? 'active' : '' }}"
                            href="{{ route('profiles') }}">
                            <i class="fa-solid fa-id-card-clip"
                                style="color: {{ is_current_route('usersProfile') || is_current_route('profiles') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">MY PROFILE</span>
                        </a>
                    </li>

                    {{-- CREATE EVENTS --}}
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('createEvent') ? 'active' : '' }}"
                            href="{{ route('createEvent') }}">
                            <i class="fa-solid fa-calendar-plus"
                                style="color: {{ is_current_route('createEvent') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">CREATE AN EVENT</span>
                        </a>
                    </li>


                    <!-- EVENT CALENDAR -->
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                            href="{{ route('calendar') }}">
                            <i class="fa-solid fa-calendar-days"
                                style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                            <span class="nav-link-text ms-1">EVENT CALENDAR</span>
                        </a>
                    </li>

                    <!-- MY EVENTS -->
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('myEvents') ? 'active' : '' }}"
                            href="{{ route('myEvents') }}">
                            <i class="fa-solid fa-circle-check"
                                style="color: {{ is_current_route('myEvents') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">MY EVENT STATUS</span>
                        </a>
                    </li>

                    <!-- Venues -->
                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('venues.indexUser') ? 'active' : '' }}"
                            href="{{ route('venues.indexUser') }}">
                            <i class="fa-solid fa-map-location-dot"
                                style="color: {{ is_current_route('venues.indexUser') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">VENUES</span>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('attendance') ? 'active' : '' }}"
                            href="{{ route('attendance') }}">
                            <i class="fa-solid fa-clock"
                                style="color: {{ is_current_route('attendance') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">ATTENDANCE</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('meApproved') ? 'active' : '' }}"
                            href="{{ route('meApproved') }}">
                            <i class="fa-solid fa-square-check"
                                style="color: {{ is_current_route('meApproved') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">MY APPROVED REQUEST</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('meRejected') ? 'active' : '' }}"
                            href="{{ route('meRejected') }}">
                            <i class="fa-solid fa-square-xmark"
                                style="color: {{ is_current_route('meRejected') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">MY DECLINED REQUEST</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link  {{ is_current_route('accomplishment') ? 'active' : '' }}"
                            href="{{ route('accomplishment') }}">
                            <i class="fa-solid fa-clock"
                                style="color: {{ is_current_route('accomplishment') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                            <span class="nav-link-text ms-1">ACCOMPLISHMENT</span>
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
                        <span class="nav-link-text ms-1">EVENT CALENDAR</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('adaaRequest') ? 'active' : '' }}"
                        href="{{ route('adaaRequest') }}">
                        <i class="fa-solid fa-bell"
                            style="color: {{ is_current_route('adaaRequest') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">REQUESTS</span>
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
                            <span class="nav-link-text ms-1">REQUEST FOR ROOMS</span>
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
                            <span class="font-weight-normal text-md ms-2">ROOMS</span>
                        </div>
                    </li>
                    <li class="nav-item border-start my-0 pt-2">
                        <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('approvedRoomsView') ? 'active' : '' }}"
                            href="{{ route('approvedRoomsView') }}">
                            <span class="nav-link-text ms-1">APPROVED REQUEST</span>
                        </a>
                    </li>
                    <li class="nav-item border-start my-0 pt-2">
                        <a class="nav-link position-relative ms-0 ps-2 py-2 {{ is_current_route('rejectedRoomsView') ? 'active' : '' }}"
                            href="{{ route('rejectedRoomsView') }}">
                            <span class="nav-link-text ms-1">DECLINED REQUEST</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('myApproved') ? 'active' : '' }}"
                        href="{{ route('myApproved') }}">
                        <i class="fa-regular fa-thumbs-up"
                            style="color: {{ is_current_route('myApproved') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">MY APPROVED REQUEST</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('myRejected') ? 'active' : '' }}"
                        href="{{ route('myRejected') }}">
                        <i class="fa-solid fa-square-xmark"
                            style="color: {{ is_current_route('myRejected') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">MY DECLINED REQUEST</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('changePasscodeView') ? 'active' : '' }}"
                        href="{{ route('changePasscodeView') }}">
                        <i class="fa-solid fa-unlock"
                            style="color: {{ is_current_route('changePasscodeView') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">CHANGE PASSCODE</span>
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
                        <span class="nav-link-text ms-1">REQUEST FOR EVENT RENTS</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('waitingForReceipt') ? 'active' : '' }}"
                        href="{{ route('waitingForReceipt') }}">
                        <i class="fa-solid fa-bell"
                            style="color: {{ is_current_route('waitingForReceipt') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">PENDING RECEIPT</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('outsideUser') ? 'active' : '' }}"
                        href="{{ route('outsideUser') }}">
                        <i class="fa-solid fa-users"
                            style="color: {{ is_current_route('outsideUser') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">OUTSIDER USER</span>
                    </a>
                </li>

                <!-- EVENT CALENDAR -->
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                        href="{{ route('calendar') }}">
                        <i class="fa-solid fa-calendar-days"
                            style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                        <span class="nav-link-text ms-1">EVENT CALENDAR</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('approvedEventsBusinessManager') ? 'active' : '' }}"
                        href="{{ route('approvedEventsBusinessManager') }}">
                        <i class="fa-regular fa-thumbs-up"
                            style="color: {{ is_current_route('approvedEventsBusinessManager') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">MY APPROVED REQUEST</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('rejectedEventsBusinessManager') ? 'active' : '' }}"
                        href="{{ route('rejectedEventsBusinessManager') }}">
                        <i class="fa-solid fa-square-xmark"
                            style="color: {{ is_current_route('rejectedEventsBusinessManager') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">MY DECLINED REQUEST</span>
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
                        <span class="nav-link-text ms-1">VENUE REQUEST</span>
                    </a>
                </li>
                <!-- EVENT CALENDAR -->
                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('calendar') ? 'active' : '' }}"
                        href="{{ route('calendar') }}">
                        <i class="fa-solid fa-calendar-days"
                            style="color: {{ is_current_route('calendar') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                        <span class="nav-link-text ms-1">EVENT CALENDAR</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('statusOutsiderEvents') ? 'active' : '' }}"
                        href="{{ route('statusOutsiderEvents') }}">
                        <i class="fa-solid fa-circle-check"
                            style="color: {{ is_current_route('statusOutsiderEvents') ? '#774dd3' : 'defaultColor' }};font-size: 18px;"></i>
                        {{-- <i class="fa-solid fa-calendar-plus"></i> --}}
                        <span class="nav-link-text ms-1">STATUS OF YOUR REQUEST</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('approvedEventsOutsider') ? 'active' : '' }}"
                        href="{{ route('approvedEventsOutsider') }}">
                        <i class="fa-regular fa-thumbs-up"
                            style="color: {{ is_current_route('approvedEventsOutsider') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">MY APPROVED REQUEST</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link  {{ is_current_route('rejectedEventsOutsider') ? 'active' : '' }}"
                        href="{{ route('rejectedEventsOutsider') }}">
                        <i class="fa-solid fa-square-xmark"
                            style="color: {{ is_current_route('rejectedEventsOutsider') ? '#774dd3' : 'defaultColor' }}; font-size:{{ is_current_route('adaaRequest') ? '23px' : '18px' }};"></i>
                        <span class="nav-link-text ms-1">MY DECLINED REQUEST</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>

</aside>
