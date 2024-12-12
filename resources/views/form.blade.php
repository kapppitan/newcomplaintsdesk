<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <title>Customer Complaint Form</title>
    </head>

    <body class="bg-light h-100 p-3 overflow-y-scroll">
        <div class="d-flex gap-2 align-items-center justify-content-between">
            @if(Auth::user()->office_id == 1)
                <a href="/qao">Back</a>
            @elseif(Auth::user()->office_id == 2)
                <a href="/qmso">Back</a>
            @else
                <a href="/office/{{ Auth::user()->office_id }}">Back</a>
            @endif

            <h4 class="text-danger position-absolute start-50 translate-middle-x" style="top: 15px;">Customer Complaint Form</h4>
            <div class="d-flex gap-2">
                <a class="btn btn-secondary" href="/complaint/form/print/{{ $complaint->id }}">
                    <i class="bi bi-printer"></i>
                </a>

                @if ($auth->office_id != 1 && $auth->office_id != 2)
                    <a class="btn btn-primary" href="/complaint/memo/print/{{ $complaint->id }}">View Memo</a>
                @endif

                @if ($auth->office_id == 1)
                    @switch($complaint->phase)
                        @case(0)
                            <button class="btn btn-danger" onclick="confirm_form()">Forward Form</button>
                            @break
                        @case(1)
                            <button class="btn btn-danger" disabled>Submit Form</button>
                            @break
                        @case(2)
                            <button class="btn btn-danger" onclick="confirm_form()">Submit Form</button>
                            @break
                        @case(3)
                            <button class="btn btn-danger" disabled>Submit Form</button>
                            @break
                    @endswitch
                @elseif ($auth->office_id == 2)
                    <!-- None -->
                @else
                    <button class="btn btn-danger" onclick="confirm_form()">Submit Form</button>
                @endif
            </div>
        </div>

        <hr class="border-2">

        <nav class="nav nav-tabs nav-fill justify-content-center" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="complaint-btn" data-bs-toggle="tab" data-bs-target="#complaint-tab" type="button" role="tab" aria-controls="complaint-tab" aria-selected="true">Complaint</button>
            </li>
            
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="office-btn" data-bs-toggle="tab" data-bs-target="#office-tab" type="button" role="tab" aria-controls="office-tab" aria-selected="false">Office</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="qao-btn" data-bs-toggle="tab" data-bs-target="#qao-tab" type="button" role="tab" aria-controls="qao-tab" aria-selected="false">QAO</button>
            </li>
        </nav>

        <form class="tab-content bg-white" action="{{ route('submit-ccf', ['id' => $complaint->id]) }}" method="post" id="formContent">
            @csrf

            <!-- Complaint -->
            <div class="tab-pane p-3 fade show active" id="complaint-tab" role="tabpanel" aria-labelledby="complaint-tab" tabindex="0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="details">Description of complaint</label>
                            <textarea class="form-control" style="resize: none;" name="details" id="details" rows="15" {{ ($auth->office_id != 1 || $complaint->phase > 0) ? 'disabled' : '' }}>{{ $complaint->details }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-column gap-3">
                        <div class="d-flex flex-column gap-1">
                            <span>Filed By</span>
                            <div class="input-group">
                                <input class="form-control w-25" type="text" aria-label="complainant-name" value="{{ $complaint->name }}" {{ ($auth->office_id != 1 || $complaint->phase > 0) ? 'disabled' : '' }}>
                                <input class="form-control" type="date" aria-label="complainant-date" value="{{ $complaint->created_at->format('Y-m-d') }}" {{ ($auth->office_id != 1 || $complaint->phase > 0) ? 'disabled' : '' }}>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-1">
                            <span>Validated By</span>
                            <div class="input-group">
                                <select class="form-select w-25" name="validated_by" {{ ($auth->office_id != 1 || $complaint->phase > 0) ? 'disabled' : '' }}>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $complaint->validated_by ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input class="form-control" type="date" aria-label="validated-date" name="validated_on" value="{{ $complaint->date_verified->format('Y-m-d') }}" {{ ($auth->office_id != 1 || $complaint->phase > 0) ? 'disabled' : '' }}>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-1">
                            <span>Acknowledged By</span>
                            <div class="input-group">
                                <select class="form-select w-25" name="acknowledgedqao_by" {{ ($auth->office_id != 1 || $complaint->phase > 0) ? 'disabled' : '' }}>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $complaint->validated_by ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                 
                                <input 
                                    class="form-control" 
                                    type="date" 
                                    aria-label="acknowledge-date" 
                                    name="acknowledged_on" 
                                    value="{{ optional($form)->acknowledged_on ? \Carbon\Carbon::parse($form->acknowledged_on)->format('Y-m-d') : '' }}" 
                                    {{ ($auth->office_id != 1 || $complaint->phase > 0) ? 'disabled' : '' }}
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Office -->
            <div class="tab-pane p-3 fade" id="office-tab" role="tabpanel" aria-labelledby="office-tab" tabindex="0">
                <div class="d-flex flex-column gap-3 align-items-center">
                    <div class="d-flex flex-column w-75 gap-1 mt-3">
                        <label class="form-label" for="corrective">Actions to be taken control/correct issues of the complaint</label>
                        <textarea class="form-control" style="resize: none;" rows="5" id="corrective" {{ $auth->office_id == 1 ? 'disabled' : '' }} name="immediate_action">{{ $form->immediate_action ?? '' }}</textarea>
                    </div> 

                    <div class="d-flex flex-column w-75 gap-1">
                        <label class="form-label" for="consequence">Actions taken to deal with the consequence of the complaint</label>
                        <textarea class="form-control" style="resize: none;" rows="5" id="consequence" {{ $auth->office_id == 1 ? 'disabled' : '' }} name="consequence">{{ $form->consequence ?? '' }}</textarea>
                    </div>

                    <div class="d-flex flex-column w-75 gap-1">
                        <label class="form-label" for="analysis">Attack detailed analysis like 5 Whys, Tree Diagram, etc. if applicable</label>
                        <textarea class="form-control" style="resize: none;" rows="5" id="analysis" {{ $auth->office_id == 1 ? 'disabled' : '' }} name="root_cause">{{ $form->root_cause ?? '' }}</textarea>
                    </div>

                    <div class="d-flex flex-column w-75 gap-1">
                        <label class="form-label" for="similar">Specify the location and process where similar issues may occur</label>
                        <textarea class="form-control" style="resize: none;" rows="5" id="similar" {{ $auth->office_id == 1 ? 'disabled' : '' }} name="nonconformity">{{ $form->nonconformity ?? '' }}</textarea>
                    </div>

                    <div class="mt-3 w-75">
                        <div class="d-flex flex-column gap-3">
                            @forelse ($corrective as $corr)
                                <div class="row d-flex" id="corrective_action_1">
                                    <div class="col-md-7 form-group">
                                        <label class="form-label" for="corrective_action_1_actions">Corrective Actions</label>
                                        <textarea 
                                            class="form-control" 
                                            style="resize: none;" 
                                            rows="13" 
                                            id="corrective_action_1_actions" 
                                            {{ $auth->office_id == 1 ? 'disabled' : '' }} 
                                            name="corrective_action[1][corrective_action]"
                                        >{{ $corr->corrective_action ?? '' }}</textarea>
                                    </div>

                                    <div class="col-md-5 d-flex gap-2 flex-column">
                                        <div class="d-flex flex-column form-group">
                                            <label class="form-label" for="corrective_action_1_implementation">Implementation Date</label>
                                            <input 
                                                class="form-control" 
                                                type="date" 
                                                id="corrective_action_1_implementation" 
                                                {{ $auth->office_id == 1 ? 'disabled' : '' }} 
                                                value="{{ optional($corr)->implementation_date ? \Carbon\Carbon::parse($corr->implementation_date)->format('Y-m-d') : '' }}" 
                                                name="corrective_action[1][implementation]"
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="corrective_action_1_effectiveness">Measure of Effectiveness</label>
                                            <textarea 
                                                class="form-control" 
                                                style="resize: none;" 
                                                rows="3" 
                                                name="corrective_action[1][effectiveness]" 
                                                id="corrective_action_1_effectiveness" 
                                                {{ $auth->office_id == 1 ? 'disabled' : '' }}
                                            >{{ $corr->effectiveness ?? '' }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="corrective_action_1_period">Monitoring Period for CA</label>
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="corrective_action_1_period" 
                                                {{ $auth->office_id == 1 ? 'disabled' : '' }} 
                                                value="{{ $corr->monitoring_period ?? '' }}" 
                                                name="corrective_action[1][period]"
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="corrective_action_1_responsible">Responsible</label>
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="corrective_action_1_responsible" 
                                                {{ $auth->office_id == 1 ? 'disabled' : '' }} 
                                                value="{{ $corr->responsible ?? '' }}" 
                                                name="corrective_action[1][responsible]"
                                            >
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="row d-flex" id="corrective_action_1">
                                    <div class="col-md-7 form-group">
                                        <label class="form-label" for="corrective_action_1_actions">Corrective Actions</label>
                                        <textarea 
                                            class="form-control" 
                                            style="resize: none;" 
                                            rows="13" 
                                            id="corrective_action_1_actions" 
                                            {{ $auth->office_id == 1 ? 'disabled' : '' }} 
                                            name="corrective_action[1][corrective_action]"
                                        ></textarea>
                                    </div>

                                    <div class="col-md-5 d-flex gap-2 flex-column">
                                        <div class="d-flex flex-column form-group">
                                            <label class="form-label" for="corrective_action_1_implementation">Implementation Date</label>
                                            <input 
                                                class="form-control" 
                                                type="date" 
                                                id="corrective_action_1_implementation" 
                                                {{ $auth->office_id == 1 ? 'disabled' : '' }} 
                                                value="" 
                                                name="corrective_action[1][implementation]"
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="corrective_action_1_effectiveness">Measure of Effectiveness</label>
                                            <textarea 
                                                class="form-control" 
                                                style="resize: none;" 
                                                rows="3" 
                                                name="corrective_action[1][effectiveness]" 
                                                id="corrective_action_1_effectiveness" 
                                                {{ $auth->office_id == 1 ? 'disabled' : '' }}
                                            ></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="corrective_action_1_period">Monitoring Period for CA</label>
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="corrective_action_1_period" 
                                                {{ $auth->office_id == 1 ? 'disabled' : '' }} 
                                                value="" 
                                                name="corrective_action[1][period]"
                                            >
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="corrective_action_1_responsible">Responsible</label>
                                            <input 
                                                class="form-control" 
                                                type="text" 
                                                id="corrective_action_1_responsible" 
                                                {{ $auth->office_id == 1 ? 'disabled' : '' }} 
                                                value="{{ $corr->responsible ?? '' }}" 
                                                name="corrective_action[1][responsible]"
                                            >
                                        </div>
                                    </div>
                                </div>
                            @endforelse

                            @if ($auth->office_id != 1 && $auth->office_id != 2)
                                <button class="btn btn-primary w-100" type="button" onclick="add_corrective_action()" id="corrective_btn">
                                    <i class="bi-plus-lg me-2"></i>Add Corrective Action
                                </button>
                            @endif
                        </div>

                        <div class="d-flex mt-5 gap-4">
                            <div class="form-group w-50">
                                <label class="form-label" for="risk">Related Risks/Opportunities</label>
                                <textarea class="form-control" style="resize: none;" rows="5" id="risk" {{ $auth->office_id == 1 ? 'disabled' : '' }} name="risk_opportunity">{{ $form->risk_opportunity ?? '' }}</textarea>
                            </div>

                            <div class="form-group w-50">
                                <label class="form-label" for="changes">Changes needed to Quality Management System</label>
                                <textarea class="form-control" style="resize: none;" rows="5" id="changes" {{ $auth->office_id == 1 ? 'disabled' : '' }} name="changes">{{ $form->changes ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 mt-5">
                            <div class="input-group">
                                <span class="input-group-text w-25">Prepared By</span>

                                <select class="form-select w-25" name="prepared_by" id="prepared_by" {{ $auth->office_id == 1 ? 'disabled' : '' }}>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $complaint->validated_by ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input 
                                    class="form-control" 
                                    type="date" 
                                    id="prepared_on" 
                                    value="{{ optional($form)->prepared_on ? \Carbon\Carbon::parse($form->prepared_on)->format('Y-m-d') : '' }}" 
                                    name="prepared_on"
                                    {{ $auth->office_id == 1 ? 'disabled' : '' }}
                                >
                            </div>

                            <div class="input-group">
                                <span class="input-group-text w-25">Approved By</span>
                                
                                <select class="form-select w-25" name="approved_by" id="approved_by" {{ $auth->office_id == 1 ? 'disabled' : '' }}>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $complaint->validated_by ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input 
                                    class="form-control" 
                                    type="date" 
                                    id="approved_on" 
                                    value="{{ optional($form)->approved_on ? \Carbon\Carbon::parse($form->approved_on)->format('Y-m-d') : '' }}" 
                                    name="approved_on"
                                    {{ $auth->office_id == 1 ? 'disabled' : '' }}
                                >
                            </div>

                            <div class="input-group">
                                <span class="input-group-text w-25">Acknowledged By</span>
                                
                                <select class="form-select w-25" name="acknowledged_by" id="acknowledged_by" {{ $auth->office_id == 1 ? 'disabled' : '' }}>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $complaint->validated_by ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input 
                                    class="form-control" 
                                    type="date" 
                                    id="acknowledged_on" 
                                    value="{{ optional($form)->acknowledged_on ? \Carbon\Carbon::parse($form->acknowledged_on)->format('Y-m-d') : '' }}" 
                                    name="acknowledged_on"
                                    {{ $auth->office_id == 1 ? 'disabled' : '' }}
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QAO -->
            <div class="tab-pane p-3 fade" id="qao-tab" role="tabpanel" aria-labelledby="qao-tab" tabindex="0">
                <div class="d-flex flex-column gap-2">
                    <label class="form-label" for="customer-feedback">Customer Feedback</label>

                    <div class="d-flex gap-2">
                        <div class="col-md-7 d-flex flex-column gap-2">
                            <textarea class="form-control" rows="10" name="feedback" id="feedback" style="resize: none;" {{ ($complaint->phase < 2 || $complaint->phase == 3) ? 'disabled' : '' }}>{{ $form->feedback ?? '' }}</textarea>

                            <div class="form-group">
                                <label class="form-label" for="report">Reported By</label>
                                <select class="form-select" name="reported_by" id="reported_by" {{ ($complaint->phase < 2 || $complaint->phase == 3) ? 'disabled' : '' }}>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" 
                                            {{ optional($form)->reported_by == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-5 d-flex flex-column gap-2">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="accept" id="accepted" 
                                        value="1" {{ optional($form)->is_approved ? 'checked' : '' }} {{ ($complaint->phase < 2 || $complaint->phase == 3) ? 'disabled' : '' }}>
                                </div>
                                <span class="form-control flex-fill">Accepted</span>
                            </div>

                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="accept" id="not-accepted" 
                                        value="0" {{ optional($form)->is_approved === false ? 'checked' : '' }} {{ ($complaint->phase < 2 || $complaint->phase == 3) ? 'disabled' : '' }}>
                                </div>
                                <span class="form-control flex-fill">Not Accepted</span>
                            </div>

                            <div>
                                <textarea class="form-control d-none" name="reasons" rows="3" style="resize: none;" id="reasons" placeholder="Further action plans" {{ ($complaint->phase < 2 || $complaint->phase == 3) ? 'disabled' : '' }}>{{ $form->further_action ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Submit customer complaint form?
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-danger" onclick="submit_form()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                const reasonsTextarea = document.getElementById('reasons');

                document.getElementById('not-accepted').addEventListener('click', function () {
                    if (reasonsTextarea.classList.contains('d-none')) {
                        reasonsTextarea.classList.remove('d-none');
                    }
                });

                document.getElementById('accepted').addEventListener('click', function () {
                    if (!reasonsTextarea.classList.contains('d-none')) {
                        reasonsTextarea.classList.add('d-none');
                    }
                });
            });

            let correctiveActionCount = 1;
            function add_corrective_action() {
                correctiveActionCount++;
                const originalAction = document.getElementById("corrective_action_1");
                const newAction = originalAction.cloneNode(true);

                newAction.id = `corrective_action_${correctiveActionCount}`;
                newAction.querySelectorAll('input, textarea').forEach((input) => {
                    const baseName = input.getAttribute("name").replace(/\[\d*\]/, '');
                    const fieldName = baseName.split('[').pop().replace(']', '');
                    input.id = `corrective_action_${correctiveActionCount}_${fieldName}`;
                    input.setAttribute("name", `corrective_action[${correctiveActionCount}][${fieldName}]`);
                    input.value = '';
                });

                document.getElementById("corrective_btn").before(newAction);
            }

            function confirm_form() {
                $('#confirmModal').modal('show');
            }

            function submit_form() {
                document.getElementById('formContent').submit();
            }
        </script>
    </body>
</html>