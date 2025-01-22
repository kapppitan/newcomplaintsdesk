<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <title>Customer Complaint Form</title>

        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #main_form * {
                    visibility: visible;
                }

                #main_form {
                    position: absolute;
                    top: 0;
                    left: 0;
                }
            }
        </style>
    </head>

    <body class="bg-secondary px-5 pt-0 pb-5 d-flex flex-column align-items-center">
        <div class="d-flex p-3 w-100 justify-content-between align-items-center mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

            <button class="btn btn-danger" onclick="print_form()">Print</button>
        </div>

        <div style="height: 1248px; width: 816px; padding: 48px;" class="bg-white shadow" id="main_form">
            <div class="row m-0">
                <div class="col border ps-1 p-2">
                    <img src="{{ asset('image/wmsu_logo.jpg') }}" style="object-fit: cover; height: 50px;">
                </div>

                <div class="col-md-8 d-flex flex-column align-items-center border-top ps-1 justify-content-center">
                    <h5 class="m-0">CUSTOMER COMPLAINT FORM</h5>
                    <p class="m-0 mb-1" style="font-size: x-small;">WMSU-QMSO-FR</p>
                </div>

                <div class="col border ps-1">
                    <p class="fw-bold m-0" style="font-size: x-small;">Date prepared:</p>
                    <p class="m-0" style="font-size: x-small;">{{ Carbon\Carbon::parse($form->created_at)->format('F j, Y') }}</p>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">1</div>

                <div class="col border p-0 ps-1 pb-5">
                    <p class="m-0 fw-bold" style="font-size: x-small;">DESCRIPTION OF COMPLAINT*</p>
                    <p class="m-0" style="font-size: x-small;">{{ $complaint->details }}</p>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">2</div>

                <div class="col border p-0 ps-1">
                    <p class="m-0 fw-bold border-bottom" style="font-size: x-small;">Filed by:</p>
                    <p class="m-0 pb-3" style="font-size: x-small;">{{ $complaint->name }}</p>
                </div>

                <div class="col border p-0 ps-1">
                    <p class="m-0 fw-bold border-bottom" style="font-size: x-small;">Date</p>
                    <p class="m-0" style="font-size: x-small;">{{ Carbon\Carbon::parse($complaint->created_at)->format('F j, Y') }}</p>
                </div>

                <div class="col border p-0 ps-1">
                    <p class="m-0 fw-bold border-bottom" style="font-size: x-small;">Validated by:</p>
                    <p class="m-0" style="font-size: x-small;">{{ $users->find($form->validated_by)->username }}</p>
                </div>

                <div class="col border p-0 ps-1">
                    <p class="m-0 fw-bold border-bottom" style="font-size: x-small;">Date</p>
                    <p class="m-0" style="font-size: x-small;">{{ Carbon\Carbon::parse($complaint->validated_on)->format('F j, Y') }}</p>
                </div>

                <div class="col border p-0 ps-1">
                    <p class="m-0 fw-bold border-bottom" style="font-size: x-small;">Acknowledged by:</p>
                    <p class="m-0" style="font-size: x-small;">{{ $users->find($form->acknowledgedqao_by)->username }}</p>
                </div>

                <div class="col border p-0 ps-1">
                    <p class="m-0 fw-bold border-bottom" style="font-size: x-small;">Date</p>
                    <p class="m-0" style="font-size: x-small;">{{ Carbon\Carbon::parse($complaint->acknowledgedqao_on)->format('F j, Y') }}</p>
                </div>
            </div>

            <p class="p-1 m-0 text-center text-danger bg-light ps-2 border" style="font-size: small;">TO BE ACCOMPLISHED BY THE DEPARTMENT/SECTION RESPONSIBLE</p>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">3</div>
                
                <div class="col p-0">
                    <p class="m-0 ps-1 bg-secondary-subtle fw-bold border border-bottom" style="font-size: x-small;">IMMEDIATE ACTION</p>
                    
                    <div class="row m-0">
                        <div class="col p-0 border">
                            <p class="p-0 ps-1 m-0 border bg-secondary-subtle text-center" style="font-size: x-small;">Actions taken to control/correct issues of the complaint</p>
                            <p class="p-0 ps-1 pb-3 m-0 border" style="font-size: x-small;">{{ $form->immediate_action }}</p>
                        </div>

                        <div class="col p-0 border">
                            <p class="p-0 ps-1 m-0 border bg-secondary-subtle text-center" style="font-size: x-small;">Actions taken to deal with the consequences of the complaint</p>
                            <p class="p-0 ps-1 pb-3 m-0 border" style="font-size: x-small;">{{ $form->consequence }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">4</div>
                <div class="col p-0 border">
                    <p class="m-0 ps-1 border-bottom" style="font-size: x-small;"><span class="fw-bold" style="font-size: x-small;">ROOT CAUSE/s</span> (Attach detailed analysis like 5 Whys, Tree Diagram, etc. if applicable)</p>
                    <p class="m-0 ps-1 pb-3" style="font-size: x-small;">{{ $form->root_cause }}</p>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">5</div>
                <div class="col p-0 border">
                    <p class="m-0 ps-1 border-bottom" style="font-size: x-small;"><span class="fw-bold" style="font-size: x-small;">EXISTING SIMILAR NONCONFORMITY, if any:</span> (specify the location and process where similar issues might also occur)</p>
                    <p class="m-0 ps-1 pb-3" style="font-size: x-small;">{{ $form->nonconformity }}</p>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">6</div>
                <div class="col p-0 border">
                    <div class="row m-0">
                        <div class="col p-0 border text-center bg-secondary-subtle" style="font-size: x-small;">CORRECTIVE ACTION (CA)</div>
                        <div class="col p-0 border text-center bg-secondary-subtle" style="font-size: x-small;">IMPLEMENTATION DATE</div>
                        <div class="col p-0 border text-center bg-secondary-subtle" style="font-size: x-small;">MEASURE OF EFFECTIVENESS</div>
                        <div class="col p-0 border text-center bg-secondary-subtle" style="font-size: x-small;">MONITORING PERIOD FOR CA</div>
                        <div class="col p-0 border text-center bg-secondary-subtle" style="font-size: x-small;">RESPONSIBLE</div>
                    </div>

                    @foreach ($corrective as $corr)
                        <div class="row m-0">
                            <div class="col p-0 border">
                                <p class="m-0 pb-3 ps-1" style="font-size: x-small;">{{ $corr->corrective_action }}</p>
                            </div>
                            <div class="col p-0 border">
                                <p class="m-0 pb-3 ps-1" style="font-size: x-small;">{{ Carbon\Carbon::parse($corr->implementation_date)->format('F j, Y') }}</p>
                            </div>
                            <div class="col p-0 border">
                                <p class="m-0 pb-3 ps-1" style="font-size: x-small;">{{ $corr->effectiveness }}</p>
                            </div>
                            <div class="col p-0 border">
                                <p class="m-0 pb-3 ps-1" style="font-size: x-small;">{{ $corr->monitoring_period }}</p>
                            </div>
                            <div class="col p-0 border">
                                <p class="m-0 pb-3 ps-1" style="font-size: x-small;">{{ $corr->responsible }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">7</div>
                <div class="col p-0 border">
                    <p class="m-0 ps-1 border-bottom" style="font-size: x-small;"><span class="fw-bold" style="font-size: x-small;">RELATED RISKS / OPPORTUNITIES</span> (identify process needing updates in risk registry, if necessary)</p>
                    <p class="m-0 ps-1 pb-3" style="font-size: x-small;">{{ $form->risk_opportunity }}</p>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">8</div>
                <div class="col p-0 border">
                    <p class="m-0 ps-1 border-bottom" style="font-size: x-small;"><span class="fw-bold" style="font-size: x-small;">CHANGES NEEDED TO QUALITY MANAGEMENT SYSTEM</span> (describe required changes to existing process in the QMS, if necessary)</p>
                    <p class="m-0 ps-1 pb-3" style="font-size: x-small;">{{ $form->changes }}</p>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">9</div>
                <div class="col p-0 border">
                    <div class="row m-0">
                        <div class="col p-0">
                            <p class="m-0 ps-1 border-bottom fw-bold" style="font-size: x-small;">Prepared by:</p>
                            <p class="m-0 ps-1" style="font-size: x-small;">{{ optional($users->find($form->prepared_by))->name }}</p>
                        </div>

                        <div class="col p-0">
                            <p class="m-0 ps-1 border-bottom fw-bold border-end" style="font-size: x-small;">Date</p>
                            <p class="m-0 ps-1 pb-3 border-end" style="font-size: x-small;">{{ Carbon\Carbon::parse($form->prepared_on)->format('F j, Y') }}</p>
                        </div>

                        <div class="col p-0">
                            <p class="m-0 ps-1 border-bottom fw-bold" style="font-size: x-small;">Approved by:</p>
                            <p class="m-0 ps-1" style="font-size: x-small;">{{ optional($users->find($form->approved_by))->name }}</p>
                        </div>

                        <div class="col p-0">
                            <p class="m-0 ps-1 border-bottom fw-bold border-end" style="font-size: x-small;">Date</p>
                            <p class="m-0 ps-1 pb-3 border-end" style="font-size: x-small;">{{ Carbon\Carbon::parse($form->approved_on)->format('F j, Y') }}</p>
                        </div>

                        <div class="col p-0">
                            <p class="m-0 ps-1 border-bottom fw-bold" style="font-size: x-small;">Acknowledged by:</p>
                            <p class="m-0 ps-1" style="font-size: x-small;">{{ optional($users->find($form->acknowledged_by))->name }}</p>
                        </div>

                        <div class="col p-0">
                            <p class="m-0 ps-1 border-bottom fw-bold" style="font-size: x-small;">Date</p>
                            <p class="m-0 ps-1" style="font-size: x-small;">{{ Carbon\Carbon::parse($form->acknowledged_on)->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <p class="p-1 m-0 text-center text-danger bg-light ps-2 border" style="font-size: small;">TO BE ACCOMPLISHED BY CUSTOMER RELATIONS OFFICER</p>

            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">10</div>
                <div class="col p-0 border">
                    <div class="row m-0">
                        <div class="col p-0">
                            <p class="m-0 ps-1 fw-bold border-bottom" style="font-size: x-small;">CUSTOMER FEEDBACK</p>
                            <p class="m-0 ps-1 pb-3 border-bottom" style="font-size: x-small;">{{ $form->feedback }}</p>

                            <p class="m-0 ps-1 border-bottom" style="font-size: x-small;"><span class="fw-bold">Reported by:</span> {{ optional(\App\Models\User::where('id', $form->reported_by)->first())->name }}</p>
                            <p class="m-0 ps-1 pb-3 border-bottom" style="font-size: x-small;"><span class="fw-bold">Date:</span> {{ Carbon\Carbon::parse($form->date_reported)->format('F j, Y') }}</p>
                        </div>

                        <div class="col p-0 ps-1 border-start">
                            <div class="d-flex align-items-center">
                                <input type="radio" name="accept" {{ $form->is_approved ? 'checked' : '' }} disabled>
                                <label class="p-1" style="font-size: x-small;" for="radio_accepted" id="accept">ACCEPTED</label>
                            </div>

                            <div class="d-flex align-items-center">
                                <input type="radio" name="accept" {{ $form->is_approved ? '' : 'checked' }} disabled>
                                <label class="ps-1" style="font-size: x-small;" for="radio_accepted" id="notaccept">NOT ACCEPTED (FURTHER ACTION PLAN)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="p-1 m-0 text-center text-danger bg-light ps-2 border" style="font-size: small;">TO BE VERIFIED BY INTERNAL QUALITY AUDIT TEAM</p>
            
            <div class="row m-0">
                <div class="col-md-1 px-1 p-0 border" style="width: 20px; font-size: x-small;">11</div>
                <div class="col p-0 border">
                    <div class="row m-0 border-bottom">
                        <div class="col ps-1">
                            <p class="fw-bold" style="font-size: x-small;">Verified by: <span class="fw-light">test_user</span></p>
                        </div>

                        <div class="col ps-1">
                            <p class="fw-bold" style="font-size: x-small;">Date: <span class="fw-light">test_date</span></p>
                        </div>
                    </div>

                    <div class="col p-2 d-flex flex-column gap-2" style="font-size: x-small;">
                        <div class="form-group d-flex align-items-center">
                            <input type="radio" name="open" id="open" disabled {{ optional($complaint)->is_closed ? '' : 'checked' }}>
                            <p class="m-0 ps-1">Open Status</p>
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <input type="radio" name="open" id="closed" disabled {{ optional($complaint)->is_closed ? 'checked' : '' }}>
                            <p class="m-0 ps-1">Close Status</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

        <script>
            function print_form() {
                window.print();
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>   
    </body>
</html>