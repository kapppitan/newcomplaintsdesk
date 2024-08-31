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
        <a href="/qao/complaint/{{ $complaint->id }}">Back</a>
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

        <form class="tab-content bg-white" id="formContent">
            @csrf

            <div class="tab-pane p-3 fade show active" id="complaint-tab" role="tabpanel" aria-labelledby="complaint-tab" tabindex="0">
                <div class="row">
                    <div class="col-mg">

                    </div>
                </div>
            </div>

            <div class="tab-pane p-3 fade" id="office-tab" role="tabpanel" aria-labelledby="office-tab" tabindex="0">
                test1
            </div>

            <div class="tab-pane p-3 fade" id="qao-tab" role="tabpanel" aria-labelledby="qao-tab" tabindex="0">
                test2
            </div>
        </form>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>