<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <style>
            #nav button.active {
                filter: brightness(90%);
            }

            #logout:focus {
                filter: brightness(90%);
            }
        </style>

        <title>Complaints Desk | QAO</title>
    </head>

    <body class="bg-light vh-100 d-flex overflow-hidden">
        <div class="row w-100 m-0">
            <div class="col-3 bg-danger p-3 d-flex flex-column">
                <h3 class="text-light">title here</h3>
                <hr class="border-light border-2">

                <ul class="nav nav-pills nav-fill flex-column mb-auto gap-2" role="tablist" id="nav">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex active" id="btn-overview" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button" role="tab" aria-controls="btn-overview" aria-selected="true">
                            <i class="bi-speedometer me-2"></i>Overview
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-pending" data-bs-toggle="pill" data-bs-target="#tab-pending" type="button" role="tab" aria-controls="btn-pending" aria-selected="false">
                            <div class="me-auto">
                                <i class="bi-inbox-fill me-2"></i>Pending
                            </div>
                            <span class="badge">
                                @if ($pending > 0)
                                    {{ $pending }}
                                @endif
                            </span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-closed" data-bs-toggle="pill" data-bs-target="#tab-closed" type="button" role="tab" aria-controls="btn-closed" aria-selected="false">
                            <div class="me-auto">    
                                <i class="bi-file-earmark-check-fill me-2"></i>Processing
                            </div>
                            <span class="badge">
                                @if ($processing > 0)
                                    {{ $processing }}
                                @endif
                            </span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex" id="btn-archived" data-bs-toggle="pill" data-bs-target="#tab-archived" type="button" role="tab" aria-controls="btn-archived" aria-selected="false">
                            <i class="bi-archive-fill me-2"></i>Archive
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex" id="btn-management" data-bs-toggle="pill" data-bs-target="#tab-management" type="button" role="tab" aria-controls="btn-management" aria-selected="false">
                            <i class="bi-person-lines-fill me-2"></i>Management
                        </button>
                    </li>
                </ul>

                <hr class="border-light border-2">

                <button class="btn btn-danger d-flex border-0 px-3 py-2">
                    <i class="bi-box-arrow-left me-2"></i>Logout
                </button>
            </div>

            <div class="col-9 tab-content p-3 h-100 overflow-scroll overflow-x-hidden" id="tabContent">
                <div class="tab-pane fade flex-column show active" id="tab-overview" role="tabpanel" aria-labelledby="btn-overview" tabindex="0">
                    <h5 class="text-secondary-emphasis">Overview</h5>
                    <hr class="border-2">
                </div>
                
                <div class="tab-pane fade flex-column" id="tab-pending" role="tabpanel" aria-labelledby="btn-peding" tabindex="0">
                    <h5 class="text-secondary-emphasis">Pending Cases</h5>
                    <hr class="border-2">

                    <input class="form-control mb-2 w-25 ms-auto" type="search" name="search" placeholder="Search...">

                    <div class="list-group">
                        @foreach ($complaints as $complaint)
                            @if ($complaint->status === 0 or $complaint->status === 3)
                                <a href="qao/complaint/{{ $complaint->id }}" class="list-group-item" aria-current="true">
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
                                        <h6>
                                            @switch ($complaint->status)
                                                @case(0)
                                                    <span class="badge text-bg-primary rounded-pill">Pending</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge text-bg-warning text-white rounded-pill">Inquiry</span>
                                                    @break
                                            @endswitch
                                        </h6>
                                    </small>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                
                <div class="tab-pane fade flex-column" id="tab-closed" role="tabpanel" aria-labelledby="btn-closed" tabindex="0">
                    <h5 class="text-secondary-emphasis">Processing Cases</h5>
                    <hr class="border-2">

                    <input class="form-control mb-2 w-25 ms-auto" type="search" name="search-processing" placeholder="Search...">

                    <div class="list-group">
                        @foreach ($complaints as $complaint)
                            @if ($complaint->status)
                                <a href="qao/complaint/{{ $complaint->id }}" class="list-group-item" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">
                                            <span class="text-secondary">#{{ $complaint->ticket->ticket_number }}</span>
                                            {{ \Illuminate\Support\Str::limit($complaint->details, 50, $end = "...") }}
                                        </h5>
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
                                            @switch ($complaint->status)
                                                @case(0)
                                                    <span class="badge text-bg-primary rounded-pill">Pending</span>
                                                    @break
                                                @case(1)
                                                    <span class="badge text-bg-success rounded-pill">Legitimate</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge text-bg-warning text-light rounded-pill">Inquiry</span>
                                                    @break
                                            @endswitch
                                        </h6>
                                    </small>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                
                <div class="tab-pane fade flex-column" id="tab-archived" role="tabpanel" aria-labelledby="btn-archived" tabindex="0">
                    <h5 class="text-secondary-emphasis">Archived Cases</h5>
                    <hr class="border-2">

                    <input class="form-control mb-2 w-25 ms-auto" type="search" name="search-archived" placeholder="Search...">

                    <div class="list-group">
                        @foreach ($complaints as $complaint)
                            @if ($complaint->status === 4)
                                <a href="qao/complaint/{{ $complaint->id }}" class="list-group-item" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ \Illuminate\Support\Str::limit($complaint->details, 50, $end = "...") }}</h5>
                                        <small class="text-secondary">Closed on {{ date('F j, Y', strtotime($complaint->updated_at)) }}</small>
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
                                            <span class="badge text-bg-danger rounded-pill">Closed</span>
                                        </h6>
                                    </small>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
                
                <div class="tab-pane fade flex-column" id="tab-management" role="tabpanel" aria-labelledby="btn-management" tabindex="0">
                    <h5 class="text-secondary-emphasis">Management</h5>
                    <hr class="border-2">

                    <ul class="nav nav-tabs" role="tablist" id="settings">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark active" id="settings-account" data-bs-toggle="tab" data-bs-target="#tab-accounts" type="button" role="tab" aria-controls="settings-account" aria-selected="true">
                                Create Account
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-dark" id="settings-offices" data-bs-toggle="tab" data-bs-target="#tab-offices" type="button" role="tab" aria-controls="settings-offices" aria-selected="false">
                                Create Office
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mb-5 p-3 bg-white border border-top-0 border-1" id="settings">
                        <div class="tab-pane fade show active" id="tab-accounts" role="tabpanel" aria-labelledby="tab-accounts" tabindex="0">
                            <form class="flex-column d-flex" method="post" action="{{ route('create-account') }}" id="form-accounts">
                                @csrf

                                <div class="input-group mb-2">
                                    <span class="input-group-text w-25">Username</span>
                                    <input class="form-control" type="text" name="username" required>
                                </div>

                                <div class="input-group mb-2">
                                    <span class="input-group-text w-25">Default Password</span>
                                    <input class="form-control" type="text" name="password" required>
                                </div>

                                <div class="input-group mb-2">
                                    <label class="input-group-text w-25">Office</label>
                                    <select class="form-select" name="office" required>
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button class="btn btn-danger ms-auto" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal">Create Account</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="tab-offices" role="tabpanel" aria-labelledby="tab-offices" tabindex="0">
                            <form class="flex-column d-flex" method="post" action="{{ route('create-office') }}" id="form-offices">
                                @csrf

                                <div class="input-group mb-2">
                                    <span class="input-group-text w-25">Office Name</span>
                                    <input class="form-control" type="text" name="office-name" required>
                                </div>

                                <button class="btn btn-danger ms-auto" type="button" data-bs-toggle="modal" data-bs-target="#confirmOffice">Create Office</button>
                            </form>
                        </div>
                    </div>

                    <h5 class="text-secondary-emphasis">Accounts</h5>
                    <hr class="border-2">

                    <input class="form-control w-25 mb-2 ms-auto" type="search" id="office-search" placeholder="Search...">

                    <div class="list-group">
                        <div class="accordion" id="office-list">
                            @foreach ($offices as $office)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $office->id }}" aria-expanded="false" aria-controls="1">
                                            {{ $office->office_name }}
                                        </button>
                                    </h2>

                                    <div class="accordion-collapse collapse" data-bs-parent="#office-list" id="{{ $office->id }}">
                                        <div class="accordion-body d-flex flex-column gap-3">
                                            @foreach ($office->users as $user)
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 me-auto">{{ $user->username }}</p>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-primary">View</button>
                                                        <button class="btn btn-danger">Delete</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal" role="dialog" tabindex="-1" aria-labelledby="confirmModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Confirm?</h1>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to create the account?
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" onclick="submitAccount()">Proceed</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmOffice" role="dialog" tabindex="-1" aria-labelledby="confirmOffice" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Confirm?</h1>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to create office?
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" onclick="submitOffice()">Proceed</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        
        @if (session("success-complaint"))
            <script>
                document.addEventListener("DOMContentLoaded", event => {
                    document.getElementById('btn-pending').click();
                });
            </script>
        @endif

        @if (session("success-create"))
            <script>
                document.addEventListener("DOMContentLoaded", event => {
                    document.getElementById('btn-management').click();
                });
            </script>
        @endif

        <script>
            const triggerTablist = document.querySelectorAll('#nav button');

            triggerTablist.forEach(triggerEl => {
                const tabTrigger = new bootstrap.Tab(triggerEl);

                triggerEl.addEventListener('click', event => {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });

            function submitAccount()
            {
                document.getElementById('form-accounts').submit();
            }

            function submitOffice()
            {
                document.getElementById('form-offices').submit();
            }
        </script>
    </body>
</html>