@extends('welcome')

@section('content')
<div>
    <div class="row col-sm-12">
        <div class="col-sm-7">
            <h1>Requests ({{$requestCount}})</h1>
            <table class="table table-striped">
                <thead>
                    <th>Lastest update</th>
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
        <div class="col-sm-5">
            <h1>Responses ({{$responseCount}})</h1>
            <table class="table table-striped">
                <thead>
                    <th>Time received</th>
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
@endsection