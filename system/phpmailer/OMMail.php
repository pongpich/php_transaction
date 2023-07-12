<?php
include "system/phpmailer/class.phpmailer.php";
class OMMail extends PHPMailer 
{
	private $smarty = null;
	public function __construct($exceptions = false,$data) {
		$this->exceptions = ($exceptions == true);
		
		$this->IsSMTP();
		// $this->Host = WCMSetting::$SMTP_SERVER_HOSTNAME; 			// specify main and backup server
		// $this->Username =  WCMSetting::$SMTP_SERVER_USERNAME;  // SMTP username
		// if($this->Username == ""){
		// 	$this->SMTPAuth = false;     		// turn on SMTP authentication
		// }else{
		// 	$this->SMTPAuth = true;     		// turn on SMTP authentication
		// }
		// $this->Password =  WCMSetting::$SMTP_SERVER_PASSWORD; 	// SMTP password
		// $this->Port = WCMSetting::$SMTP_SERVER_PORT; 			// SMTP password
		$this->Host = $data['host']; 			// specify main and backup server
		$this->Username =  $data['username'];  // SMTP username
		if($this->Username == ""){
			$this->SMTPAuth = false;     		// turn on SMTP authentication
		}else{
			$this->SMTPAuth = true;     		// turn on SMTP authentication
		}
		$this->Password =  $data['password']; 	// SMTP password
		$this->Port = $data['port']; 
		$this->Timeout = 300;
		$this->SMTPKeepAlive = true;		// use with $this->SmtpClose();
		// $this->IsHTML(true);
		$this->Mailer   = "smtp";
		$this->CharSet = "UTF-8";
		
		//$this->Encoding = "base64";
		/* 
		$mail->Host = "smtp.gmail.com";  // specify main and backup server
		$mail->SMTPAuth = true;     // turn on SMTP authentication
		$mail->Username = "taximailsystem@gmail.com";  // SMTP username
		$mail->Password = "0rism@taxi"; // SMTP password
		$mail->Port = 465; // SMTP password
		$mail->SMTPSecure = "ssl";
		 */
		
	}
	public function sendMail(){
		return $this->Send();
	}
}
?>