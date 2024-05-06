<x-app-layout>
    {{-- <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/homepage.css" rel="stylesheet">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-md-flex align-items-center mb-3 mx-2">
                        <div class="mb-md-0 mb-3">
                            <h3 class="font-weight-bold mb-0">Hello, {{ Auth::user()->name }}</h3>
                            <p class="mb-0">WELCOME TO CALENDASH</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ======= SLIDER UPCOMING EVENTS ======= -->
            <hr class="my-0">
            <div class="row">
                <h3 style="text-align: center; margin-top: 2%">Process of Request Letter</h3>
                <p>Welcome to CALENDASH, where scheduling events is as seamless as sending a letter. Our
                    intuitive platform simplifies the process of organizing events,
                    ensuring that your planning experience is smooth and efficient. To schedule an event using
                    CALENDASH, simply follow these easy steps:</p><br>
                <div class="position-relative overflow-hidden">
                    <div class="swiper mySwiper mt-4 mb-2">
                        <div class="swiper-wrapper">

                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">Welcome to CALENDASH,<br></h5>
                                            <h6>To schedule an event using CALENDASH, simply follow these easy steps:
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">1. LOGIN</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">Users or event organizers
                                                    should login their google account first to schedule an event.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">2. COMPLETE PROFILE</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">User or event organizer must
                                                    complete their details accurately
                                                    and wait for the admin to approve your account.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">3. CLICK CREATE EVENTS</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">Users or event organizers are
                                                    required to fill up the form
                                                    that includes details of the event.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">4. SELECT VENUE</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">After inputing details about
                                                    the event, Users or event
                                                    organizers are required to select the preferred venue for their
                                                    event that is
                                                    suitable for the capacity of attendees.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">5. CREATE A FEEDBACK FORM FOR THE EVENT
                                            </h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">Please provide a link for
                                                    your feedback form since the system
                                                    requires a feedback form to turn into QR code for more accessible
                                                    for
                                                    participants</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">6. CREATE/UPLOAD REQUEST LETTER</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">The user or event organizers
                                                    can upload or create their
                                                    request letter using the system. After creating the letter, it can
                                                    be saved as PDF.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">7. APPROVAL STATUS</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">After the user or event
                                                    organizer submit its request letter,
                                                    the system will show the timeline status to notify the event
                                                    organizers if their
                                                    letter is approved, pending or rejected.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">8. UPLOAD LIST OF ATTENDEES</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">The system requires event
                                                    organizers to upload an Excel file
                                                    containing their list of attendees. This enables organizers to
                                                    monitor
                                                    attendance effectively within the system.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">9. UPLOAD LIST OF ATTENDEES</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">The system requires event
                                                    organizers to upload an Excel file
                                                    containing their list of attendees. This enables organizers to
                                                    monitor
                                                    attendance effectively within the system.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border-radius-xl align-items-start mb-0">
                                    <div class="card-body text-center ">
                                        <div class="row mt-4">
                                            <h5 class="card-title font-weight-bold text-center"
                                                style="color:rgb(25, 7, 90)">10. UPLOAD ACCOMPLISHMENT REPORT</h5>
                                            <ul>
                                                <p class="card-text" style="color: black;">After the event concludes,
                                                    organizers must submit their
                                                    accomplishment reports through the system; failure to do so will
                                                    result in their
                                                    inability to schedule future events.</p>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div><br><br>
            <style>
                .swiper-slide {
                    background-color: rgb(1, 1, 43);
                    color: #fff;
                    border-radius: 10px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    padding: 20px;
                }

                .swiper-slide h5 {
                    margin-bottom: 10px;
                }

                .swiper-button-prev,
                .swiper-button-next {
                    color: #fff;
                }
            </style>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var swiper = new Swiper(".mySwiper", {
                        effect: "cards",
                        grabCursor: true,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        initialSlide: 0 // Set the initial slide index to 0 (the first slide)
                    });
                });
            </script>

            <!-- END SLIDER PROCESS OF REQUEST LETTER -->

            <!-- ======= DESCRIPTION ======= -->
            <section id="about" class="about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 order-1 order-lg-2">
                            <img src="../assets/img/aboutss.png" class="img-fluid" alt=""
                                style="width: 500px;
                             margin-top: 10px; border-radius: 20px ">
                        </div>
                        <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content ">
                            <h3>Experience the convenience and reliability of CALENDASH today!</h3>
                            <p></p>
                            <p>
                                At CALENDASH, we understand the importance of seamlessly coordinating events within
                                educational institutions. Our system empowers administrators, faculty, and students
                                alike to effortlessly schedule, track, and manage a wide range of events, from lectures
                                and workshops to extracurricular activities and seminars.
                            </p>
                            <p></p>
                            <p>
                                With user-friendly interfaces and intuitive features, CALENDASH simplifies the process
                                of creating and managing events, allowing for better communication, collaboration, and
                                coordination among all stakeholders. Our comprehensive solution provides real-time
                                updates, customizable notifications, and detailed reporting, enabling administrators to
                                stay informed and in control at all times.
                            </p>

                            <p></p>
                            <p>
                                Whether you're coordinating class schedules, planning special events, or managing
                                resources, CALENDASH is your go-to platform for efficient and effective event
                                management. Join us in revolutionizing the way events are scheduled and monitored at TUP
                                Taguig.
                            </p>
                        </div>
                    </div>

                </div>
            </section><br><br>
            <!-- End DESCRIPTION SECTION -->

            <!-- ======= CTA SECTION ======= -->
            <section id="cta" class="cta">
                <div class="container">

                    <div class="row">
                        <div class="col-lg-9 text-center text-lg-start">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button border-bottom font-weight-bold collapsed"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                    aria-expanded="false" aria-controls="collapseFour">
                                    <h2>Term and Conditions</h2>
                                    <i class="collapse-open fa fa-arrow-down text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"></i>
                                    <i class="collapse-close fa fa-arrown-up text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"></i>

                                </button>
                                <p>These Terms and Conditions <b>("Terms")</b> govern the scheduling of events in
                                    Technological University of the Philippines - Taguig <b>("TUP-T")</b> by CALENDASH
                                    for
                                    the TUP-T students, faculty, and guests <b>(Users)</b>. <br>By engaging our
                                    services,
                                    the Users agree to abide by these Terms.</p>
                            </h5>

                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionRental" style="color:black;">
                                <div class="accordion-body text-sm opacity-8">
                                    <ol style="font-size: 16px">
                                        <b>
                                            <li>Event Details</li>
                                        </b>
                                        <ul>
                                            <li>The Users agree to provide accurate and complete information regarding
                                                the
                                                event, including date, time, location, and any specific requirements.
                                            </li>
                                            <li>Once the event is approved by the school officials, any changes to the
                                                event
                                                details will not be tolerated.</li>
                                        </ul>
                                        <b>
                                            <li>Booking and Approval</li>
                                        </b>
                                        <ul>
                                            <li>Events must be booked through the CALENDASH platform.</li>
                                            <li>Submission of event details does not guarantee approval. CALENDASH will
                                                seek
                                                approval from school officials, and only approved events will be
                                                scheduled.
                                            </li>
                                            <li>The specific dates and times allotted during which the venue is in use,
                                                including setup and teardown times must be followed.</li>
                                        </ul>
                                        <b>
                                            <li>Cancellation</li>
                                        </b>
                                        <ul>
                                            <li>CALENDASH reserves the right to cancel or reschedule an event in
                                                consultation with school officials due to unforeseen circumstances.</li>
                                        </ul>
                                        <b>
                                            <li>Responsibilities</li>
                                        </b>
                                        <ul>
                                            <li>The Users are responsible for obtaining any necessary permits or
                                                permissions
                                                for the event.</li>
                                            <li>CALENDASH is not liable for any damages, injuries, or losses incurred
                                                during
                                                the event unless caused by gross negligence or willful misconduct.</li>
                                            <li>Venue should be returned after use, including cleanliness and any
                                                specific
                                                requirements for repairs or maintenance.</li>
                                        </ul>
                                        <b>
                                            <li>Approval Process</li>
                                        </b>
                                        <ul>
                                            <li>The approval process involves coordination with TUP-T officials. Users
                                                are
                                                advised to submit event request letter in advance to allow for the
                                                approval
                                                process.</li>
                                        </ul>
                                        <b>
                                            <li>Rejection</li>
                                        </b>
                                        <ul>
                                            <li>CALENDASH reserves the right to reject an event in consultation with
                                                school officials due to unforeseen circumstances.</li>
                                        </ul>
                                    </ol>
                                    <b>
                                        <p>By engaging our services, the Users acknowledge that they have read,
                                            understood,
                                            and agreed to these <br>Terms and Conditions. These Terms may be subject to
                                            change, and Users will be notified of any revisions.</p>
                                    </b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><br><br>
            <!-- End CTA SECTION -->

            <!-- ======= FAQ's Section ======= -->
            <section id="faq" class="faq">
                <div class="accordion-1">
                    <div class="container">
                        <div class="row mt-5 mb-2">
                            <div class="col-md-6">
                                <h3>Frequently Asked Questions (FAQ's)</h3>
                                {{-- <p>A lot of people don’t appreciate the moment until it’s passed. I'm not trying my
                                    hardest, and I'm not trying to do </p> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="accordion" id="accordionRental">
                                    <div class="accordion-item mb-3">
                                        <h5 class="accordion-header" id="headingOne">
                                            <button class="accordion-button border-bottom font-weight-bold collapsed"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="false"
                                                aria-controls="collapseOne">
                                                <h6>How do I create/request an event?</h6>
                                                <i class="collapse-open fa fa-arrow-down text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                                <i class="collapse-close fa fa-arrown-up text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                            </button>
                                        </h5>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionRental"
                                            style="color:black;">
                                            <div class="accordion-body text-sm opacity-8">
                                                <ul style="font-size: 16px">
                                                    <li>Click <b>"Create an Event"</b> on the left side of the screen /
                                                        sidebar</li>
                                                    <li>After that, fill out the forms for the event details. It
                                                        includes the <b>Event Name, Event Description, No. of
                                                            participants</b></li>
                                                    <li>Next, Choose if your requesting a <b>Venues</b> or <b>Rooms</b>.
                                                        For <b>OUTSIDERS</b>, venues option is only option available for
                                                        renting</li>
                                                    <li>After choosing if venues or rooms. <b>Please select the radio
                                                            button/ circle button to choose your desired venue or
                                                            room.</b> </li>
                                                    <li>Now, choose what is your preferred date and time. You will
                                                        choose if your event is Within the Day, Whole Day, Whole Week,
                                                        Date Range
                                                        <ul>
                                                            <li>If you select <b>"Within the Day,"</b> you will need to
                                                                specify the date, start and end times for your event
                                                            </li>
                                                            <li>If you select <b>"Whole Day,"</b> your event will be
                                                                scheduled for the entire day</li>
                                                            <li>If you select <b>"Whole Week,"</b> your event will be
                                                                scheduled for the entire week</li>
                                                            <li>If you select <b>"Date Range,"</b> you will need to
                                                                specify the start and end dates for your event</li>
                                                        </ul>
                                                    </li>
                                                    <li>After choosing date and time, please fill out the link for the
                                                        <b>feedback form</b>. For example,
                                                        <b>"docs.google.com/forms/u/...."</b>
                                                    </li>
                                                    <li>Explore our formatting tool on the final page to customize your
                                                        request letter. <b>If you're composing your letter in the
                                                            textarea, follow the steps above the form to generate it
                                                            effectively.</b></li>
                                                    <li>After that, you are going to upload your request letter. Please
                                                        make sure its file type is <b>PDF</b>!</li>
                                                    <li>Please read and check <b>"Accept"</b> on our <b>"Term and
                                                            conditions"</b> first to submit your event! </li>
                                                    <li>Now after clicking the submit button it will show your summary
                                                        on creating your event.</li>
                                                    <li>After confirming it. Congrats! Your event is now created!</li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item mb-3">
                                        <h5 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button border-bottom font-weight-bold collapsed"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo">
                                                <h6> How will I know the status of my events?</h6>
                                                <i class="collapse-open fa fa-arrow-down text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                                <i class="collapse-close fa fa-arrown-up text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                            </button>
                                        </h5>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#accordionRental">
                                            <div class="accordion-body text-sm opacity-8" style="color: black">
                                                <p style="font-size: 16px">
                                                    Just click the <b>"My Event Status"</b> on the <b>sidebar</b> to
                                                    redirect to your events list.
                                                    <br>
                                                    Now click the <b>"View Details"</b> button and now you can see your
                                                    event status!
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item mb-3">
                                        <h5 class="accordion-header" id="headingThree">
                                            <button class="accordion-button border-bottom font-weight-bold"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseThree" aria-expanded="false"
                                                aria-controls="collapseThree">
                                                <h6>How much time does it take to approve my event request?</h6>
                                                <i class="collapse-open fa fa-arrow-down text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                                <i class="collapse-close fa fa-arrown-up text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                            </button>
                                        </h5>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionRental">
                                            <div class="accordion-body text-sm opacity-8" style="color: black">
                                                <p style="font-size: 16px">
                                                    We apologize, but our system cannot guarantee a specific approval
                                                    timeline for your request. Approval times may vary depending on the
                                                    officials' review process.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section><br><br>
            <!-- End FAQ's Section -->

            <!-- ======= ABOUT US SECTION ======= -->
            <section id="about" class="about">
                <div class="container">
                    <div class="row">
                        <div class="section-title text-center">
                            <h2>About Us</h2>
                            <p>Welcome to CALENDASH, your premier solution for School Event Scheduling and Monitoring at
                                TUP
                                Taguig. Our platform is designed to streamline the scheduling process and enhance the
                                monitoring of school events, ensuring efficiency and organization throughout the
                                academic
                                calendar.</p>
                        </div>
                    </div><br><br>
                </div>
                <section id="about" class="about">
                    <!-- End ABOUT US SECTION -->

                    <!-- ======= Team Section ======= -->
                    <section id="team" class="team section-bg">
                        <div class="container">

                            <div class="section-title">
                                <h2 style="text-align: center">Meet the Team</h2>
                                <p>Our team comprises dedicated individuals with diverse skill sets and backgrounds,
                                    all united by a common goal: to create innovative solutions that enhance
                                    productivity and
                                    efficiency.
                                    Each member brings unique expertise and perspectives to the table, fostering a
                                    collaborative
                                    environment
                                    where creativity thrives and challenges are met with enthusiasm.</p>
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                        <div class="member">
                                            <img src="assets/img/dom.png" alt=""
                                                style="max-width: 100%; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);">
                                            <h4>John Dominic M. Acuisa</h4>
                                            {{-- Additional content --}}
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                        <div class="member">
                                            <img src="assets/img/xy.png" alt=""
                                                style="max-width: 80%; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);">
                                            <h4>Xyra C. Ebron</h4>
                                            {{-- Additional content --}}
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                        <div class="member">
                                            <img src="assets/img/je.png" alt=""
                                                style="max-width: 80%; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);">
                                            <h4>Jerico B. Aguirre</h4>
                                            {{-- Additional content --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .member {
                                    text-align: center;
                                    /* Center the content horizontally */
                                    margin-bottom: 100px;
                                    /* Add some space between each member */
                                }

                                .member img {
                                    max-width: 100%;
                                    /* Make sure the image doesn't exceed the container width */
                                    height: 250px;
                                    /* Set the desired height for all images */
                                    object-fit: cover;
                                    /* Ensure the image covers the entire container */
                                }
                            </style>
                        </div>
                    </section><!-- End Team Section -->
        </div>
    </main><!-- End #main -->

    </div>
    </main>

</x-app-layout>
