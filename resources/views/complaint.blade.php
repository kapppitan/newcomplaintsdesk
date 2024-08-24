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
        <a href="{{ url()->previous() }}">Back</a>
        <hr class="border-2">
        <p>Submitted on {{ date('F j, Y', strtotime($complaint->created_at)) }} <span class="text-secondary">({{ $complaint->created_at->diffForHumans() }})</span></p>

        <div class="row h-100">
            <div class="col-sm-7">
                <div class="form-group h-100">
                    <label class="form-label" for="details">Details</label>
                    <textarea class="form-control mb-2" rows="17" style="resize: none;" name="details" disabled>{{ $complaint->details }}</textarea>
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
                        <input class="form-control" type="text" name="type" value="{{ $complaint->user_type }}" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="contact">Contact Information</label>
                    <div class="container p-0 gap-2 d-flex">
                        <input class="form-control" type="email" name="email" value="{{ $complaint->email }}" disabled>
                        <input class="form-control" type="tel" name="tel" value="{{ $complaint->phone }}" disabled>
                    </div>
                </div>

                <button class="btn btn-danger mt-auto">View Files</button>
                <input class="btn btn-danger mb-2" type="submit" value="Form haha ambot">
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>