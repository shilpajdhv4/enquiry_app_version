<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cookie;

class SendUserUnreadMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:unreadmessages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the user an email of their unread messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    
    public function handle()
    {
        $id = Cookie::get('mobile_no');
        $tokens = \App\Employee::select('toekn')->where(['mobile_no'=>$id])->first();
        $employee = \App\Employee::where(['mobile_no'=>$id])->count();
        $conn = mysqli_connect("localhost","root","","enquiry_app");
      $sql = "select token,id from tbl_employees";
		$result = mysqli_query($conn,$sql);
		$tokens = array();
		if(mysqli_num_rows($result) > 0 ){
			while ($row = mysqli_fetch_assoc($result)) {
				$tokens[] = $row["token"];
				$id[] = $row['id']; 
                                $message[]= "FCM Push Notification: Hello Laravel!";
			}
		}
	mysqli_close($conn);
//        if(Auth::guard('employee')->check()){
       // $guard = $request->getGuard();
            $id = Cookie::get('logged_id');//Auth::guard($guard)->user()->id;//Cookie::get('logged_id');
//        }
	//$message = array("message" => " FCM Push Notification: Hello Laravel!");
	//$message_status = send_notification($tokens, $message);
	//echo $message_status;
        
        
        $url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			 'registration_ids' => $tokens,
			 'data' => $message
			);
			
		print_r($fields);
		
		$headers = array(
			'Authorization:key=AIzaSyC9US8Sm1i0JsBoQ7Z75L3xiGqjcV7jOBo',
			'Content-Type:application/json'
			);
	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);
       return $result;
	
    }
    
    public function send_notification($device_id, $message=""){
        
    }
}
