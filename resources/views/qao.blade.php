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

    <body class="bg-light vh-100 d-flex">
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
                            <span class="badge">{{ $pending }}</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex" id="btn-closed" data-bs-toggle="pill" data-bs-target="#tab-closed" type="button" role="tab" aria-controls="btn-closed" aria-selected="false">
                            <i class="bi-file-earmark-check-fill me-2"></i>Processing
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex" id="btn-archived" data-bs-toggle="pill" data-bs-target="#tab-archived" type="button" role="tab" aria-controls="btn-archived" aria-selected="false">
                            <i class="bi-archive-fill me-2"></i>Archived
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

            <div class="col-9 tab-content p-3 h-100" id="tabContent">
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
                            <a href="qao/complaint/{{ $complaint->id }}" class="list-group-item" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $complaint->complaint_type }}</h5>
                                    <small>{{ $complaint->created_at->diffForHumans() }}</small>
                                </div>

                                <p class="mb-2">{{ $complaint->details }}</p>
                                <small class="text-secondary" style="font-size: 12px;">
                                    <h6>
                                        @if ($complaint->status === 0)
                                            <span class="badge text-bg-primary rounded-pill">Pending</span>
                                        @endif
                                    </h6>
                                </small>
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <div class="tab-pane fade flex-column" id="tab-closed" role="tabpanel" aria-labelledby="btn-closed" tabindex="0">
                    <h5 class="text-secondary-emphasis">Closed Cases</h5>
                    <hr class="border-2">
                </div>
                
                <div class="tab-pane fade flex-column" id="tab-archived" role="tabpanel" aria-labelledby="btn-archived" tabindex="0">
                    <h5 class="text-secondary-emphasis">Archived Cases</h5>
                    <hr class="border-2">
                </div>
                
                <div class="tab-pane fade flex-column" id="tab-management" role="tabpanel" aria-labelledby="btn-management" tabindex="0">
                    <h5 class="text-secondary-emphasis">Account Management</h5>
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
                            <form method="post">
                                @csrf

                                <div class="input-group mb-2">
                                    <span class="input-group-text w-25">Username</span>
                                    <input class="form-control" type="text">
                                </div>

                                <div class="input-group mb-2">
                                    <span class="input-group-text w-25">Default Password</span>
                                    <input class="form-control" type="text">
                                </div>

                                <div class="input-group mb-2">
                                    <label class="input-group-text w-25" for="office">Office</label>
                                    <select class="form-select" name="office">
                                        @foreach ($offices as $office)
                                            <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <input class="btn btn-danger" type="submit" value="Create Account">
                            </form>
                        </div>

                        <div class="tab-pane fade" id="tab-offices" role="tabpanel" aria-labelledby="tab-offices" tabindex="0">
                            <form method="post">
                                @csrf

                                <div class="input-group mb-2">
                                    <span class="input-group-text w-25">Office Name</span>
                                    <input class="form-control" type="text">
                                </div>

                                <input class="btn btn-danger" type="submit" value="Create Office">
                            </form>
                        </div>
                    </div>

                    <h5 class="text-secondary-emphasis">Accounts</h5>
                    <hr class="border-2">

                    <div class="accordion" id="office-list">
                        @foreach ($offices as $office)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#1" aria-expanded="false" aria-controls="1">
                                        {{ $office->office_name }}
                                    </button>
                                </h2>

                                <div class="accordion-collapse collapse" data-bs-parent="#office-list" id="1">
                                    <div class="accordion-body">
                                        @foreach ($office->users as $user)
                                            {{ $user->username }}
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        
        <script>
            const triggerTablist = document.querySelectorAll('#nav button');

            triggerTablist.forEach(triggerEl => {
                const tabTrigger = new bootstrap.Tab(triggerEl);

                triggerEl.addEventListener('click', event => {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });
        </script>
    </body>
</html>