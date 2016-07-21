<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-10">
            <div class="jumbotron">
                Welcome {{ $first_name }}! <br>
                Your password: {{ $password }}
            </div>
        </div>
    </div>
</div>

<!-- JavaScripts -->
@include('layouts.footer');
</body>
</html>
