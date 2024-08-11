<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <title>Complaints Desk | Login</title>
    </head>

    <body class="bg-danger w-100 vh-100 justify-content-center align-items-center d-flex">
        <form class="bg-light d-flex flex-column gap-2 p-3 pt-5 rounded-3 w-25" style="height: fit-content;">
            @csrf

            <h2 class="text-center text-danger mb-5">WMSU Complaints Desk</h2>

            <input class="form-control border-danger border-2" type="text" name="username" placeholder="Username">
            <input class="form-control border-danger border-2" type="text" name="password" placeholder="Password">

            <input class="btn btn-danger mt-5" type="submit" value="Login">
        </form>
    </body>
</html>