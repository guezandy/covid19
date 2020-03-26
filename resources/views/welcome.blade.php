<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Covid19 Response line</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div>
            <div class="row col-sm-12">
                <div class="col-sm-8">
                    <h1>Requests</h1>
                    <table class="table table-striped">
                        <thead>
                            <th>Time</th>
                            <th>Attempts</th>
                            <th>Success</th>
                            <th>Number</th>
                            <th>Text</th>
                        </thead>
                        <tbody>
                        @if(isset($requests))
                            @foreach($requests as $request)
                            <tr>
                                <td>{{$request['updated_at']}}</td>
                                <td>{{$request['attempts']}}</td>
                                <td>{{$request['success']}}</td>
                                <td>{{$request['number']}}</td>
                                <td>{{$request['text']}}</td>
                            <tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-4">
                    <h1>Responses</h1>
                    <table class="table table-striped">
                        <thead>
                            <th>Time</th>
                            <th>Number</th>
                            <th>Text</th>
                        </thead>
                        <tbody>
                        @if(isset($responses))
                            @foreach($responses as $response)
                            <tr>
                                <td>{{$response['created_at']}}</td>
                                <td>{{$response['number']}}</td>
                                <td>{{$response['text']}}</td>
                            <tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
