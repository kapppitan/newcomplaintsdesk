<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <title>Complaints Desk | Office</title>

        <style>
            #nav button.active {
                filter: brightness(90%);
            }

            #logout:focus {
                filter: brightness(90%);
            }
        </style>
    </head>

    <body class="bg-light vh-100 d-flex overflow-hidden">
        <div class="row w-100 m-0">
            <div class="col-3 bg-danger p-0 d-flex flex-column">
                <div class="p-3">
                    <h3 class="text-light">Office Name</h3>
                    <hr class="border-light border-2">

                    <ul class="nav nav-pills nav-fill flex-column mb-auto gap-2" role="tablist" id="nav">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-danger text-light d-flex active" id="btn-overview" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button" role="tab" aria-controls="btn-overview" aria-selected="true">
                                <i class="bi-speedometer me-2"></i>Overview
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-danger text-light d-flex" id="btn-inbox" data-bs-toggle="pill" data-bs-target="#tab-inbox" type="button" role="tab" aria-controls="btn-inbox" aria-selected="false">
                                <div class="me-auto">
                                    <i class="bi-inbox-fill me-2"></i>Inbox
                                </div>
                                <span class="badge">1</span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-danger text-light d-flex" id="btn-sent" data-bs-toggle="pill" data-bs-target="#tab-sent" type="button" role="tab" aria-controls="btn-sent" aria-selected="false">
                                <i class="bi-send-fill me-2"></i>Sent
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-danger text-light d-flex" id="btn-profile" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button" role="tab" aria-controls="btn-profile" aria-selected="false">
                                <i class="bi-person-circle me-2"></i>Profile
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-9 tab-content p-3 h-100 overflow-scroll overflow-x-hidden" id="tabContent">
                <div class="tab-pane fade flex-column show active" id="tab-overview" role="tabpanel" aria-labelledby="btn-overview" tabindex="0">
                    <h5 class="text-secondary-emphasis">Overview</h5>
                    <hr class="border-2">
                </div>

                <div class="tab-pane fade flex-column show" id="tab-inbox" role="tabpanel" aria-labelledby="btn-inbox" tabindex="0">
                    <h5 class="text-secondary-emphasis">Inbox</h5>
                    <hr class="border-2">

                    <input class="form-control mb-2 w-25 ms-auto" type="search" name="search" placeholder="Search...">

                    <div class="list-group">
                        
                    </div>
                </div>

                <div class="tab-pane fade flex-column show" id="tab-sent" role="tabpanel" aria-labelledby="btn-sent" tabindex="0">
                    <h5 class="text-secondary-emphasis">Cases Sent</h5>
                    <hr class="border-2">
                </div>

                <div class="tab-pane fade flex-column show" id="tab-profile" role="tabpanel" aria-labelledby="btn-profile" tabindex="0">
                    <h5 class="text-secondary-emphasis">Profile</h5>
                    <hr class="border-2">
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>
