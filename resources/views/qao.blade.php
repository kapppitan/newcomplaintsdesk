<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

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
                        <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-pending" data-bs-toggle="pill" data-bs-target="#tab-pending" type="button" role="tab" aria-controls="btn-pending" aria-selected="false">
                            <div class="me-auto">
                                <i class="bi-inbox-fill me-2"></i>Pending
                            </div>
                            <span class="badge">
                                @if ($pending > 0)
                                    {{ App\Models\Complaints::where('status', 0)->count() }}
                                @endif
                            </span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-processing" data-bs-toggle="pill" data-bs-target="#tab-processing" type="button" role="tab" aria-controls="btn-processing" aria-selected="false">
                            <div class="me-auto">    
                                <i class="bi-file-earmark-check-fill me-2"></i>Processing
                            </div>
                            <span class="badge">
                                @if ($processing > 0)
                                    {{ App\Models\Complaints::where('status', 1)->count() }}
                                @endif
                            </span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-non" data-bs-toggle="pill" data-bs-target="#tab-non" type="button" role="tab" aria-controls="btn-non" aria-selected="false">
                            <div class="me-auto">    
                                <i class="bi-envelope-slash-fill me-2"></i>Non-Conformity
                            </div>
                            <span class="badge">
                                @if ($processing > 0)
                                    {{ App\Models\Complaints::where('status', 2)->count() }}
                                @endif
                            </span>
                        </button>
                    </li>

                    <hr class="border-light border-2">

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
                <div class="tab-pane flex-column show active gap-2" id="tab-overview" role="tabpanel" aria-labelledby="btn-overview" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Dashboard</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search" placeholder="Search..." onkeyup="search_complaint(1)" id="search-pending">
                    </div>    
                    
                    <hr class="border-2">

                    <div class="container text-center d-flex flex-column gap-4 mb-5">
                        <div class="row d-flex gap-2">
                            <div class="col">
                                <p class="fw-bold py-2 m-0 bg-danger text-white rounded-top">Slow Service</p>
                                <div class="d-flex py-2 bg-white rounded-bottom">
                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Processing</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 1)->where('status', 1)->count() }}</p>
                                    </div>

                                    <div class="vr"></div>

                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Closed</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 1)->where('status', 4)->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <p class="fw-bold py-2 m-0 bg-danger text-white rounded-top">Unruly/Disrespectful Personnel</p>
                                <div class="d-flex py-2 bg-white rounded-bottom">
                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Processing</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 2)->where('status', 1)->count() }}</p>
                                    </div>

                                    <div class="vr"></div>

                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Closed</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 2)->where('status', 4)->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <p class="fw-bold py-2 m-0 bg-danger text-white rounded-top">No Response</p>
                                <div class="d-flex py-2 bg-white rounded-bottom">
                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Processing</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 3)->where('status', 1)->count() }}</p>
                                    </div>

                                    <div class="vr"></div>

                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Closed</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 3)->where('status', 4)->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex gap-2">
                            <div class="col">
                                <p class="fw-bold py-2 m-0 bg-danger text-white rounded-top">Errors on Request</p>
                                <div class="d-flex py-2 bg-white rounded-bottom">
                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Processing</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 4)->where('status', 1)->count() }}</p>
                                    </div>

                                    <div class="vr"></div>

                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Closed</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 4)->where('status', 4)->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <p class="fw-bold py-2 m-0 bg-danger text-white rounded-top">Delayed Issuance of Request</p>
                                <div class="d-flex py-2 bg-white rounded-bottom">
                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Processing</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 5)->where('status', 1)->count() }}</p>
                                    </div>

                                    <div class="vr"></div>

                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Closed</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 5)->where('status', 4)->count() }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <p class="fw-bold py-2 m-0 bg-danger text-white rounded-top">Others</p>
                                <div class="d-flex py-2 bg-white rounded-bottom">
                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Processing</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 6)->where('status', 1)->count() }}</p>
                                    </div>

                                    <div class="vr"></div>

                                    <div class="d-flex flex-column w-50 py-3">
                                        <p class="fw-bold m-0">Closed</p>
                                        <p class="m-0">{{ App\Models\Complaints::where('complaint_type', 6)->where('status', 4)->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="w-50">Office</th>
                                <th class="text-center">Open</th>
                                <th class="text-center">Closed</th>
                                <th class="text-center">Total No. of Complaints</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($offices as $office)
                                <tr>
                                    <td class="w-50">{{ $office->office_name }}</td>
                                    <td class="text-center">{{ App\Models\Complaints::where('office_id', $office->id)->count() }}</td>
                                    <td class="text-center">{{ App\Models\Complaints::where('office_id', $office->id)->count() }}</td>
                                    <td class="text-center">{{ App\Models\Complaints::where('office_id', $office->id)->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="tab-pane flex-column" id="tab-pending" role="tabpanel" aria-labelledby="btn-pending" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Pending Cases</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search" placeholder="Search..." onkeyup="search_complaint(1)" id="search-pending">
                    </div>
                    
                    <hr class="border-2">

                    <div class="list-group" id="complaints-pending">
                        @php
                            $pendingComplaints = $complaints->filter(function($complaint) {
                                return $complaint->status == 0 || $complaint->status == 3;
                            });
                        @endphp

                        @if ($pendingComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">No pending complaints!</p>
                        @else
                            @foreach ($complaints as $complaint)
                                @if ($complaint->status === 0 or $complaint->status === 3)
                                    <a href="complaint/{{ $complaint->id }}" class="list-group-item complaint-link" data-toggle="tab" aria-current="true" data-id="{{ $complaint->id }}">
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
                                                @switch ($complaint->status)
                                                    @case(0)
                                                        <span class="badge text-bg-primary rounded-pill">Pending</span>
                                                        @break
                                                    @case(3)
                                                        <span class="badge text-bg-info text-white rounded-pill">Inquiry</span>
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
                
                <div class="tab-pane flex-column" id="tab-processing" role="tabpanel" aria-labelledby="btn-processing" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Processing Cases</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search-processing" placeholder="Search..." onkeyup="search_complaint(2)" id="search-processing">
                    </div>
    
                    <hr class="border-2">

                    <div class="list-group h-100" id="complaints-processing">
                        @php
                            $processingComplaints = $tcomplaints->filter(function($complaint) {
                                return ($complaint->status > 0 && $complaint->status < 4 && $complaint->status != 2);
                            });
                        @endphp

                        @if ($processingComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">No processed complaints!</p>
                        @else
                            @foreach ($tcomplaints as $complaint)
                                @if ($complaint->status > 0 && $complaint->status < 3 && $complaint->status != 2)
                                    <a href="complaint/{{ $complaint->id }}" class="list-group-item complaint-link" aria-current="true" data-id="{{ $complaint->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">
                                                <span class="text-secondary">#{{ $complaint->ticket->ticket_number }}</span>
                                                {{ \Illuminate\Support\Str::limit($complaint->details, 70, $end = "...") }}
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
                                                        <span class="badge text-bg-info text-white rounded-pill">Inquiry</span>
                                                        @break
                                                @endswitch

                                                @switch ($complaint->phase)
                                                    @case(1)
                                                        <span class="badge text-bg-warning text-white rounded-pill">Delivered</span>
                                                        @break
                                                    @case(2)
                                                        <span class="badge text-bg-danger rounded-pill">Returned</span>
                                                        @break
                                                    @case(3)
                                                        <span class="badge text-bg-info text-white rounded-pill">Submitted</span>
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
                
                <div class="tab-pane flex-column" id="tab-archived" role="tabpanel" aria-labelledby="btn-archived" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Archived Cases</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search-archived" placeholder="Search..." onkeyup="search_complaint(3)" id="search-archive">
                    </div>

                    <hr class="border-2">

                    <div class="list-group" id="complaints-archive">
                        @php
                            $archivedComplaints = $complaints->filter(function($complaint) {
                                return ($complaint->status == 4);
                            });
                        @endphp

                        @if ($archivedComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">No archived complaints!</p>
                        @else
                            @foreach ($complaints as $complaint)
                                @if ($complaint->status === 4)
                                    <a href="complaint/{{ $complaint->id }}" class="list-group-item complaint-link" aria-current="true" data-id="{{ $complaint->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ \Illuminate\Support\Str::limit($complaint->details, 70, $end = "...") }}</h5>
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
                        @endif
                    </div>
                </div>

                <div class="tab-pane flex-column" id="tab-non" role="tabpanel" aria-labelledby="btn-non" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Non-Conformity Cases</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search-non" placeholder="Search..." onkeyup="search_complaint(4)" id="search-non">
                    </div>

                    <hr class="border-2">

                    <div class="list-group" id="complaints-archive">
                        @php
                            $archivedComplaints = $complaints->filter(function($complaint) {
                                return ($complaint->status == 2);
                            });
                        @endphp

                        @if ($archivedComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">No non-conforming complaints!</p>
                        @else
                            @foreach ($complaints as $complaint)
                                @if ($complaint->status === 2)
                                    <a href="complaint/{{ $complaint->id }}" class="list-group-item complaint-link" aria-current="true" data-id="{{ $complaint->id }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ \Illuminate\Support\Str::limit($complaint->details, 70, $end = "...") }}</h5>
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
                                            <h6><span class="badge text-bg-danger rounded-pill">Non-Conforming</span></h6>
                                        </small>
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <div class="tab-pane flex-column" id="tab-management" role="tabpanel" aria-labelledby="btn-management" tabindex="0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Accounts</h5>

                        <div class="d-flex gap-2">
                            <button class="btn btn-danger" onclick="showOffice()">Create Office</button>
                            <button class="btn btn-danger" onclick="showAccount()">Create Account</button>
                        </div>
                    </div>

                    <hr class="border-2">

                    <div class="list-group mb-5">
                        <div class="accordion" id="office-list">
                            @foreach ($offices as $office)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed d-flex justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $office->id }}" aria-expanded="false" aria-controls="1">
                                            {{ $office->office_name }}
                                        </button>
                                    </h2>

                                    <div class="accordion-collapse collapse" data-bs-parent="#office-list" id="{{ $office->id }}">
                                        <div class="accordion-body d-flex flex-column gap-3">
                                            @foreach ($office->users as $index => $user)
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 me-auto">{{ $user->name }}</p>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-primary view-user-btn" onclick="viewUser()" data-id="{{ $user->id }}">View</button>
                                                        <button class="btn btn-danger">Delete</button>
                                                    </div>
                                                </div>

                                                @if ($index !== $loop->count - 1)
                                                    <hr class="m-0">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <h5 class="text-secondary-emphasis m-0 mt-6">Activity Log</h5>
                    <hr class="border-2">
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
                            
                                <form class="input-group" method="post" id="complaint-form">
                                    @csrf

                                    <select class="form-select rounded-start" name="cstatus" id="cstatus">
                                        <option value="default" selected disabled>Status</option>
                                        <option value="1">Legitimate</option>
                                        <option value="2">Non-conformity</option>
                                        <option value="3">Inquiry</option>
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

        <div class="modal fade" id="filesModal" tabindex="-1" aria-labelledby="filesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filesModalLabel">Attached File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <img src="" style="width: 100%;" id="cevidence">
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createAccount" role="dialog" tabindex="-1" aria-labelledby="createAccount" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Create Account</h1>
                    </div>

                    <form class="d-flex flex-column gap-2 modal-body" method="post" action="{{ route('create-account') }}" id="createAccountForm">
                        @csrf

                        <div class="d-flex flex-column">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control" style="text-transform: capitalize;" type="text" name="username" id="username" required>
                        </div>

                        <div class="d-flex flex-column">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" style="text-transform: capitalize;" type="text" name="name" id="name" required>
                        </div>

                        <div class="d-flex flex-column">
                            <label class="form-label" for="password">Default Password</label>
                            <input class="form-control" type="text" name="password" id="password" required>
                        </div>

                        <div class="d-flex flex-column">
                            <label class="form-label" for="office">Office</label>
                            <select class="form-select" name="office" id="office" required>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmModal">Create</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

        <div class="modal fade" id="createOffice" role="dialog" tabindex="-1" aria-labelledby="createOffice" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Create Office</h1>
                    </div>

                    <form class="d-flex flex-column gap-2 modal-body" method="post" action="{{ route('create-office') }}" id="createOfficeForm">
                        @csrf

                        <div class="d-flex flex-column">
                            <label class="form-label" for="office-name">Office</label>
                            <input class="form-control" type="text" name="office-name" id="office-name">
                        </div>
                    </form>

                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#confirmOffice">Create</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

        <div class="modal fade" id="viewUser" role="dialog" tabindex="-1" aria-labelledby="viewUser" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="userModalName">Username</h1>
                    </div>

                    <div class="modal-body">
                        <div class="d-flex justify-content-between">
                            <span class="fw-medium">Office:</span>
                            <p id="userOfficeName"></p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="fw-medium">Created at:</span>
                            <p id="userCreatedOn"></p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="fw-medium">Last logged on:</span>
                            <p id="userLoggedOn"></p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Delete</button>
                        <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="notifications" role="dialog" tabindex="-1" aria-labelledby="notifications" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="userModalName">Notification!</h1>
                    </div>

                    <div class="modal-body">
                        There are <span class="fw-bold">{{ $new_complaints->count() }}</span> new complaints.
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

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

            function showAccount()
            {
                var modal = new bootstrap.Modal(document.getElementById("createAccount"));
                modal.show();
            }

            function submitAccount()
            {
                let x = document.forms['createAccountForm']['username'].value;
                let y = document.forms['createAccountForm']['password'].value;
                let z = document.forms['createAccountForm']['office'].value;

                if (x != '' && y != '' && z != '') {
                    document.getElementById('createAccountForm').submit();
                } else {
                    alert('Missing required input.');
                }
            }

            function showOffice()
            {
                var modal = new bootstrap.Modal(document.getElementById("createOffice"));
                modal.show();
            }

            function submitOffice()
            {
                let x = document.forms['createOfficeForm']['office-name'].value;

                if (x != '') {
                    document.getElementById('createOfficeForm').submit();
                } else {
                    alert('Missing required input.');
                }
            }

            function search_complaint(mode) 
            {
                switch (mode) {
                    case 1:
                        var input = document.getElementById('search-pending');
                        var filter = input.value.toUpperCase();
                        var list = document.getElementById('complaints-pending').getElementsByTagName('a');

                        for (var i = 0; i < list.length; i++) {
                            var item = list[i];
                            var content = item.textContent || item.innerText;

                            if (content.toUpperCase().indexOf(filter) > -1) {
                                list[i].style.display = "";
                            } else {
                                list[i].style.display = "none";
                            }
                        }
                        break;
                    case 2:
                        var input = document.getElementById('search-processing');
                        var filter = input.value.toUpperCase();
                        var list = document.getElementById('complaints-processing').getElementsByTagName('a');

                        for (var i = 0; i < list.length; i++) {
                            var item = list[i];
                            var content = item.textContent || item.innerText;

                            if (content.toUpperCase().indexOf(filter) > -1) {
                                list[i].style.display = "";
                            } else {
                                list[i].style.display = "none";
                            }
                        }
                        break;
                    case 3:
                        var input = document.getElementById('search-archive');
                        var filter = input.value.toUpperCase();
                        var list = document.getElementById('complaints-archive').getElementsByTagName('a');

                        for (var i = 0; i < list.length; i++) {
                            var item = list[i];
                            var content = item.textContent || item.innerText;

                            if (content.toUpperCase().indexOf(filter) > -1) {
                                list[i].style.display = "";
                            } else {
                                list[i].style.display = "none";
                            }
                        }
                        break;
                    default:
                        break;
                }  
            }

            function viewUser() 
            {
                var modal = new bootstrap.Modal(document.getElementById("viewUser"));
                modal.show();
            }

            $('.view-user-btn').on('click', function () {
                var userId = $(this).data('id');

                $.ajax({
                    url: '/user/' + userId,
                    method: 'GET',
                    success: function(data) {
                        let createdDate = new Date(data.user.created_at);
                        let formattedCreatedDate = createdDate.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                        });

                        let loggedDate = new Date(data.user.last_activity);
                        let formattedLoggedDate = loggedDate.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                        });

                        $('#userModalName').text(data.user.username);
                        $('#userOfficeName').text(data.office.office_name);
                        $('#userCreatedOn').text(formattedCreatedDate);
                        $('#userLoggedOn').text(formattedLoggedDate);

                        $('#userModal').modal('show');
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.complaint-link').forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();

                        const complaintId = this.getAttribute('data-id');

                        $.ajax({
                            url: '/complaint/' + complaintId,
                            method: 'GET',
                            success: function (data) {
                                let specificDate = new Date(data.created_at);
                                let formattedSpecificDate = specificDate.toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                });

                                $('#complaint-form').attr('action', "{{ url('update-status'), '' }}/" + complaintId);
                                $('#csub').text(formattedSpecificDate);
                                $('#cago').html(`(${data.ago})`);
                                $('#cdetails').text(data.details);

                                if (data.status) {
                                    $('#cstatus').val(data.status);
                                } else {
                                    $('#cstatus').val('default');
                                }

                                $('#coffice').val(data.office.office_name);
                                $('#cname').val(data.name);
                                $('#ctype').val(data.type);
                                $('#cemail').val(data.email);
                                $('#cnumber').val(data.number);
                                $('#cevidence').attr('src', "{{ Storage::url('') }}" + data.evidence);
                                

                                if (data.status == 0) {
                                    $('#btn-memo').prop('disabled', true);
                                    $('#btn-ccf').prop('disabled', true);
                                } else {
                                    $('#btn-memo').prop('disabled', false);
                                    if (data.has_memo) {
                                        $('#btn-ccf').prop('disabled', false);
                                    } else {
                                        $('#btn-ccf').prop('disabled', true);
                                    }
                                }

                                $('#btn-memo').on('click', function () {
                                    window.location.href = 'complaint/memo/' + complaintId;
                                });

                                $('#btn-ccf').on('click', function () {
                                    window.location.href = 'complaint/form/' + complaintId;
                                });

                                const complaintTab = document.getElementById('btn-complaint');
                                complaintTab.click();
                            },
                            error: function (xhr) {
                                console.error('Error: ', xhr.responseText);
                            }
                        });
                    });
                });
            });
        
            function showFiles() 
            {
                $('#filesModal').modal('show');
            }
        </script>
    </body>
</html>