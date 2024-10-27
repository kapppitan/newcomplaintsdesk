<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <title>{{ $complaint->details }}</title>
    </head>

    <body class="bg-light h-100 p-3">
        <a href="/qao/complaint/return">Back</a>
        <hr class="border-2">
        <p>Submitted on {{ date('F j, Y', strtotime($complaint->created_at)) }} <span class="text-secondary">({{ $complaint->created_at->diffForHumans() }})</span></p>

        <div class="row h-100">
            <div class="col-sm-7">
                <div class="form-group h-100">
                    <label class="form-label" for="details">Details</label>
                    <textarea class="form-control mb-2" rows="15" style="resize: none;" name="details" disabled>{{ $complaint->details }}</textarea>
                
                    <form class="input-group" method="post" action="/qao/update-status/{{ $complaint->id }}">
                        @csrf
                        <select class="form-select" name="status">
                            <option value="1">Legitimate</option>
                            <option value="2">Non-conforming</option>
                            <option value="3">Inquiry</option>
                            <option value="4">Closed</option>
                        </select>

                        <button class="btn btn-danger" type="submit">Update Status</button>
                    </form>
                </div>
            </div>

            <div class="col-sm-5 gap-2 d-flex flex-column">
                <div class="form-group">
                    <label class="form-label" for="office">Recipient</label>
                    <input class="form-control" type="text" name="office" value="{{ $office->office_name }}" disabled>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Complainant</label>
                    <div class="d-flex flex-column gap-2">
                        <input class="form-control" type="text" name="name" value="{{ $complaint->name }}" disabled>

                        @switch ($complaint->user_type)
                            @case(1)
                                <input class="form-control" type="text" name="type" value="Student" disabled>
                                @break
                            @case(2)
                                <input class="form-control" type="text" name="type" value="Alumni" disabled>
                                @break
                            @case(3)
                                <input class="form-control" type="text" name="type" value="Staff" disabled>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="contact">Contact Information</label>
                    <div class="container p-0 gap-2 d-flex">
                        <input class="form-control" type="email" name="email" value="{{ $complaint->email }}" disabled>
                        <input class="form-control" type="tel" name="tel" value="{{ $complaint->phone }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2 w-100 mt-auto">
                    <button class="btn btn-danger flex-fill" onclick="showFiles()">View Files</button>
                    
                    <div class="d-flex gap-2">
                        @if ($complaint->status === 1)
                            <a class="btn btn-danger flex-fill" href="/qao/complaint/memo/{{ $complaint->id }}">Memo</a>
                            <a class="btn btn-danger flex-fill" href="/qao/complaint/form/{{ $complaint->id }}">Customer Complaint Form</a>
                        @else
                            <a class="btn btn-danger flex-fill" href="#" disabled>Memo</a>
                            <a class="btn btn-secondary flex-fill" href="#" disabled>Customer Complaint Form</a>
                        @endif
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
                        <img src="{{ Storage::url($complaint->image_path) }}" style="width: 100%;">
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
        <script>
            function showFiles() {
                $('#filesModal').modal('show');
            }
        </script>
    </body>
</html>