<?php
include ROOT_DIR . "system/phpmailer/class.phpmailer.php";
class OMMailer extends PHPMailer 
{
	private $smarty = null;
	public function __construct($exceptions = false) {
		$this->exceptions = ($exceptions == true);
		
		$this->IsSMTP();
		$this->Host = WCMSetting::$SMTP_SERVER_HOSTNAME; 			// specify main and backup server
		$this->Username =  WCMSetting::$SMTP_SERVER_USERNAME;  // SMTP username
		if($this->Username == ""){
			$this->SMTPAuth = false;     		// turn on SMTP authentication
		}else{
			$this->SMTPAuth = true;     		// turn on SMTP authentication
		}
		$this->Password =  WCMSetting::$SMTP_SERVER_PASSWORD; 	// SMTP password
		$this->Port = WCMSetting::$SMTP_SERVER_PORT; 			// SMTP password
		$this->Timeout = 300;
		$this->SMTPKeepAlive = true;		// use with $this->SmtpClose();
		// $this->IsHTML(true);
		$this->Mailer   = "smtp";
		$this->CharSet = "UTF-8";
		$this->smarty = new OMPage();
		
	}
	
	public function assign($key, $val) {
		$this->smarty->assign($key, $val);
	}
	public function fetch($name) {
		return $this->smarty->fetch($name);
	}
	public function sendMail(){
		return $this->Send();
	}
}
?>