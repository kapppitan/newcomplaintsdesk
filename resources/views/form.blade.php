<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <title>Customer Complaint Form</title>
    </head>

    <body class="bg-light h-100 p-3">
        <div class="d-flex gap-2 align-items-center">
            <a href="/qao/complaint/{{ $complaint->id }}">Back</a>
            <button class="btn btn-danger ms-auto">Submit Form</button>
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

            <div class="tab-pane p-3 fade show active" id="complaint-tab" role="tabpanel" aria-labelledby="complaint-tab" tabindex="0">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="details">Description of complaint</label>
                            <textarea class="form-control" style="resize: none;" name="details" rows="15">{{ $complaint->details }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex flex-column gap-2">
                        <span>Filed By</span>
                        <div class="input-group">
                            <input class="form-control" type="text" aria-label="complainant-name" value="{{ $complaint->name }}">
                            <input class="form-control" type="date" aria-label="complainant-date" value="{{ $complaint->created_at->format('Y-m-d') }}">
                        </div>

                        <span>Validated By</span>
                        <div class="input-group">
                            <select class="form-select">
                                @foreach ($users as $user)
                                    <option value="{{ $loop->iteration }}">{{ $user->username }}</option>
                                @endforeach
                            </select>

                            <input class="form-control" type="date" aria-label="validated-date" value="">
                        </div>

                        <span>Acknowledged By</span>
                        <div class="input-group">
                            <input class="form-control" type="text" aria-label="acknowledge-name" value="">
                            <input class="form-control" type="date" aria-label="acknowledge-date" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane p-3 fade" id="office-tab" role="tabpanel" aria-labelledby="office-tab" tabindex="0">
                <div class="d-flex flex-column gap-2">
                    <div class="form-floating">
                        <textarea class="form-control" name="corrective" style="height: 100px;" placeholder="Corrective actions..."></textarea>
                        <label for="corrective">Actions to be taken control/correct issues of the complaint</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" name="consequence" style="height: 100px;" placeholder="Deal with the consequence..."></textarea>
                        <label for="corrective">Actions taken to deal with the consequence of the complaint</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" name="analysis" style="height: 100px;" placeholder="Attach detailed analysis..."></textarea>
                        <label for="analysis">Attack detailed analysis like 5 Whys, Tree Diagram, etc. if applicable</label>
                    </div>

                    <div class="form-floating">
                        <textarea class="form-control" name="similar" style="height: 100px;" placeholder="Similar issues may occur..."></textarea>
                        <label for="similar">Specify the location and process where similar issues may occur</label>
                    </div>
                </div>

                <div class="row">

                </div>
            </div>

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
                                    <input class="form-check-input mt-0" type="radio" value="" name="accept">
                                </div>

                                <span class="form-control flex-fill">Accepted</span>
                            </div>

                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" value="" name="accept">
                                </div>

                                <span class="form-control flex-fill">Not Accepted</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>