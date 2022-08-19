<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Contact;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DateTime;
use File;

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

    // $qrCodeReady = QrCode::format('png')->color(255, 165, 0)->backgroundColor(255,255,255)->size(250)->generate($request->get('code'));
    $qrCodeReady = QrCode::format('png')->size(250)->generate($request->get('code'));
    QrCode::format('png')->size(250)->generate($request->get('code'), public_path('qrcodes/' . $request->get('guid') . '.png' ));

    

     Mail::send('qrcode',
        array(
            'guid' => $request->get('guid'),
            'team_name' => $request->get('team_name'),
            'code' => $qrCodeReady,
            'valid_from' => str(date('Y-m-d', strtotime($request->get('valid_from')))),
            'valid_to' => str(date('Y-m-d', strtotime($request->get('valid_to')))),
            'label' => $request->get('label'),
        ), function($message) use ($request)
        {
            $message->subject("Key Manager - Virtual Ticket");
            $message->to($request->get('email'));
        });
        // delete();
    }
    
    // function delete() {
    //     sleep(5);
    // unlink(public_path('qrcodes/' . $request->get('guid') . '.png'));
    // }
}
