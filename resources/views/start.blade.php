@extends('welcome')

@section('content')
<div>
    <div class="row">
        @if(isset($task_success))
        <div class="alert alert-success" role="alert" style="width: 100%">
            {{$task_success}}
        </div>
        @endif
        @if(isset($task_failed))
        <div class="alert alert-danger" role="alert" style="width: 100%">
            {{$task_failed}}
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-sm-7">
            <div class="card">
                <div class="card-header">
                    <h3>Send a single text message</h3>
                    <p>Enter a single phone number and a message will be sent</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('single_message') }}">
                        <input placeholder="Phone number: +14445556666 or 4445556666"id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required autofocus>
                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Upload a CSV of phone numbers</h3>
                    <p>Upload a CSV file with a single column of only phone numbers, any invalid phone numbers will be filtered and texts not sent</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('csv_file') }}" enctype="multipart/form-data">
                        <input id="csv_file" type="file" class="form-control" name="csv_file" required>
                        @if ($errors->has('csv_file'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('csv_file') }}</strong>
                            </span>
                        @endif
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3>Download list of responses received</h3>
                    <p>Downloads a CSV with 2 columns - Phone number, response message</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('download_response') }}" enctype="multipart/form-data">
                        <button class="btn btn-primary" type="submit">Download</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card">
                <div class="card-header">
                    <h3>Content of the messages sent</h3>
                </div>
                <div class="card-body">
                    <h3>First message</h3>
                    <p><strong>{{App\Jobs\SendMessage::FIRST_MESSAGE}}</strong></p>

                    <h3>Follow up message</h3>
                    <p>(If someone replies to original message we send them this)</p>
                    <p><strong>{{App\Jobs\SendMessage::FOLLOWUP_MESSAGE}}</strong></p>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection