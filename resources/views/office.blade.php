<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <title>Complaints Desk | {{ $office->office_name }}</title>

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
                <div class="p-3 d-flex flex-column h-100">
                    <h3 class="text-light">{{ $office->office_name }}</h3>
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
                                <span class="badge">{{ $complaints->count() }}</span>
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

                    <hr class="border-light border-2">

                    <span class="text-light mb-2" style="font-size: small;"><span class="fw-bold">Logged in as:</span> {{ Auth::user()->username }}</span>

                    <a class="btn btn-danger d-flex border-0 px-3 py-2" href="/logout">
                      <i class="bi-box-arrow-left me-2"></i>Logout
                    </a>
                </div>
            </div>

            <div class="col-9 tab-content p-3 h-100 overflow-scroll overflow-x-hidden" id="tabContent">
                <div class="tab-pane fade flex-column show active" id="tab-overview" role="tabpanel" aria-labelledby="btn-overview" tabindex="0">
                    <div class="container mb-2 position-relative">
                        <img style="border-radius: 85px 0 0 85px; height: 200px; width: 100%; object-fit: cover;" src="{{ asset('image/house.jpg') }}" alt="">
                        <img class="position-absolute rounded-circle" style="height: 200px; width: 200px; object-fit: cover; top: 0; left: 0;" src="{{ asset('image/house.jpg') }}" alt="">
                        <h1 class="ms-5 mt-2">{{ $office->office_name }}</h1>
                    </div>

                    <h5 class="text-secondary-emphasis">Overview</h5>
                    <hr class="border-2">
                </div>

                <div class="tab-pane fade flex-column show" id="tab-inbox" role="tabpanel" aria-labelledby="btn-inbox" tabindex="0">
                    <h5 class="text-secondary-emphasis">Inbox</h5>
                    <hr class="border-2">

                    <input class="form-control mb-2 w-25 ms-auto" type="search" name="search" placeholder="Search...">

                    <div class="list-group">
                        @foreach ($complaints as $complaint)
                            <a href="qao/complaint/form/{{ $complaint->id }}" class="list-group-item" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ \Illuminate\Support\Str::limit($complaint->details, 50, $end = "...") }}</h5>
                                    <small class="text-secondary">{{ $complaint->created_at->diffForHumans() }}</small>
                                </div>

                                <p class="mb-2">
                                    @switch ($complaint->complaint_type)
                                        @case(1)
                                            Slow service
                                            @break
                                        @case(2)
                                            Unruly/disrespectful personnel
                                            @break
                                        @case(3)
                                            No response
                                            @break
                                        @case(4)
                                            Error/s on request
                                            @break
                                        @case(5)
                                            Delayed issuance of request
                                            @break
                                        @case(6)
                                            Others (Specific issue)
                                            @break
                                    @endswitch
                                </p>

                                <small class="text-secondary" style="font-size: 12px;">
                                    .
                                </small>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade flex-column show" id="tab-sent" role="tabpanel" aria-labelledby="btn-sent" tabindex="0">
                    <h5 class="text-secondary-emphasis">Cases Sent</h5>
                    <hr class="border-2">
                </div>

                <div class="tab-pane fade flex-column show" id="tab-profile" role="tabpanel" aria-labelledby="btn-profile" tabindex="0">
                    <h5 class="text-secondary-emphasis">Profile</h5>
                    <hr class="border-2">

                    <form action="">
                        @csrf

                        <div class="input-group">
                            <span class="input-group-text">Username</span>
                            <input type="text" class="form-control">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>
