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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <div class="row w-100 m-0">
            <div class="col-2 bg-danger p-0 d-flex flex-column">
                <div class="p-3 d-flex flex-column h-100">
                    <h4 class="m-0 text-light fs-5">{{ $office->office_name }}</h4>
                    <hr class="border-light border-2">

                    <ul class="nav nav-pills nav-fill flex-column mb-auto gap-2" role="tablist" id="nav">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-danger text-light d-flex active" id="btn-overview" data-bs-toggle="pill" data-bs-target="#tab-overview" type="button" role="tab" aria-controls="btn-overview" aria-selected="true">
                                <i class="bi-speedometer me-2"></i>Dashboard
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-inbox" data-bs-toggle="pill" data-bs-target="#tab-inbox" type="button" role="tab" aria-controls="btn-inbox" aria-selected="false">
                                <div class="me-auto">
                                    <i class="bi-inbox-fill me-2"></i>Inbox
                                </div>
                                <span class="badge">{{ $inbox->count() > 0 ? $inbox->count() : '' }}</span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-sent" data-bs-toggle="pill" data-bs-target="#tab-sent" type="button" role="tab" aria-controls="btn-sent" aria-selected="false">
                                <div class="me-auto">
                                    <i class="bi-eye-fill me-2"></i>Monitored
                                </div>    
                                <span class="badge">{{ $outbox->count() > 0 ? $outbox->count() : '' }}</span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link bg-danger text-light d-flex" id="btn-profile" data-bs-toggle="pill" data-bs-target="#tab-profile" type="button" role="tab" aria-controls="btn-profile" aria-selected="false">
                                <i class="bi-person-circle me-2"></i>Profile
                            </button>
                        </li>
                    </ul>

                    <hr class="border-light border-2">

                    <span class="text-light mb-2" style="font-size: small;"><span class="fw-bold">Logged in as:</span> {{ Auth::user()->name }}</span>

                    <a class="btn btn-danger d-flex border-0 px-3 py-2" href="/logout">
                      <i class="bi-box-arrow-left me-2"></i>Logout
                    </a>
                </div>
            </div>

            <div class="col-10 tab-content p-3 h-100 overflow-scroll overflow-x-hidden" id="tabContent">
                <div class="tab-pane flex-column show active" id="tab-overview" role="tabpanel" aria-labelledby="btn-overview" tabindex="0">
                    <h5 class="text-secondary-emphasis">Overview</h5>
                    <hr class="border-2">

                    <div class="d-flex flex-column mb-5">
                        <!-- <select class="form-select align-self-end w-25" id="filter">
                            <option value="0">All</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select> -->

                        <canvas id="myChart"></canvas>
                    </div>

                    <div class="container text-center d-flex flex-column gap-4 mb-5">
                        <div class="container-fluid d-flex flex-column">
                            <p class="fw-bold py-2 m-0 bg-danger text-white rounded-top">Overall Complaints</p>
                            <div class="d-flex py-2 bg-white rounded-bottom">
                                <div class="d-flex flex-column w-50 py-3">
                                    <p class="fw-bold m-0">Processing</p>
                                    <p class="m-0">{{ App\Models\Complaints::where('office_id', Auth::user()->office_id)->where('status', 1)->count() }}</p>
                                </div>

                                <div class="vr"></div>

                                <div class="d-flex flex-column w-50 py-3">
                                    <p class="fw-bold m-0">Monitored</p>
                                    <p class="m-0">{{ App\Models\Complaints::where('office_id', Auth::user()->office_id)->where('status', 2)->count() }}</p>
                                </div>

                                <div class="vr"></div>

                                <div class="d-flex flex-column w-50 py-3">
                                    <p class="fw-bold m-0">Closed</p>
                                    <p class="m-0">0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane flex-column show" id="tab-inbox" role="tabpanel" aria-labelledby="btn-inbox" tabindex="0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0 text-secondary-emphasis">Inbox</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search-inbox" placeholder="Search..." onkeyup="search(1)" id="search-inbox">
                    </div>

                    <hr class="border-2">

                    <div class="list-group" id="complaints-inbox">
                        @php
                            $inboxComplaints = $complaints->filter(function($complaint) {
                                return $complaint->phase == 1;
                            });
                        @endphp

                        @if ($inboxComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">Inbox is empty.</p>
                        @else
                            @foreach ($complaints as $complaint)
                                @if ($complaint->phase == 1)
                                    <a href="/complaint/form/{{ $complaint->id }}" class="list-group-item" aria-current="true">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ \Illuminate\Support\Str::limit($complaint->details, 70, $end = "...") }}</h5>
                                            <small class="text-secondary">{{ $complaint->updated_at->diffForHumans() }}</small>
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
                                                    @case(1)
                                                        <span class="badge text-bg-success rounded-pill">Processing</span>
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

                <div class="tab-pane flex-column show" id="tab-sent" role="tabpanel" aria-labelledby="btn-sent" tabindex="0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="m-0 text-secondary-emphasis">Monitored Cases</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search-outbox" placeholder="Search..." onkeyup="search(2)" id="search-outbox">
                    </div>

                    <hr class="border-2">

                    <div class="list-group" id="complaints-outbox">
                        @php
                            $outboxComplaints = $complaints->filter(function($complaint) {
                                return $complaint->is_monitored;
                            });
                        @endphp

                        @if ($outboxComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">There are no monitored cases at the moment.</p>
                        @else
                            @foreach ($complaints as $complaint)
                                @if ($complaint->is_monitored)
                                    <a href="/corrective/{{ $complaint->id }}" class="list-group-item" aria-current="true">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ \Illuminate\Support\Str::limit($complaint->details, 70, $end = "...") }}</h5>
                                            <small class="text-secondary">{{ $complaint->updated_at->diffForHumans() }}</small>
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
                                                <span class="badge text-bg-danger text-light rounded-pill">Monitored</span>
                                            </h6>
                                        </small>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="tab-pane flex-column show" id="tab-profile" role="tabpanel" aria-labelledby="btn-profile" tabindex="0">
                    <h5 class="text-secondary-emphasis">Profile</h5>
                    <hr class="border-2">

                    <form class="d-flex flex-column gap-2 w-75" method="post" action="{{ route('update-profile', ['id' => Auth::user()->id]) }}">
                        @csrf

                        <div class="input-group w-50">
                            <span class="input-group-text w-25">Name</span>
                            <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}">
                        </div>

                        <div class="input-group w-50">
                            <span class="input-group-text w-25">Username</span>
                            <input type="text" class="form-control" name="username" id="username" value="{{ Auth::user()->username }}">
                        </div>
                        

                        <div class="input-group w-50">
                            <span class="input-group-text w-25">Password</span>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>

                        <button class="btn btn-danger w-25" type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- <div class="modal fade" id="notifications" role="dialog" tabindex="-1" aria-labelledby="notifications" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="userModalName">Notification!</h1>
                    </div>

                    <div class="modal-body">
                        There are <span class="fw-bold">0</span> new complaints.
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> -->

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('myChart').getContext('2d');

                const lineChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($data['labels']),
                        datasets: [{
                            label: 'Sample Data',
                            data: @json($data['dataset']),
                            fill: false,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',  // Light color for bars
                            borderColor: 'rgb(75, 192, 192)',  // Border color for bars
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Months'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of Complaints'
                                }
                            }
                        }
                    }
                });
            });

            function search (mode)
            {
                switch(mode) {
                    case 1:
                        var input = document.getElementById('search-inbox');
                        var filter = input.value.toUpperCase();
                        var list = document.getElementById('complaints-inbox').getElementsByTagName('a');

                        for (var i = 0; i < list.length; i++) {
                            var item = list[i];
                            var content = item.textContent || item.innerText;

                            if (content.toUpperCase().indexOf(filter) > -1) {
                                list[i].style.display = '';
                            } else {
                                list[i].style.display = 'none';
                            }
                        }

                        break;
                }
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', event => {
                if (!sessionStorage.getItem('notificationShown')) {
                    var modal = new bootstrap.Modal(document.getElementById("notifications"));
                    modal.show();
                    sessionStorage.setItem('notificationShown', 'true');
                }
            });
        </script>
    </body>
</html>
