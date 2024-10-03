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

    <body class="bg-light h-100 p-3">
        <div class="d-flex gap-2 align-items-center justify-content-between">
            <a href="/qao/complaint/{{ $complaint->id }}">Back</a>
            <h4 class="text-danger">Customer Complaint Form</h4>
            <div class="d-flex gap-2">
                <a class="btn btn-secondary" href="/qao/complaint/form/print/{{ $complaint->id }}">
                    <i class="bi bi-printer"></i>
                </a>

                @if ($auth->office_id == 1)
                    <button class="btn btn-danger" onclick="confirm_form()">Forward Form</button>
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

        <form class="tab-content bg-white" action="/submit-form" id="formContent">
            @csrf

            <!-- Complaint -->
            <div class="tab-pane p-3 fade show active" id="complaint-tab" role="tabpanel" aria-labelledby="complaint-tab" tabindex="0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="details">Description of complaint</label>
                            <textarea class="form-control" style="resize: none;" name="details" rows="15">{{ $complaint->details }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-column gap-3">
                        <div class="d-flex flex-column gap-1">
                            <span>Filed By</span>
                            <div class="input-group">
                                <input class="form-control w-25" type="text" aria-label="complainant-name" value="{{ $complaint->name }}">
                                <input class="form-control" type="date" aria-label="complainant-date" value="{{ $complaint->created_at->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-1">
                            <span>Validated By</span>
                            <div class="input-group">
                                <select class="form-select w-25">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $complaint->validated_by ? 'selected' : '' }}>
                                            {{ $user->username }}
                                        </option>
                                    @endforeach
                                </select>

                                <input class="form-control" type="date" aria-label="validated-date" value="{{ $complaint->date_verified->format('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-1">
                            <span>Acknowledged By</span>
                            <div class="input-group">
                                <select class="form-select w-25">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $complaint->validated_by ? 'selected' : '' }}>
                                            {{ $user->username }}
                                        </option>
                                    @endforeach
                                </select>
                                 
                                <input class="form-control" type="date" aria-label="acknowledge-date" value="">
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
                        <textarea class="form-control" style="resize: none;" rows="5" name="corrective" id="corrective"></textarea>
                    </div>

                    <div class="d-flex flex-column w-75 gap-1">
                        <label class="form-label" for="consequence">Actions taken to deal with the consequence of the complaint</label>
                        <textarea class="form-control" style="resize: none;" rows="5" name="consequence" id="consequence"></textarea>
                    </div>

                    <div class="d-flex flex-column w-75 gap-1">
                        <label class="form-label" for="analysis">Attack detailed analysis like 5 Whys, Tree Diagram, etc. if applicable</label>
                        <textarea class="form-control" style="resize: none;" rows="5" name="analysis" id="analysis"></textarea>
                    </div>

                    <div class="d-flex flex-column w-75 gap-1">
                        <label class="form-label" for="similar">Specify the location and process where similar issues may occur</label>
                        <textarea class="form-control" style="resize: none;" rows="5" name="similar" id="similar"></textarea>
                    </div>

                    <div class="row mt-3 w-75">
                        <div class="col-md-7 form-group">
                            <label class="form-label" for="actions">Corrective Actions</label>
                            <textarea class="form-control" style="resize: none;" name="actions" rows="13" id="actions"></textarea>
                        </div>

                        <div class="col-md-5 d-flex gap-2 flex-column">
                            <div class="d-flex flex-column form-group">
                                <label class="form-label" for="implementation">Implementation Date</label>
                                <input class="form-control" type="date" name="implementation" id="implementation">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="effectiveness">Measure of Effectiveness</label>
                                <textarea class="form-control" style="resize: none;" rows="3" name="effectiveness" id="effectiveness"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="period">Monitoring Period for CA</label>
                                <input class="form-control" type="text" name="period" id="period">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="responsible">Responsible</label>
                                <input class="form-control" type="text" name="responsible" id="responsible">
                            </div>
                        </div>

                        <div class="d-flex mt-5 gap-4">
                            <div class="form-group w-50">
                                <label class="form-label" for="risk">Related Risks/Opportunities</label>
                                <textarea class="form-control" style="resize: none;" rows="5" name="risk" id="risk"></textarea>
                            </div>

                            <div class="form-group w-50">
                                <label class="form-label" for="changes">Changes need to Quality Management System</label>
                                <textarea class="form-control" style="resize: none;" rows="5" name="changes" id="changes"></textarea>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 mt-5">
                            <div class="input-group">
                                <span class="input-group-text w-25">Prepared By</span>
                                <input type="text" aria-label="prepared-by-name" class="form-control" name="prepared-by">
                                <input type="date" aria-label="prepared-by-date" class="form-control" name="prepared-date">
                            </div>

                            <div class="input-group">
                                <span class="input-group-text w-25">Approved By</span>
                                <input type="text" aria-label="approved-by-name" class="form-control" name="approved-by">
                                <input type="date" aria-label="approved-by-date" class="form-control" name="approved-date">
                            </div>

                            <div class="input-group">
                                <span class="input-group-text w-25">Acknowledged By</span>
                                <input type="text" aria-label="acknowledge-by-name" class="form-control" name="acknowledge-by">
                                <input type="date" aria-label="acknowledge-by-date" class="form-control" name="acknowledge-date">
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
                            <textarea class="form-control" rows="10" name="customer-feedback" style="resize: none;"></textarea>

                            <div class="form-group">
                                <label class="form-label" for="report">Reported By</label>
                                <input class="form-control" type="text" name="report">
                            </div>
                        </div>
                        
                        <div class="col-md-5 d-flex flex-column gap-2">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" value="" name="accept" id="accepted">
                                </div>

                                <span class="form-control flex-fill">Accepted</span>
                            </div>

                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" value="" name="accept" id="not-accepted">
                                </div>

                                <span class="form-control flex-fill">Not Accepted</span>
                            </div>

                            <div>
                                <textarea class="form-control d-none" name="reasons" rows="3" style="resize: none;" id="reasons" placeholder="Further action plans"></textarea>
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
                        <button class="btn btn-danger" onclick="">Submit</button>
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

                // Show textarea when "Not Accepted" is clicked
                document.getElementById('not-accepted').addEventListener('click', function () {
                    if (reasonsTextarea.classList.contains('d-none')) {
                        reasonsTextarea.classList.remove('d-none');
                    }
                });

                // Hide textarea when "Accepted" is clicked
                document.getElementById('accepted').addEventListener('click', function () {
                    if (!reasonsTextarea.classList.contains('d-none')) {
                        reasonsTextarea.classList.add('d-none');
                    }
                });
            });

            function confirm_form() {
                $('#confirmModal').modal('show');
            }

            function submit_form() {

            }
        </script>
    </body>
</html>