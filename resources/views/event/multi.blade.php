<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <img class="img-fluid ms-auto me-auto d-block"
                    src="https://www.emptycode.in/wp-content/uploads/2022/07/emptycode-dark.png" width="200">
            </div>
        </div>
    </div>
</header>

<section class="mt-4">
    <div class="container">
        <form class="card">
            <div class="card-header">
                <nav class="nav nav-pills nav-fill">
                    <a class="nav-link tab-pills" href="#">Personal Details</a>
                    <a class="nav-link tab-pills" href="#">Address Details</a>
                    <a class="nav-link tab-pills" href="#">Company Details</a>
                    <a class="nav-link tab-pills" href="#">Finish</a>
                </nav>
            </div>
            <div class="card-body">
                <div class="tab d-none">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Please enter name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Please enter email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Please enter password">
                    </div>
                </div>

                <div class="tab d-none">
                    <div class="mb-3">
                        <label for="name" class="form-label">Address 1</label>
                        <input type="text" class="form-control" name="name" id="name"
                            placeholder="Please enter address 1">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Address 2</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Please enter address 2">
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" name="city" id="city"
                                placeholder="Please enter city">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="state" class="form-label">State</label>
                            <input type="state" class="form-control" name="state" id="state"
                                placeholder="Please enter state">
                        </div>
                    </div>
                </div>

                <div class="tab d-none">
                    <div class="mb-3">
                        <label for="company_name" class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" id="company_name"
                            placeholder="Please enter company name">
                    </div>
                    <div class="mb-3">
                        <label for="company_address" class="form-label">Company Address</label>
                        <textarea class="form-control" name="company_address" id="company_address" placeholder="Please enter company address"></textarea>
                    </div>
                </div>

                <div class="tab d-none">
                    <p>All Set! Please submit to continue. Thank you</p>
                </div>
            </div>
            <div class="card-footer text-end">
                <div class="d-flex">
                    <button type="button" id="back_button" class="btn btn-link" onclick="back()">Back</button>
                    <button type="button" id="next_button" class="btn btn-primary ms-auto"
                        onclick="next()">Next</button>
                    <button type="submit" id="submit_button" class="btn btn-primary ms-auto"
                    onclick="next()">Submit</button>
                </div>
            </div>
        </form>
    </div>
</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $("#submit_button").hide()
    var current = 0;
    var tabs = $(".tab");
    var tabs_pill = $(".tab-pills");

    loadFormData(current);  

    function loadFormData(n) {
        
        $(tabs_pill[n]).addClass("active");
        $(tabs[n]).removeClass("d-none");
        $("#back_button").attr("disabled", n == 0 ? true : false);
        n == tabs.length - 1 ?
            $("#next_button").hide() && $("#submit_button").show(): 
            $("#next_button")
            .attr("type", "button")
            .text("Next")
            .attr("onclick", "next()");
    }

    function next() {
        $(tabs[current]).addClass("d-none");
        $(tabs_pill[current]).removeClass("active");

        current++;
        loadFormData(current);
    }

    function back() {
        $(tabs[current]).addClass("d-none");
        $(tabs_pill[current]).removeClass("active");
        $("#next_button").show()
        $("#submit_button").hide()
        current--;
        loadFormData(current);
    }
</script>
