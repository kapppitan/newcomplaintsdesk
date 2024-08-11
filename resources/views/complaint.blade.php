<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <title>Complaints Desk</title>
    </head>

    <body class="bg-light h-100">
        <nav class="bg-danger p-3 px-4 d-flex">
            <h3 class="text-light m-0 d-flex">WMSU Complaints Desk</h3>
        </nav>

        <form class="d-flex p-3 gap-2" method="post" action="{{ route('complain') }}" enctype="multipart/form-data">
            @csrf
            <div class="container p-0 d-flex gap-2 flex-column">
                <div class="form-group">
                    <label class="form-label m-0" for="type">Type of Complaint</label>
                    <select class="form-select border-danger border-2" name="complaint_type" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label m-0" for="description">Complaint Details</label>
                    <textarea class="form-control border-danger border-2" rows="15" name="details" required></textarea>
                </div>
            </div>

            <div class="container p-0 d-flex gap-2 flex-column">
                <div class="form-group">
                    <label class="form-label m-0" for="name">Complainant's Name</label>
                    <div class="input-group d-flex p-0">
                        <input class="form-control border-danger border-2 w-50 border-end-0" type="text" name="name" style="text-transform: capitalize;" required>
                        <select class="form-select border-danger border-2" name="user_type" required>
                            <option value="1">Student</option>
                            <option value="2">Alumni</option>
                            <option value="3">Staff</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label m-0" for="contact">Contact Information</label>
                    <div class="input-group">
                        <input class="form-control border-danger border-2 border-end-0" type="tel" name="phone" placeholder="Number" required>
                        <input class="form-control border-danger border-2" type="email" name="email" placeholder="Email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label m-0" for="recipient">Complaint Recipient</label>
                    <select class="form-select border-danger border-2" name="recipient" required>
                        <option value="0" selected disabled>Choose Recipient...</option>
                        <option value="1">Office 1</option>
                        <option value="2">Office 2</option>
                        <option value="3">Office 3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label m-0" for="evidence">Evidence</label>
                    <input class="form-control border-danger border-2" name="file" type="file" required>
                </div>

                <input class="btn btn-danger w-100 mt-auto" type="submit" value="Submit Complaint">
            </div>
        </form>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>