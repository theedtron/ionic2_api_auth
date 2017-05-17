<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\SmsController;
use App\User;
use App\VerifyCode;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    //
    public function register(Request $request){

        $payload = $request->json()->all();

        DB::table('payload')->insert([
            'dump' => \GuzzleHttp\json_encode($payload),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $create_user = User::create([
            'name' => $payload['name'],
            'email' => $payload['phone'].'@mail.com',
            'password' => Hash::make($payload['phone'])
        ]);

        if ($create_user){
            $rand = rand(100000,999999);

            VerifyCode::create([
                'user_id' => $create_user->id,
                'code' => $rand
            ]);

            $res = $rand;

        }else{
            $res = "Error: User not created";
        }

        //send sms
        $sms = new SmsController();
        $send_sms = $sms->sendSms($payload['phone'],$res);

        foreach ($send_sms as $sent){
            echo $sent->status;
        }

        return $res;
    }

    public function verify(Request $request){
        $data = $request->json()->all();
//        print_r($data);exit;

        $the_code = VerifyCode::whereCode($data['verification_code'])->first();

        if (isset($the_code)){
            $user = User::whereId($the_code->user_id)->first();

            if ($the_code->code == $data['verification_code']){
                $http = new Client();
                $url = url('oauth/token');


                $response = $http->post($url, [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => env('client_id'),
                        'client_secret' => env('client_secret'),
                        'username' => $user->email,
                        'password' => substr($user->email, 0, 10),
                        'scope' => '',
                    ],
                ]);

                $result = json_decode((string) $response->getBody(), true);

                $res = $result['access_token'];

            }else{
                $res = "Error: Code incorrect";
            }
        }else{
            $res = "Error: No user found";
        }

        return $res;
    }

    public function receiver(Request $request){
        $payload = $request->json()->all();
        DB::table('payload')->insert([
            'dump' => \GuzzleHttp\json_encode($payload),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        $sms = new SmsController();
        $send = $sms->sendSms($payload['phone'],'Thank you for supporting Bishop Thuku. We are very grateful. God Bless.');

        return $send;
    }
}
