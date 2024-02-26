<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Description</title>
    <!-- Bootstrap CSS link (assuming you are using Bootstrap for styling) -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card my-5">
                    <div class="card-header">
                        <h5 class="card-title">Rules and Regulations</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-dark font-weight-semibold mb-0">
                            <!-- Fetch and display description from the database -->
                            @foreach ($venues as $venue)
                                <ul>
                                    @foreach (explode("\n", $venue->description) as $bullet)
                                        <li>{{ $bullet }}</li>
                                    @endforeach
                                </ul>
                            @endforeach

                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url('venues')}}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
