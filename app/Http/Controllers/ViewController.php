<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
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
        Log::error($request);
        Log::error('BODDDDDDDYYYY');
        Log::error($request['Body']);

        // $new_response = new TextResponse;
        // $new_response->save();
        // $new_response->text = $request['Body'];
        //     ->with('requests', $requests)
        //     ->with('responses', $responses);
        return view('welcome');
    }
}
