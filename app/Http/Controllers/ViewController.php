<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Request as TextRequest;
use App\Response as TextResponse;
use App\Jobs\SendMessage;

class ViewController extends Controller
{
    public function index() {
        $requests = TextRequest::orderBy('updated_at')->get();
        $responses = TextResponse::orderBy('updated_at')->get();

        SendMessage::dispatch('+17863947558');

        return view('welcome')
            ->with('requests', $requests)
            ->with('responses', $responses);
    }

    public function response(Request $request) {
        error_log($request);
        error_log('BODDDDDDDYYYY');
        error_log($request['Body']);

        // $new_response = new TextResponse;
        // $new_response->text = $request['Body'];
        //     ->with('requests', $requests)
        //     ->with('responses', $responses);
        return view('welcome');
    }
}
