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
                    <h4 class="text-light m-0 fs-6">Quality Management System Office</h4>
                </div>
                
                <hr class="border-light border-2">

                <ul class="nav nav-pills nav-fill flex-column mb-auto gap-2" role="tablist" id="nav">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex align-items-center active" id="btn-tab" data-bs-toggle="pill" data-bs-target="#tab-tab" type="button" role="tab" aria-controls="btn-tab" aria-selected="false">
                            <div class="me-auto">    
                                <i class="bi-file-earmark-check-fill me-2"></i>Complaints
                            </div>
                            <span class="badge"></span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex align-items-center" id="btn-mon" data-bs-toggle="pill" data-bs-target="#tab-mon" type="button" role="tab" aria-controls="btn-mon" aria-selected="false">
                            <div class="me-auto">    
                                <i class="bi-eye-fill me-2"></i>Monitored
                            </div>
                            <span class="badge"></span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link bg-danger text-light d-flex" id="btn-complaint" data-bs-toggle="pill" data-bs-target="#tab-archive" type="button" role="tab" aria-controls="btn-archive" aria-selected="false">
                            <i class="bi-archive-fill me-2"></i>Archive
                        </button>
                    </li>

                    <hr class="border-light border-2">

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
                <div class="tab-pane flex-column active" id="tab-tab" role="tabpanel" aria-labelledby="btn-tab" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Complaints</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search" placeholder="Search..." onkeyup="search_complaint(1)" id="search-pending">
                    </div>

                    <hr class="border-2">

                    <div class="list-group" id="complaints-pending">
                        @php
                            $pendingComplaints = $complaints->filter(function($complaint) {
                                return $complaint->phase === 3 && $complaint->is_monitored != true;
                            });
                        @endphp

                        @if ($pendingComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">No submitted complaints yet!</p>
                        @else
                            @foreach ($complaints as $complaint)
                                @if ($complaint->phase === 3 && $complaint->is_monitored != true)
                                    <a href="/corrective/{{ $complaint->id }}" class="list-group-item complaint-link" data-toggle="tab" aria-current="true" data-id="{{ $complaint->id }}">
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

                <div class="tab-pane flex-column" id="tab-mon" role="tabpanel" aria-labelledby="btn-mon" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Monitored</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search" placeholder="Search..." onkeyup="search_complaint(1)" id="search-pending">
                    </div>

                    <hr class="border-2">

                    <div class="list-group" id="complaints-pending">
                        @php
                            $pendingComplaints = $complaints->filter(function($complaint) {
                                return $complaint->phase === 3 && $complaint->is_monitored && $complaint->is_closed != true;
                            });
                        @endphp

                        @if ($pendingComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">No monitored complaints yet!</p>
                        @else
                            @foreach ($complaints as $complaint)
                                @if ($complaint->phase === 3 && $complaint->is_monitored)
                                    <a href="corrective/{{$complaint->id}}" class="list-group-item complaint-link" data-toggle="tab" aria-current="true" data-id="{{ $complaint->id }}">
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
                                                    @case(true)
                                                        <span class="badge text-bg-danger rounded-pill">Monitored</span>
                                                        @break
                                                    @case(false)
                                                        <span class="badge text-bg-success text-white rounded-pill">Pending</span>
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

                <div class="tab-pane flex-column" id="tab-archive" role="tabpanel" aria-labelledby="btn-archive" tabindex="0">
                    <div class="d-flex align-items-center">
                        <h5 class="text-secondary-emphasis m-0">Archived Cases</h5>
                        <input class="form-control w-25 ms-auto" type="search" name="search" placeholder="Search..." onkeyup="search_complaint(1)" id="search-pending">
                    </div>

                    <hr class="border-2">

                    <div class="list-group" id="complaints-pending">
                        @php
                            $pendingComplaints = $complaints->filter(function($complaint) {
                                return $complaint->is_closed;
                            });
                        @endphp

                        @if ($pendingComplaints->isEmpty())
                            <p class="text-center text-secondary m-0">No monitored complaints yet!</p>
                        @else
                            @foreach ($complaints as $complaint)
                                <a href="corrective/{{$complaint->id}}" class="list-group-item complaint-link" data-toggle="tab" aria-current="true" data-id="{{ $complaint->id }}">
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
                                            <span class="badge text-bg-danger rounded-pill">Closed</span>
                                        </h6>
                                    </small>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="tab-pane flex-column" id="tab-profile" role="tabpanel" aria-labelledby="btn-profile" tabindex="0">
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

        <div class="modal fade" id="notifications" role="dialog" tabindex="-1" aria-labelledby="notifications" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="userModalName">Notification!</h1>
                    </div>

                    <div class="modal-body">
                        There are <span class="fw-bold">{{ $new_complaints->count() }}</span> new complaints. <br>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @if ($seen)
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var modal = new bootstrap.Modal(document.getElementById("notifications"), {});
                    document.onreadystatechange = function () {
                        modal.show();
                    };
                });
            </script>
        @endif

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
        <!-- <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.complaint-link').forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();

                        const complaintId = this.getAttribute('data-id');

                        $.ajax({
                            url: '/corrective/' + complaintId,
                            method: 'GET',
                            success: function (data) {
                                document.getElementById('view-complaint-form').href = '/complaint/form/print/' + complaintId;
                                document.getElementById('status').action = '/open-close/' + complaintId;
                                document.getElementById('monitor').action = '/monitor/' + complaintId;
                                displayCorrectiveActions(data.corrective);
                            }
                        });

                        // Function to create and append corrective action elements
                        function displayCorrectiveActions(correctiveActions) {
                            const container = document.getElementById("corrective_action"); 

                            correctiveActions.forEach((action, index) => {
                                const actionContainer = document.createElement("div");
                                actionContainer.className = "container-fluid d-flex flex-column gap-2 bg-white p-2 rounded-1";
                                actionContainer.id = `corrective_action_${index + 1}`;

                                const labelCorrectiveAction = document.createElement("label");
                                labelCorrectiveAction.className = "form-label";
                                labelCorrectiveAction.textContent = "Corrective Action";

                                const textareaCorrectiveAction = document.createElement("textarea");
                                textareaCorrectiveAction.className = "form-control";
                                textareaCorrectiveAction.style.resize = "none";
                                textareaCorrectiveAction.rows = "12";
                                textareaCorrectiveAction.name = `corrective_action_${index + 1}`;
                                textareaCorrectiveAction.disabled = true;
                                textareaCorrectiveAction.textContent = action.corrective_action;

                                actionContainer.appendChild(labelCorrectiveAction);
                                actionContainer.appendChild(textareaCorrectiveAction);

                                const rowContainer = document.createElement("div");
                                rowContainer.className = "row";

                                const col1 = document.createElement("div");
                                col1.className = "col";

                                const col2 = document.createElement("div");
                                col2.className = "col d-flex flex-column gap-2";

                                col2.appendChild(createInputGroup("Implementation Date", "date", action.implementation_date, `corrective_date_${index + 1}`));
                                col2.appendChild(createInputGroup("Effectiveness", "text", action.effectiveness, `corrective_effect_${index + 1}`));
                                col2.appendChild(createInputGroup("Monitoring Period", "text", action.period, `corrective_period_${index + 1}`));
                                col2.appendChild(createInputGroup("Responsible", "text", action.responsible, `corrective_responsible_${index + 1}`));

                                rowContainer.appendChild(col1);
                                rowContainer.appendChild(col2);
                                actionContainer.appendChild(rowContainer);

                                const commentContainer = document.createElement("div");
                                commentContainer.className = "d-flex flex-column";

                                const labelComment = document.createElement("label");
                                labelComment.textContent = "Comment";

                                const textareaComment = document.createElement("textarea");
                                textareaComment.className = "form-control";
                                textareaComment.name = `feedback_${index + 1}`;
                                textareaComment.id = `feedback_${index + 1}`;

                                commentContainer.appendChild(labelComment);
                                commentContainer.appendChild(textareaComment);
                                actionContainer.appendChild(commentContainer);

                                container.appendChild(actionContainer);
                            });
                        }

                        // Helper function to create labeled input groups
                        function createInputGroup(labelText, inputType, inputValue, inputName) {
                            const formGroup = document.createElement("div");
                            formGroup.className = "form-group";

                            const label = document.createElement("label");
                            label.className = "form-label";
                            label.textContent = labelText;

                            const input = document.createElement("input");
                            input.className = "form-control";
                            input.type = inputType;
                            input.name = inputName;
                            input.disabled = true;
                            input.value = inputValue || "";

                            formGroup.appendChild(label);
                            formGroup.appendChild(input);

                            return formGroup;
                        }

                        const complaintTab = document.getElementById('btn-complaint');
                        complaintTab.click();
                    });
                });
            });
        </script> -->
    </body>
</html>