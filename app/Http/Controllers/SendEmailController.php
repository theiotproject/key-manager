<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Contact;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendEmailController extends Controller
{
    function send(Request $request)
    {
        $this->validate($request, [
        'name'     =>  'required',
        'email'  =>  'required|email',
        'subject' => 'required',
        'message' =>  'required'
        ]);

        $contact = new Contact;

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;

        $contact->save();

        Mail::send('contact_email',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'subject' => $request->get('subject'),
                'user_message' => $request->get('message'),
            ), function($message) use ($request)
            {
                $message->subject($request->subject);
            //   $message->from('contact@theiotproject.com');
                $message->to('contact@theiotproject.com');
            });
    }


    function sendQrCode(Request $request) {
        $this->validate($request, [
      'email'  =>  'required|email',
     ]);

     Mail::send('qrcode',
        array(
            'team_name' => $request->get('team_name'),
            'code' => $request->get('code'),
            'valid_from' => $request->get('valid_from'),
            'valid_to' => $request->get('valid_to'),
            'label' => $request->get('label'),
        ), function($message) use ($request)
        {
            $message->subject("Key Manager - Virtual Ticket");
            $message->to($request->get('email'));
        });
    }
}
