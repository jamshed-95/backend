<?php


namespace App\Http\Controllers;

use App\Mail\FollowMail;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function mailer($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return  2;
        }
     try {
            Mail::to(env("MAIl_TO_ADDRESS"))->send(new FollowMail($email));
            return 1;
        }catch (\Exception $ex){
            return  2;
        }
    }

    public  function dataParser($data){
        if ($data){
            foreach ($data as &$dt){
                foreach ($dt as $kay => $blog){
                    $dt[$kay] = '\''.$blog.'\'';
                }
            }
            unset($dt);
            return $data;
        }
        return  null;
    }

    public  function sendToBubble($email){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return  2;
        }

        $url = "https://swiftle-app.bubbleapps.io/api/1.1/wf/add_new_subscriber";
        $client = new Client();
        try {
           $send =   $client->post($url, [
               RequestOptions::JSON => ['email' => $email]
            ]);
            return  1;
        }catch (\Exception $e){
            $response['status'] = 'Connect Exception';
            $response['message'] = $e->getMessage();
            return  2;
        }

    }

}
