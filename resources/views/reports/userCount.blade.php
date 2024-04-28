<!DOCTYPE html>
<html>
<head>
    <title>Users Count Table</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif; /* Example using Helvetica as the primary font */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #b480e4;
        }
        td {
            background-color: #e8e2ee;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h3>Users Count Table</h3>
    </div>
    
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Role</th>
                <th scope="col">Numbers of User/s</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rolesCount as $rolesCounts)
                <tr>
                    <td>{{ $rolesCounts->role }}</td>
                    <td>{{ $rolesCounts->count }}</td>
                </tr>                
            @endforeach
        </tbody>
    </table>
    
    <br>
    <table class="table table-striped table-hover" style="border-radius: 20px; border-collapse: separate; border-spacing: 0 10px; width: 100%;">
        <thead>
            <tr>
                <th scope="col" style="padding: 10px;">ID</th>
                <th scope="col" style="padding: 10px;">User Name</th>
                <th scope="col" style="padding: 10px;">Email</th>
                <th scope="col" style="padding: 10px;">Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 10px;">{{ $user->id }}</td>
                <td style="padding: 10px;">{{ $user->name }}</td>
                <td style="padding: 10px;">{{ $user->email }}</td>
                <td style="padding: 10px;">{{ $user->role }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <div style="text-align: center">
        <p>Date Printed: <?php echo date('F j, Y, g:i a'); ?></p>
    </div>
</body>
</html>