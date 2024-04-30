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
                <div class="position-relative overflow-hidden">
                    <div class="swiper mySwiper mt-4 mb-2">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div>
                                    <div
                                        class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                        <div class="full-background bg-cover"
                                            style="background-image: url('../assets/img/img-2.jpg')"></div>
                                        <div class="card-body text-start px-3 py-0 w-100">
                                            <div class="row mt-12">
                                                <div class="col-sm-3 mt-auto">
                                                    <h4 class="text-dark font-weight-bolder">#1</h4>
                                                    <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name
                                                    </p>
                                                    <h5 class="text-dark font-weight-bolder">Secured</h5>
                                                </div>
                                                <div class="col-sm-3 ms-auto mt-auto">
                                                    <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">
                                                        Category</p>
                                                    <h5 class="text-dark font-weight-bolder">Banking</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('../assets/img/img-1.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#2</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Cyber</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Security</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('../assets/img/img-3.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#3</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Alpha</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Blockchain</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('../assets/img/img-4.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#4</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Beta</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Web3</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('../assets/img/img-5.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#5</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Gama</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Design</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('../assets/img/img-1.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#6</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                                <h5 class="text-dark font-weight-bolder">Rompro</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Security</h5>
                                            </div>
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
            <!-- END SLIDER UPCOMING EVENTS -->

            <!-- ======= ABOUT US SECTION ======= -->
            <section id="about" class="about">
                <div class="container">
                    <div class="section-title text-center">
                        <h2 >About Us</h2>
                        <p>Welcome to CALENDASH, your premier solution for School Event Scheduling and Monitoring at TUP
                            Taguig. Our platform is designed to streamline the scheduling process and enhance the
                            monitoring of school events, ensuring efficiency and organization throughout the academic
                            calendar.</p>
                    </div><br><br>

                    <div class="row">
                        <div class="col-lg-6 order-1 order-lg-2">
                            <img src="../assets/img/aboutss.png" class="img-fluid" alt="" style="width: 500px; margin-top: 10px; ">
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
            <!-- End ABOUT US SECTION -->

            <!-- ======= CTA SECTION ======= -->
            <section id="cta" class="cta">
                <div class="container">

                    <div class="row">
                        <div class="col-lg-9 text-center text-lg-start">
                            <h3>Terms and Conditions</h3>
                            {{-- <p>The condition in which the venue should be returned after use, including cleanliness and
                                any specific requirements for repairs or maintenance.</p> --}}

                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button border-bottom font-weight-bold collapsed"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                    aria-expanded="false" aria-controls="collapseFour">
                                    <h6>The condition in which the venue should be returned after use, including
                                        cleanliness and any <br> specific requirements for repairs or maintenance.</h6>
                                    <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"></i>
                                    <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                        aria-hidden="true"></i>
                                </button>
                            </h5>

                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionRental" style="color:black;">
                                <div class="accordion-body text-sm opacity-8">
                                    <ul style="font-size: 16px">
                                        <li>The condition in which the venue should be returned after use, including
                                            cleanliness and
                                            any specific requirements for repairs or maintenance.</li>
                                        <li>Responsibility for any damages or loss of property during the event period.
                                        </li>
                                        <li>The condition in which the venue should be returned after use, including
                                            cleanliness and
                                            any specific requirements for repairs or maintenance.</li>
                                        <li>The specific dates and times allotted during which the venue is in use,
                                            including setup
                                            and teardown times must be followed.</li>
                                        <li>If the event lasts longer than the time allotted for it, a warning will be
                                            sent followed
                                            by punishment.</li>
                                        <li>It is the responsibility of an organization if any injuries, damages, arise
                                            from the
                                            event.</li>

                                    </ul>
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
                                                <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                                <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
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
                                                <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                                <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
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
                                                <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                    aria-hidden="true"></i>
                                                <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
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

            <!-- ======= Team Section ======= -->
            <section id="team" class="team section-bg">
                <div class="container">

                    <div class="section-title">
                        <h2 style="text-align: center">Meet the Team</h2>
                        <p>Our team comprises dedicated individuals with diverse skill sets and backgrounds,
                           all united by a common goal: to create innovative solutions that enhance productivity and efficiency. 
                           Each member brings unique expertise and perspectives to the table, fostering a collaborative environment
                           where creativity thrives and challenges are met with enthusiasm.</p>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                <div class="member">
                                    <img src="assets/img/dom.png" alt="" style="max-width: 100%; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);">
                                    <h4>John Dominic M. Acuisa</h4>
                                    {{-- Additional content --}}
                                </div>
                            </div>
                        
                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                <div class="member">
                                    <img src="assets/img/xy.png" alt="" style="max-width: 80%; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);">
                                    <h4>Xyra C. Ebron</h4>
                                    {{-- Additional content --}}
                                </div>
                            </div>
                        
                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                                <div class="member">
                                    <img src="assets/img/je.png" alt="" style="max-width: 80%; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);">
                                    <h4>Jerico B. Agguire</h4>
                                    {{-- Additional content --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .member {
                            text-align: center; /* Center the content horizontally */
                            margin-bottom: 100px; /* Add some space between each member */
                        }
                    
                        .member img {
                            max-width: 100%; /* Make sure the image doesn't exceed the container width */
                            height: 250px; /* Set the desired height for all images */
                            object-fit: cover; /* Ensure the image covers the entire container */
                        }
                    </style>
                    
                    
                    

                </div>
            </section><!-- End Team Section -->
        </div>
    </main><!-- End #main -->

    </div>
    </main>

</x-app-layout>
