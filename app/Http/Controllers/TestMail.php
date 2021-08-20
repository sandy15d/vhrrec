<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SampleMail;
use Illuminate\Support\Facades\Mail;
use Snowfire\Beautymail\Beautymail;

class TestMail extends Controller
{
    public function sendMail()
    {
        $details = [
            "subject"=>"MRF Created by Sandeep",
            "title" =>"Sample Title From Mail",
            "body" =>"This is sample content we have added for this test mail"
        ];
        Mail::to("sandeepdewangan.vspl@gmail.com")->send(new SampleMail($details));
        echo "<h3>Mail Sent successfully!</h3>";
    }


    public function sendMail1()
    {
        $beautymail = app()->make(Beautymail::class);
        $beautymail->send('emails.welcomemail', [], function($message)
        {
            $message
                ->from('sandeepdewangan2012@gmail.com')
                ->to('sandeepdewangan.vspl@gmail.com', 'Sandeep Dewangan')
                ->subject('Welcome!');
        });
    }
}
