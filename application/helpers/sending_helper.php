<?php 
/**
 * 
 */
class Notification 
{
	
	public static function  sending($subject , $message , $to)
	{
		$ci =& get_instance();
		$config['protocol']    	= 'smtp';
		$config['smtp_host']    = 'ssl://smtp.zoho.com';
		$config['smtp_port']    = '465';
		// $config['smtp_timeout'] = '7';
		$config['smtp_user']    = 'lutfi@awanesia.com';
		$config['smtp_pass']    = 'P4vshCIp2FRj';
		$config['charset']    	= 'utf-8';
		$config['newline']    	= "\r\n";
	    $config['mailtype'] 	= 'text'; // or html
	    $config['validation']	= TRUE; // bool whether to validate email or not      

	    $ci->email->initialize($config);

	    try{

	    	$param = array(
	    		'subject' => $subject,
	    		'message' => $message,
	    		'to' => $to
	    	);

	    	if(empty($param)) throw New \Exception('Params not found', 500);

	    	$ci->email->from('lutfi@awanesia.com', 'Suvi Sanusi');
	    	$ci->email->to($to);

	    	$ci->email->subject($subject);
            $ci->email->message($message);  
            $ci->email->set_mailtype("html");
	    	$ci->email->send(); 

	    	$status   = 200;
	    	$data     = empty($ci->email->print_debugger()) ? 'Berhasil Kirim' : $ci->email->print_debugger();
	    	$errorMsg = null;
	    }catch(\Exception $e){
	    	$status   = $e->getCode() ? $e->getCode() : 500;;
	    	$data     = null;
	    	$errorMsg = $e->getMessage();
	    }
	    return json_encode(['status' => $status , 'data' => $data , 'message' => $errorMsg]);
	}
}
