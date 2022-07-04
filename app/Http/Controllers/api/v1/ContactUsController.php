<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(){

        try {
            $data = ['data' => 'Success request', 'message' => 'success'];
            $status = 200;
        } catch (\Throwable $th) {
            $data = ['data' => $th->getMessage(), 'message' => 'failed'];
            $status = 400;
        }

       return  $this->returnJSON($data, $status);
    }
}