<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Mail\EmailContactos;
use Illuminate\Support\Facades\Mail;

class EnviarEmail 
{
    public static function enviar(Request $request)
    {
        $status = true;
        $tentativas = 5;
        while($status == true)
        {
            try {
                Mail::to(config('app.email_to_address'))->send(new EmailContactos($request));
                break;

            }
            catch(\Exception $e)
            {
                if($tentativas > 0)
                {
                    $tentativas--;
                }
                else {
                    $status = false;
                    return false;
                }
            }

            return true;
        }

        return $status;

    }
}