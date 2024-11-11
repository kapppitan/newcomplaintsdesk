<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <title>Complaints Desk | QMSO</title>

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
            <div class="col-2 bg-danger p-3 d-flex flex-column">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('image/logo.png') }}" style="object-fit: fill; height: 50px; width: 50px;">
                    <h4 class="text-light m-0 fs-5">Complaints Desk</h4>
                </div>
                
                <hr class="border-light border-2">

                <ul class="nav nav-pills nav-fill flex-column mb-auto gap-2" role="tablist" id="nav">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex active" id="btn-overview" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button" role="tab" aria-controls="btn-overview" aria-selected="true">
                            <i class="bi-speedometer me-2"></i>Dashboard
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-tab" data-bs-toggle="pill" data-bs-target="#tab-tab" type="button" role="tab" aria-controls="btn-tab" aria-selected="false">
                            <div class="me-auto">    
                                <i class="bi-file-earmark-check-fill me-2"></i>Complaints
                            </div>
                            <span class="badge"></span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex" id="btn-profile" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button" role="tab" aria-controls="btn-profile" aria-selected="false">
                            <i class="bi-person-lines-fill me-2"></i>Profile
                        </button>
                    </li>

                    <li class="nav-item visually-hidden" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex" id="btn-complaint" data-bs-toggle="pill" data-bs-target="#tab-complaint" type="button" role="tab" aria-controls="btn-complaint" aria-selected="false">
                            <i class="bi-person-lines-fill me-2"></i>Complaint
                        </button>
                    </li>
                </ul>

                <hr class="border-light border-2">

                <a class="btn btn-danger d-flex border-0 px-3 py-2" href="/logout">
                    <i class="bi-box-arrow-left me-2"></i>Logout
                </a>
            </div>

            <div class="col-10 tab-content p-3 h-100 overflow-scroll overflow-x-hidden" id="tabContent">
                <div class="tab-pane flex-column show active" id="tab-overview" role="tabpanel" aria-labelledby="btn-overview" tabindex="0">
                    <h5 class="text-secondary-emphasis m-0">Dashboard</h5>

                    <hr class="border-2">
                </div>

                <div class="tab-pane flex-column" id="tab-tab" role="tabpanel" aria-labelledby="btn-tab" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Complaints</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search" placeholder="Search..." onkeyup="search_complaint(1)" id="search-pending">
                    </div>

                    <hr class="border-2">

                    <div class="list-group" id="complaints-pending">
                        @php
                            $pendingComplaints = $complaints->filter(function($complaint) {
                                return $complaint->phase == 3;
                            });
                        @endphp

                        @if ($pendingComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">No submitted complaints yet!</p>
                        @else
                            @foreach ($complaints as $complaint)
                                @if ($complaint->phase === 3)
                                    <a href="complaint/form/print/{{ $complaint->id }}" class="list-group-item complaint-link" data-toggle="tab" aria-current="true" data-id="{{ $complaint->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1 {{ $complaint->is_read == true ? 'text-secondary' : '' }}">{{ \Illuminate\Support\Str::limit($complaint->details, 70, $end = "...") }}</h5>
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
                                            <h6>
                                                @switch ($complaint->phase)
                                                    @case(0)
                                                        <span class="badge text-bg-primary rounded-pill">Pending</span>
                                                        @break
                                                    @case(3)
                                                        <span class="badge text-bg-success text-white rounded-pill">Pending</span>
                                                        @break
                                                    @case(4)
                                                        @break
                                                @endswitch
                                            </h6>
                                        </small>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="tab-pane flex-column" id="tab-profile" role="tabpanel" aria-labelledby="btn-profile" tabindex="0">
                    profile
                </div>

                <div class="tab-pane flex-column" id="tab-complaint" role="tabpanel" aria-labelledby="btn-complaint" tabindex="0">
                    <a href="">Back</a>

                    <hr class="border-2">

                    <div class="d-flex gap-2">
                        <p>Submitted on <span class="fw-bold" id="csub"></span></p>
                        <span class="text-secondary" id="cago"></span>
                    </div>

                    <div class="row h-100">
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label class="form-label" for="details">Details</label>
                                <textarea class="form-control mb-2" name="cdetails" id="cdetails" rows="21" style="resize: none;" disabled></textarea>
                            
                                <form class="input-group" method="post" action="" id="complaint-form">
                                    @csrf

                                    <select class="form-select rounded-start" name="cstatus" id="cstatus">
                                        <option value="1">Legitimate</option>
                                        <option value="2">Non-conformity</option>
                                        <option value="3">Inquiry</option>
                                        <option value="4">Closed</option>
                                    </select>

                                    <button class="btn btn-danger" type="submit">Update Status</button>
                                </form>
                            </div>
                        </div>

                        <div class="col-sm-5 d-flex flex-column gap-2">
                            <div class="form-group">
                                <label class="form-label" for="coffice">Recipient</label>
                                <input class="form-control" type="text" name="coffice" id="coffice" disabled>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cname">Complainant</label>

                                <div class="d-flex flex-column gap-2">
                                    <input class="form-control" type="text" name="cname" id="cname" disabled>
                                    <input class="form-control" type="text" name="type" id="ctype" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="cnumber">Contact Information</label>

                                <div class="d-flex flex-column gap-2">
                                    <input class="form-control" type="email" name="cemail" id="cemail" disabled>
                                    <input class="form-control" type="text" name="cnumber" id="cnumber" disabled>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2 mt-auto">
                                <button class="btn btn-danger" onclick="showFiles()">View Attached Files</button>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-danger flex-fill" id="btn-memo">Memo</button>
                                    <button class="btn btn-danger flex-fill" id="btn-ccf">Customer Complaint Form</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>