<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Mail;

class QRController extends Controller
{
    // public function generateQrCode()
    // {
    //     \QrCode::class::size(500)
    //             ->format('png')
    //             ->generate('codingdriver.com', public_path('images/qrcode.png'));

    //     return view('qrcode');
    // }

    public function generateQrCode()
    {
             Mail::send('qrcode',
            function($message)
               {
                  $message->subject("Key Manager - Virtual Ticket");
                  $message->to('contact@theiotproject.com');
               });

        // \QrCode::class::size(500)
        //         ->email('slawek@qware.pl', 'Welcome to Coding driver!.');
        // return view('qrcode');
    }
}
