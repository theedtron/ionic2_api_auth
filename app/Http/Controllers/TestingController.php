<?php

namespace App\Http\Controllers;

use App\User;
use App\VerifyCode;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestingController extends Controller
{
    //

    public function testData()
    {
        $sample = [
            "userId" => 1,
            "id" => 1,
            "title" => "sunt aut facere repellat provident occaecati excepturi optio reprehenderit",
            "body" => "quia et suscipit suscipit recusandae consequuntur expedita et cum reprehenderit molestiae ut ut quas totam nostrum rerum est autem sunt rem eveniet architecto"
        ];

        return response()->json($sample);
    }

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

            //send sms
            $res = $rand;
        }else{
            $res = "Error: User not created";
        }

        return $res;
    }

    public function verify(Request $request){
        $data = $request->json()->all();

        $the_code = VerifyCode::whereCode($data['verification_code'])->first();

        if (isset($the_code)){
            $user = User::whereId($the_code->user_id)->first();

            if ($the_code->code == $data['verification_code']){
                $http = new Client();
                $url = url('oauth/token');
                print_r($url);

                $response = $http->post($url, [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => env('client_id'),
                        'client_secret' => env('client_secret'),
                        'username' => $user->email,
                        'password' => substr($user->email,10),
                        'scope' => '',
                    ],
                ]);
                print_r('here2');

                $res = $response->getBody();
            }else{
                $res = "Error: Code incorrect";
            }
        }else{
            $res = "Error: No user found";
        }

        return $res;
    }
}
