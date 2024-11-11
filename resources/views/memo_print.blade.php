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
        <div class="d-flex p-3 w-100 justify-content-end align-items-center">
            <button class="btn btn-danger" onclick="print_form()">Print</button>
        </div>

        <div style="height: 1248px; width: 816px; padding: 48px;" class="bg-white shadow" id="main_form">
            <div class="row m-0">
                <div class="col-md-2">
                    <img src="{{ asset('image/logo.png') }}" style="object-fit: cover; height: 100px; width: 100px;">
                </div>

                <div class="col-md-8 d-flex justify-content-center flex-column align-items-center">
                    <p class="text-secondary m-0" style="font-size: small;">Republic of the Philippines</p>
                    <h6 class="text-secondary">Western Mindanao State University</h6>
                    <p class="text-secondary m-0" style="font-size: small;">Quality Management Systems Office</p>
                    <p class="text-secondary m-0" style="font-size: xx-small;">Normal Road, Baliwasan, Zamboanga City, 7000</p>
                </div>

                <div class="col-md-2">

                </div>
            </div>

            <hr class="border-2 border-danger">

            <h6 class="m-0" style="font-size: small;">MEMORANDUM NO.</h6>
            <h5>MEMORANDUM</h5>

            <div class="d-flex mb-3">
                <label class="form-label" style="width: 100px;">FOR:</label>
                <div class="d-flex flex-column">
                    <label class="form-label fw-bold m-0">{{ $memo->for }}</label>
                    <label>{{ $memo->for_role }}</label>
                </div>
            </div>

            <div class="d-flex mb-3">
                <label class="form-label" style="width: 100px;">FROM:</label>
                <div class="d-flex flex-column">
                    <label class="form-label fw-bold m-0">{{ $memo->from }}</label>
                    <label>{{ $memo->from_role }}</label>
                </div>
            </div>

            <div class="d-flex mb-3">
                <label class="form-label" style="width: 100px;">SUBJECT:</label>
                <label class="form-label fw-bold">CUSTOMER COMPLAINT</label>
            </div>

            <div class="d-flex mb-3">
                <label class="form-label" style="width: 100px;">DATE:</label>
                <label class="form-label fw-bold">{{ date('F j, Y', strtotime($memo->created_at)) }}</label>
            </div>

            <hr class="border-2 border-dark">

            <p class="m-0">{{ $memo->content }}</p>
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