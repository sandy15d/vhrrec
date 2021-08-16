<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Mail;

class TestMail extends Controller
{
    public function sendMail()
    {
        $details = [
            "title" =>"Sample Title From Mail",
            "body" =>"This is sample content we have added for this test mail"
        ];
        Mail::to("sandeepdewangan.vspl@gmail.com")->send(new SampleMail($details));
        echo "<h3>Mail Sent successfully!</h3>";
    }
}
