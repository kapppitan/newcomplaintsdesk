<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <title>Memo</title>
    </head>

    <body class="bg-light p-3">
        <div class="d-flex gap-2 align-items-center justify-content-between">
            <a href="/qao">Back</a>

            <h4 class="text-danger position-absolute start-50 translate-middle-x" style="top: 15px;">Memo</h4>

            <div class="d-flex gap-2">
                <a class="btn btn-secondary {{ $complaint->has_memo ? '' : 'disabled' }}" href="/complaint/memo/print/{{ $complaint->id }}">
                    <i class="bi bi-printer"></i>
                </a>

                <button class="btn btn-danger" onclick="confirm_form()">Send Memo</button>
            </div>
        </div>

        <hr class="border-2">

        <form action="{{ route('submit-memo', ['id' => $complaint->id]) }}" method="post" id="create_memo">
            @csrf

            <div class="d-flex flex-column gap-2">
                <div class="d-flex flex-column gap-2">
                    <div class="input-group">
                        <span class="input-group-text" style="width: 100px;">From</span>
                        <input class="form-control" type="text" name="sender" id="sender" value="{{ $memo->from ?? '' }}">
                        <span class="input-group-text">Role</span>
                        <input class="form-control" type="text" name="sender_role" id="sender_role" value="{{ $memo->from_role ?? '' }}">
                    </div>

                    <div class="input-group">
                        <span class="input-group-text" style="width: 100px;">To</span>
                        <input class="form-control" type="text" name="recipient" id="recipient" value="{{ $memo->for ?? '' }}">
                        <span class="input-group-text">Role</span>
                        <input class="form-control" type="text" name="recipient_role" id="recipient_role" value="{{ $memo->for_role ?? '' }}">
                    </div>
                </div>

                <div class="form-group d-flex flex-column">
                    <label class="form-label" for="content">Content</label>
                    <textarea class="form-control" style="resize: none;" rows="20" name="content" id="content">{{ $memo->content ?? '' }}</textarea>
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
                        Submit memo?
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-danger" onclick="submit_form()">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

        <script>
            function confirm_form() {
                $('#confirmModal').modal('show');
            }

            function submit_form() {
                document.getElementById('create_memo').submit();
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>