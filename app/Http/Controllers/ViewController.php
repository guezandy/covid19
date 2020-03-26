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

        SendMessage::dispatch('+17863947558', false);

        return view('welcome')
            ->with('requests', $requests)
            ->with('responses', $responses);
    }

    public function response(Request $request) {
        $isset_from = isset($request['From']);
        $isset_body = isset($request['Body']);
        if ( $isset_from && $isset_body) {
            $new_response = new TextResponse;
            $new_response->number = $request['From'];
            $new_response->text = $request['Body'];
            $new_response->save();
            # Send confirmation reply
            SendMessage::dispatch($new_response->number, true);
        } else {
            Log::error('Response API: Invalid request receieved');
            Log::error($request);
        }
    }
}
