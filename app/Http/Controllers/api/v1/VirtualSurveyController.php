<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Models\Virtualsurvey;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VirtualSurveyController extends Controller
{
    public function index(Request $req)
    {

        try {

            $validator = Validator::make($req->all(), [
                'movingFrom' => 'required|string',
                'movingTo' => 'required|string',
                'homeSize' => 'required|string',
                'visitDate' => 'required|string',
                'visitTime' => 'required|string',
                'modeOfVisit' => 'required|string',
                'address' => 'required|string',
                'firstName' => 'required|string',
                'lastName' => 'required|string',
                'email' => 'required|string',
                'phoneNumber' => 'required|string',
            ]);

            if ($validator->passes()) {
                $req['survey_id'] = $this->guidv4();
                $save = Virtualsurvey::insert($req->all());


                if (getallheaders()["dev_mode"] != 'staging') {

                    // Mail Admin
                    $this->subject = "BOOK VIRTUAL SURVEY FROM - " . $req->firstName . " " . $req->lastName;

                    $this->message = "<h4>Hello Admin,</h4><br><br> You have received a virtual survey booking request from " . $req->firstName . " " . $req->lastName . " with survey ID: ".$req['survey_id']." <br><br> <h4>Contact Detailed Information</h4><hr> <p>Home Size: " . $req->homeSize . "</p> <br> <p>Visit Date: " . date('d/F/Y', strtotime($req->visitDate)) . "</p> <br> <p>Visit Time: " . $req->visitTime . "</p><br><p>Mode Of Visit" . $req->modeOfVisit . "</p> <br> <p>Location/Address" . $req->address . "</p> <br> <p>Moving From: " . $req->movingFrom . "</p> <br> <p>Moving To: " . $req->movingTo . "</p> <br> <p>Contact Person (First Name): " . $req->firstName . "</p><br> <p>Contact Person (Last Name): " . $req->lastName . "</p><br> <p>Contact Person (Phone Number): " . $req->phoneNumber . "</p><br> <p>Contact Person (Email): " . $req->email . "</p><br> <p>Additional Message: <b>" . $req->additionalDetails . "</b></p> <br> <p>How did you hear about us?: " . $req->howYouHearAboutUs . "</p> <hr> <br><br><a href='mailto:" . $req->email . "'>Reply to " . $req->email . "</a>";

                    $this->sendMail($this->to, $this->subject);
                }

                $this->subject = "BOOK VIRTUAL SURVEY SENT";

                $this->message = "<h4>Hello " . $req->firstName . ",</h4><br><br> We have received your request and details stated below with survey ID: <b>".$req['survey_id']."</b> <br><br> <h4>Contact Information</h4><hr> <p>Name: " . $req->firstName . " " . $req->lastName . "</p> <br> <p>Email: " . $req->email . "</p> <br> <p>Telephone: " . $req->phoneNumber . "</p> <br> <p>How did you hear about us?: " . $req->howYouHearAboutUs . "</p> <br> <p>Moving Date: " . date('d/F/Y', strtotime($req->movingDate)) . "</p> <br> <p>Moving From: " . $req->movingFrom . "</p> <br> <p>Moving To: " . $req->movingTo . "</p> <br> <p>Home Size: " . $req->homeSize . "</p> <br> <p>Mode of Visit: " . $req->modeOfVisit . "</p> <br> <p>Visit Time: " . $req->visitTime . "</p> <br> <p>Location/Address: " . $req->address . "</p><br> <p>How did you hear about us?: " . $req->howYouHearAboutUs . "</p> <br> <p>Additional Information: " . $req->additionalDetails . "</p> <hr> <br><br><a href='mailto:" . $this->to . "'>Reply to " . $this->to . " if there are any changes to be made.</a>";


                $this->sendMail($req->email, $this->subject);


                $data = ['data' => $save, 'message' => "Survey successfully received. We'll do well to contact shortly."];
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