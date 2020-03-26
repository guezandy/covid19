<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use Log;
use App\Request as TextRequest;
use App\Response as TextResponse;
use App\Jobs\SendMessage;
use Carbon\Carbon;

class ViewController extends Controller
{
    public function index() {
        $requests = TextRequest::orderBy('updated_at', 'DESC')->take(100)->get();
        $responses = TextResponse::orderBy('updated_at', 'DESC')->take(100)->get();

        $requests_count = TextRequest::count();
        $response_count = TextResponse::count();

        SendMessage::dispatch('+17863947558', false);

        return view('results')
            ->with('requestCount', $requests_count)
            ->with('responseCount', $response_count)
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
        return response('Success', 200)->header('Content-Type', 'text/plain');
    }

    public function start() {
        return view('start');
    }

    public function singleMessage(Request $request) {
        $validatedData = $this->validate($request,[
            'phone' => 'bail|required|regex:/^(1?(-?\d{3})-?)?(\d{3})(-?\d{4})$/|min:11|numeric',
        ]);
        SendMessage::dispatch($request['phone'], false);
        return view('start')->with('task_success', 'Single text message sent successfully');
    }

    public function csvFile(Request $request) {
        $validatedData = $this->validate($request,[
            'csv_file' => 'bail|required|file',
        ]);
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $message_sent_count = 0;

        foreach($data as $number) {
            $actual_num = $number[0];
            // If is a phone number send message
            if (preg_match('/^(1?(-?\d{3})-?)?(\d{3})(-?\d{4})$/', $actual_num)) {
                SendMessage::dispatch($number[0], false);
                $message_sent_count += 1;
            } else {
                Log::warning('File upload ' . $number . ' did not match phone number format');
            }
        }
        return view('start')->with('task_success', 'Doc upload sent ' . $message_sent_count . ' messages successfully.');
    }

    public function downloadResponsesCsv(Request $request) {
        $mytime = Carbon::now();
        $filename = $mytime . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $filename,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $responses = TextResponse::orderBy('created_at', 'DESC')->get();
        $columns = array('Phone number', 'Message');

        $callback = function() use ($responses, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($responses as $response) {
                fputcsv($file, array($response->number, $response->text));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function clear() {
        TextRequest::truncate();
        TextResponse::truncate();

        return 'Cleared';
    }
}
