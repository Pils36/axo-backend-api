<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Mail;

use App\Mail\sendMail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $to = "info@axopolitan.com";
    public $subject;
    public $message;

    public function sendMail($objDemoa, $purpose)
    {


        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;



        if ($purpose == $this->subject) {
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        Mail::to($objDemoa)->send(new sendMail($objDemo));
    }

    public function returnJSON($data, $status)
    {
        return response()->json($data, $status);
    }

    public function guidv4($data = null) {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
}
