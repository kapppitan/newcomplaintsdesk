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

    <body class="bg-light p-4 overflow-x-hidden">
        <div class="d-flex justify-content-between">
            <a href="">Back</a>
            <a href="/complaint/form/print/{{ $complaint->id }}" class="btn btn-secondary">Print</a>
        </div>

        <hr class="border-2">

        <div class="row h-100">
            <div class="col-sm-8 d-flex flex-column gap-2">
                @foreach ($corrective as $corr)
                    <div class="container-fluid d-flex flex-column gap-2 bg-white p-2 rounded-1" id="corrective_action">
                        <label class="form-label" for="details">Corrective Action</label>
                        
                        <div class="row">
                            <div class="col">
                                <textarea class="form-control" style="resize: none;" rows="17" name="corrective_action" id="" disabled>{{ $corr->corrective_action }}</textarea>
                            </div>

                            <div class="col d-flex flex-column gap-2">
                                <div class="form-group">
                                    <label class="form-label" for="corrective_date">Implementation Date</label>
                                    <input class="form-control" type="date" name="corrective_date" value="{{ \Carbon\Carbon::parse($corr->implementation_date)->format('Y-m-d') }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="corrective_effect">Effectiveness</label>
                                    <input class="form-control" type="text" name="corrective_effect" value="{{ $corr->effectiveness }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="corrective_period">Monitoring Period</label>
                                    <input class="form-control" type="text" name="corrective_period" value="{{ $corr->monitoring_period }}" disabled>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="corrective_responsible">Responsible</label>
                                    <input class="form-control" type="text" name="corrective_responsible" value="{{ $corr->responsible }}" disabled>
                                </div>

                                @if ($complaint->office_id == Auth::user()->office_id)
                                    <form class="container-fluid m-0 p-0 gap-2 d-flex flex-column" action="{{ route('upload-file', ['id' => $corr->id]) }}" method="post" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label class="form-label" for="ufile">Upload Evidence</label>
                                            <input type="file" class="form-control" name="ufile" id="ufile">
                                        </div>

                                        <button class="btn btn-danger">Submit</button>
                                    </form>
                                @else
                                    <a class="btn btn-danger" href="/download/{{ $corr->id }}">View Evidence</a>
                                @endif
                            </div>
                        </div>

                        <form class="d-flex flex-column" method="post" action="{{ route('accept-not', ['id' => $corr->id]) }}">
                            @csrf

                            <label for="feedback">Comment</label>
                            <textarea class="form-control mb-2" rows="5" style="resize: none;" name="feedback" id="feedback" required {{ Auth::user()->office_id == 1 || Auth::user()->office_id == 2 ? '' : 'disabled  ' }}>{{ $corr->comment ?? '' }}</textarea>

                            <div class="container-fluid d-flex gap-5">
                                <div class="form-group">
                                    <input type="radio" name="accepted" id="accept" value="1" required {{ Auth::user()->office_id == 1 || Auth::user()->office_id == 2 ? '' : 'disabled  ' }} {{ $corr->is_approved ? 'checked' : '' }}>
                                    <label for="accept">Accepted</label>
                                </div>

                                <div class="form-group">
                                    <input type="radio" name="accepted" id="notaccept" value="0" required {{ Auth::user()->office_id == 1 || Auth::user()->office_id == 2 ? '' : 'disabled  ' }} {{ $corr->is_approved ? '' : 'checked' }}>
                                    <label for="accept">Not Accepted</label>
                                </div>

                                @if (Auth::user()->office_id == 1 || Auth::user()->office_id == 2)
                                    <button class="btn btn-danger ms-auto" {{ $complaint->is_monitored ? '' : 'disabled' }}>Submit</button>
                                @endif
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="col-sm-4 d-flex flex-column gap-3">
                <form class="input-group" method="post" action="{{ route('open-close', ['id' => $complaint->id]) }}" id="status">
                    @csrf

                    <select class="form-select" name="cstatus" id="cstatus">
                        <option value="0" {{ $complaint->is_closed ? '' : 'selected' }}>Open</option>
                        <option value="1" {{ $complaint->is_closed ? 'selected' : '' }}>Closed</option>
                    </select>

                    <button class="btn btn-danger">Update Status</button>
                </form>

                <form class="d-flex flex-column gap-2" method="post" action="{{ route('monitor', ['id' => $complaint->id]) }}" id="monitor">
                    @csrf

                    <a class="btn btn-danger flex-fill" href="/complaint/form/print/{{ $complaint->id }}" id="view-complaint-form">View Complaint Form</a>
                    <button class="btn btn-danger flex-fill">Monitor Complaint</button>
                </form>
            </div>
        </div>



        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>   
    </body>
</html>