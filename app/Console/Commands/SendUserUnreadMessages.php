<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Cookie;
use Illuminate\Support\Facades\Auth;

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
//    public function handle()
//    {
//        $tokens = 'f3-3moJK64Y:APA91bECQPcYArtET_zlTCDd5SzLmyRsNZPg32Zm6I99iYp6JP2941oqkeFTkED83w_lo9NcU2XBhtN1LrxL4WrGCGuVvOQdGnzmeqznxxbPbmqcleuP7rAPT8d5P8K0zz6h2vjVARtp';
//        $message = array("message" => "Today You Have a Folloup's");
//        $this->send_notification($tokens,$message);
//    }
//    
    
    public function handle()
    {
     // $conn = mysqli_connect("localhost","ipinguser","iPing@321","enquiry_app");
     // $sql = "select token,id from tbl_employees";
        $result = \App\Employee::select('token','id')->get();
        //$result = mysqli_query($conn,$sql);
        $date = date('Y-m-d');
        $tokens = array();
        if(count($result) > 0 ){
            foreach ($result as $row) {
                $today_notification = \App\Enquiry::where(['enq_emp_id'=>$row['id'],'enq_followup_date'=>$date])->where('order_status','!=',0)->count();
                $tokens = array($row['token']);
                $message = array("message" => "Today You Have a '.$today_notification.' Folloup's Server");
                $this->send_notification($tokens,$message);
            }
        }
    }


                                    


    public function send_notification($tokens,$message=""){
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
}
