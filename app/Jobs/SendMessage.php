<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Twilio\Rest\Client;
use App\Request as TextRequest;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recipient;
    protected $message;
    protected $final_reply;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipient, $final_reply)
    {
        //
        $this->recipient = $recipient;
        $this->message = $final_reply ? "We will be in touch" : "Please help with a donation";
        $this->final_reply = $final_reply;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $messaging_sid = getenv("TWILIO_MESSAGING_SERVICE_SID");

        $client = new Client($account_sid, $auth_token);

        // $request_exist = TextRequest::where('number', $this->recipient)->first();
        // if (isset($request_exist)) {
        //     // We've already messaged this person
        //     $request_exist->attempts += 1;
        //     $request_exist->save();
        //     return;
        // }

        if (!$this->final_reply) {
            $request = new TextRequest;
            $request->number = $this->recipient;
            $request->attempts = 1;
            $request->success = 1;
            $request->text = $this->message;
            $request->save();
        }

        $client->messages->create(
            $this->recipient,
            array(
                'from' => $twilio_number,
                'body' => $this->message,
                'messagingServiceSid' => $messaging_sid
            )
        );
    }
}
