<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Freequote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class FreeQuoteController extends Controller
{



    public function index(Request $req)
    {

        try {


            $validator = Validator::make($req->all(), [
                'movingFrom' => 'required|string',
                'movingTo' => 'required|string',
                'homeSize' => 'required|string',
                'movingDate' => 'required|string',
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'email' => 'required|string',
                'phoneNumber' => 'required|string',
            ]);

            if ($validator->passes()) {

                $save = Freequote::insert([
                    'quote_id'  => 'AXOP_' . mt_rand(0001, 9999),
                    'moving_date' => $req->movingDate,
                    'moving_from' => $req->movingFrom,
                    'moving_to' => $req->movingTo,
                    'home_size' => $req->homeSize,
                    'firstname' => $req->firstName,
                    'lastname' => $req->lastName,
                    'phonenumber' => $req->phoneNumber,
                    'email' => $req->email,
                    'additional_details' => $req->additionalDetails,
                    'source' => $req->howYouHearAboutUs
                ]);


                if (getallheaders()["dev_mode"] != 'staging') {

                    // Mail Admin
                    $this->subject = "FREE QUOTE REQUEST FROM - " . $req->firstName . " " . $req->lastName;

                    $this->message = "<h4>Hello Admin,</h4><br><br> You have received a free quote request from " . $req->firstName . " " . $req->lastName . " <hr> " . $req->additionalDetails . "<br><br> <h4>Contact Information</h4><hr> <p>Name: " . $req->firstName . " " . $req->lastName . "</p> <br> <p>Email: " . $req->email . "</p> <br> <p>Telephone: " . $req->phoneNumber . "</p> <br> <p>How did you hear about us?: " . $req->howYouHearAboutUs . "</p> <br> <p>Moving Date: " . date('d/F/Y', strtotime($req->movingDate)) . "</p> <br> <p>Moving From: " . $req->movingFrom . "</p> <br> <p>Moving To: " . $req->movingTo . "</p> <br> <p>Home Size: " . $req->homeSize . "</p> <hr> <br><br><a href='mailto:" . $req->email . "'>Reply to " . $req->email . "</a>";


                    $this->sendMail($this->to, $this->subject);
                }

                $this->subject = "FREE QUOTE REQUEST SENT";

                $this->message = "<h4>Hello " . $req->firstName . ",</h4><br><br> We have received your request and details stated below <br><br> <h4>Contact Information</h4><hr> <p>Name: " . $req->firstName . " " . $req->lastName . "</p> <br> <p>Email: " . $req->email . "</p> <br> <p>Telephone: " . $req->phoneNumber . "</p> <br> <p>How did you hear about us?: " . $req->howYouHearAboutUs . "</p> <br> <p>Moving Date: " . date('d/F/Y', strtotime($req->movingDate)) . "</p> <br> <p>Moving From: " . $req->movingFrom . "</p> <br> <p>Moving To: " . $req->movingTo . "</p> <br> <p>Home Size: " . $req->homeSize . "</p> <br> <p>Additional Information: " . $req->additionalDetails . "</p> <hr> <br><br><a href='mailto:" . $this->to . "'>Reply to " . $this->to . " if there are any changes to be made.</a>";


                $this->sendMail($req->email, $this->subject);


                $data = ['data' => $save, 'message' => "Quote successfully received. We'll do well to contact shortly."];
                $status = 200;
            } else {

                $error = implode(",", $validator->messages()->all());

                $data = ['data' => [], 'message' => $error];
                $status = 400;
            }
        } catch (\Throwable $th) {
            $data = ['data' => $th->getMessage(), 'message' => 'failed'];
            $status = 400;
        }

        return  $this->returnJSON($data, $status);
    }



}