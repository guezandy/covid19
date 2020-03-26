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

    const FIRST_MESSAGE = 'Please help with a donation';
    const FOLLOWUP_MESSAGE = 'We will be in touch';

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
        $this->message = $final_reply ? SendMessage::FOLLOWUP_MESSAGE : SendMessage::FIRST_MESSAGE;
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

        if (!$this->final_reply) {
            // Don't send texts twice
            $request_exist = TextRequest::where('number', $this->recipient)->first();
            if (isset($request_exist)) {
                // We've already messaged this person
                $request_exist->attempts += 1;
                $request_exist->save();
                return;
            }

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
