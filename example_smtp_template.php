<?php

require('system/config.php');
require('system/phpmailer/PHPMailerAutoload.php');
require('system/phpmailer/OMMail.php');

$data = array();
$data['from_name'] = "hello world";
$data['from_email'] = "hello@test.com";
$data['transactional_group'] = "TEST TRANSACTIONAL"; // ชื่อของกลุ่ม transactional ลักษณะคล้ายกับ ชื่อของ campaign
$data['transactional_priority'] = "0"; // ความสำคัญของ email : 0 = ปกติ , 1 = สูง
$data['transactional_report'] = "Full"; // โหมด report จำเป็นต้องใส่ web service ที่ เว็บไซท์ https://th4-app.taximail.com/settings/event-triggers : False = ปิดโหมดรีพอร์ต , Unique = รีพอร์ตเฉพาะข้อมูลที่ ยูนิค , Full = รีพอร์ตทุกข้อมูล
$data['subject'] = "Test Normal Html";
$data['content_html'] = '{"CF_link":"http://google.co.th","CF_promocode":"XXXX001"}'; // ค่าของ custom field ที่ต้องการนำไปแทนค่า
$data['content_plain'] = "Hello World";
$data['template_key'] = "101459c34404a75cb "; // template key ที่ต้องการจะส่ง
$data['attachment'] = array();

//addAttachment($data['attachment'],"Hello_world.docx","stocks/Hello_world.docx");  // กรณีต้องการแนบไฟล์

$data['to_email'] = array();

// EXAMPLE หากต้องการส่งอีเมลล์ให้หลาย address ครับ //

$message_id = ""; // ** เป็นชุดตัวเลขที่ใช้สำหรับ track ข้อมูลของการส่งอีเมลล์ อีเมลล์แต่ละฉบับไม่ควรซ้ำกัน หากใส่ค่าว่าง จะทำการ generate ชุดตัวเลขขึ้นมาให้ครับ
$get_message_id = genMessageID($message_id);
addAddress($data['to_email'],"toname","test@taximail.com",$get_message_id);

// ------------------------------------------- //

sendMail($data);


function addAttachment(&$ret_data,$filename,$path_file){
	$tmp_att = array();
	$tmp_att['filename'] = $filename;
	$tmp_att['path_file'] = $path_file;
	$ret_data[] = $tmp_att;
}

function genMessageID($message_id){
	if($message_id == ""){
		$time = strtotime(date('Y-m-d H:i:s'));
		$characters = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	  	$out = "";
	  	for($i=0;$i<5;$i++){
			$rand_num = rand(0,60);
			$alpha_out = $characters[$rand_num];
			$out = $out.$alpha_out;
		}
		$message_id = md5("MESSAGE"."_".$time."_".$out);
	}
	return $message_id;
}

function addAddress(&$ret_data,$to_name,$to_email,$message_id){
	$tmp_to_email = array();
	$tmp_to_email['to_name'] = $to_name;
	$tmp_to_email['to_email'] = $to_email;
	$tmp_to_email['message_id'] = $message_id;
	$ret_data[] = $tmp_to_email;
}

function sendMail($param){
	$mail = new OMMail(false,json_decode(SMTP_DATA,true));
	$mail->IsHTML(true);
	$mail->SMTPSecure = "tls"; 
	$mail->AuthType = "CRAM-MD5";
	$mail->CharSet = 'UTF-8';
	$mail->Encoding = 'base64';
	$mail->SMTPDebug = 2;

	foreach ($param['to_email'] as $key => $value) {
		$mail->ClearCustomHeaders();
	    $mail->ClearAllRecipients();
	    $mail->ClearAttachments();
		$mail->From = $param['from_email'];
		$mail->FromName = $param['from_name'];
		$mail->addAddress($value['to_email'], $value['to_name']); 
		$mail->addCustomHeader(TRANSACTIONAL_GROUP_HEADER.": ".$param['transactional_group']);
		$mail->addCustomHeader("X-Transaction-Priority: ".$param['transactional_priority']);
		$mail->addCustomHeader(MESSAGE_ID_HEADER.": ".$value['message_id']);
		$mail->addCustomHeader(TRANSACTIONAL_REPORT_HEADER.": ".$param['transactional_report']);
		$mail->addCustomHeader(TRANSACTIONAL_TEMPLATE_HEADER.": ".$param['template_key']);
		$mail->Subject = $param['subject'];
		$mail->Body = $param['content_html'];
		$mail->AltBody = $param['content_plain'];
		foreach ($param['attachment'] as $key1 => $value1) {
			$mail->AddAttachment($value1['path_file'],$value1['filename']); 
		}
		$check_status = $mail->send();
		if($check_status){
			echo "Success<br>";
		}else{
			echo "Failed<br>";
		}
	}
}

?>