<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Complaints Desk</title>
</head>

<body class="bg-light h-100">
    <nav class="bg-danger p-3 px-4 d-flex">
        <h3 class="text-light m-0 d-flex">WMSU Complaints Desk</h3>
    </nav>

    <form class="p-3 d-flex row gap-2 justify-content-center m-0" method="post" action="{{ route('complain') }}" enctype="multipart/form-data">
        @csrf
        <div class="p-0 d-flex gap-2 flex-column col-md-8">
            <div class="form-group">
                <label class="form-label m-0" for="type">Type of Complaint</label>
                <select class="form-select border-danger border-2" name="complaint_type" required>
                    <option value="1">Slow service</option>
                    <option value="2">Unruly/disrespectful personnel</option>
                    <option value="3">No response</option>
                    <option value="4">Error/s on request</option>
                    <option value="5">Delayed issuance of request</option>
                    <option value="6">Others (Specific issue)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label m-0" for="description">Complaint Details</label>
                <textarea class="form-control border-danger border-2" rows="15" name="details" required></textarea>
            </div>
        </div>

        <div class="p-0 d-flex gap-2 flex-column col-md-3">
            <div class="form-group">
                <label class="form-label m-0" for="name">Complainant's Name</label>
                <input class="form-control border-danger border-2" type="text" name="name" style="text-transform: capitalize;" required>
            </div>

            <div class="d-flex flex-column">
                <div class="input-group">
                    <input type="text" class="form-control border border-danger border-2" name="type" id="inputField">
                    <button class="btn bg-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" style="color: #ffffff;">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" type="button" data-value="Student">Student</button></li>
                        <li><button class="dropdown-item" type="button" data-value="Alumni">Alumni</button></li>
                        <li><button class="dropdown-item" type="button" data-value="Staff">Staff</button></li>
                    </ul>
                </div>

                <p class="m-0 ps-1" style="font-size:xx-small;">If not in options, please specify</p>
            </div>

            <div class="form-group">
                <label class="form-label m-0" for="contact">Contact Information</label>
                <div class="input-group">
                    <input class="form-control border-danger border-2 border-end-0" type="tel" name="phone" placeholder="Number" required>
                    <input class="form-control border-danger border-2" type="email" name="email" placeholder="Email" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label m-0" for="recipient">Complaint Recipient</label>
                <select class="form-select border-danger border-2" name="recipient" required>
                    <option value="0" selected disabled>Choose Recipient...</option>

                    @foreach ($offices as $office)
                        <option value="{{ $loop->count }}">{{ $office->office_name }}</option>
              i   @endforeach
                </select>
            </div>

            <div class="form-group mb-2">
                <label class="form-label m-0" for="evidence">Evidence</label>
                <input class="form-control border-danger border-2" name="file" type="file" required>
            </div>

            <input class="btn btn-danger w-100 mt-auto" type="submit" value="Submit Complaint">
        </div>
    </form>

    <div class="modal fade" id="successModal" role="dialog" tabindex="-1" aria-labelledby="successModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Success!</h1>
                </div>

                <div class="modal-body">
                    Successfully submitted complaint.
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @if(session("success"))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var modal = new bootstrap.Modal(document.getElementById("successModal"), {});
                document.onreadystatechange = function () {
                    modal.show();
                };
            });
        </script>
    @endif

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        const dropdownItems = document.querySelectorAll('.dropdown-item');
        const inputField = document.getElementById('inputField');

        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                inputField.value = this.getAttribute('data-value');
            });
        });
    </script>

</body>

</html>