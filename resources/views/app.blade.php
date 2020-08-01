<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}" />
        <title>Finance App - Dunsin</title>
                
        <!-- Favicon -->
	    <link rel="icon" type="image/icon" href="{{url('favicon.png')}}">
        
        <link href="{{url('css/style.css')}}" type="text/css" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <!-- Fontawesome -->
        <script src="https://use.fontawesome.com/3e6aae00fd.js"></script>
    </head>

    <body>
        <div id="app">
        </div>
        <script src="{{ mix('js/app.js') }}" type="text/javascript"></script>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>
