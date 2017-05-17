<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Controllers\AfricasTalkingGateway;
use App\CustomMessage;
use Cartalyst\Sentry;
use Illuminate\Support\Facades\Mail;

class SmsController extends Controller {

//    protected $_username;
//    protected $_apiKey;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {

    }



    public  function index()
    {
        //tests

    }

//    public function sendEmail($to,$message){
//        $user = "";
//
//        $title = "Mail from Ed";
//
//        Mail::send('welcome', ['title' => $title, 'content' => $message, 'mailee' => $to], function ($message) {
//            $message->from('kareowdwin@gmail.com', 'Totohealth');
//
//            $message->to('kareoedwin@yahoo.com');
//        });
//
//    }

    public function sendSms($to,$message){
        // Be sure to include the file you've just downloaded
        $to = substr($to, -9);

        // require_once('../libraries/AfricasTalkingGateway.php');

        // Specify your login credentials
        $username   = env('AT_USERNAME');
        $apikey     = env('AT_API_KEY');

        // Specify the numbers that you want to send to in a comma-separated list
        // Please ensure you include the country code (+254 for Kenya in this case)
        $recipients = '+254'.$to; //can be comma separeted

        // Create a new instance of our awesome gateway class
        $gateway    = new AfricasTalkingGateway($username, $apikey);

        // Any gateway errors will be captured by our custom Exception class below,
        // so wrap the call in a try-catch block
        try
        {
            // Thats it, hit send and we'll take care of the rest.
            $results = $gateway->sendMessage($recipients, $message);
            if($results){
                foreach($results as $result) {
                    // Note that only the Status "Success" means the message was sent
//                    echo " Number: " .$result->number;
//                    echo " Status: " .$result->status;
//                    echo " MessageId: " .$result->messageId;
//                    echo " Cost: "   .$result->cost."\n";
                }
                return $results;
            }else{
                return 0;
            }

        }
        catch ( AfricasTalkingGatewayException $e )
        {
            echo "Encountered an error while sending: ".$e->getMessage();
        }

        // DONE!!!

    }


    /*
     * Check if sms send success
     */
    public function delivery_report(){
        $status = $_POST['status']; //This contains the status as described above
        $messageId = $_POST['id']; //This is the messageId received when the message was sent
        //This parameter is passed when status is Rejected or Failed.
        if($status == "Failed" || $status == "Rejected")
            $failureReason = $_POST['failureReason'];
    }


    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
