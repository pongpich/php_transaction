<?php

$smtp_data = array();
$smtp_data['host'] = "smtp.taximail.com"; // SMTP TRANSACTIONAL HOST
$smtp_data['username'] = "test"; 			// SMTP TRANSACTIONAL USERNAME
$smtp_data['password'] = "test"; // SMTP TRANSACTIONAL PASSWORD
$smtp_data['port'] = "587"; 				// SMTP TRANSACTIONAL PORT

define("SMTP_DATA",  json_encode($smtp_data));

define("TRANSACTIONAL_GROUP_HEADER", "X-Transactional-Group"); // ค่าต้องเหมือนกับ ฟิลด์ Transactional Group Header
define("MESSAGE_ID_HEADER", "X-REF-MESSAGE-ID"); // ค่าต้องเหมือนกับ ฟิลด์ Message ID Header
define("TRANSACTIONAL_REPORT_HEADER", "X-Transactional-Report"); // ค่าต้องเหมือนกับ ฟิลด์ Transactional Report Header จำเป็นต้องเปิด Transactional Report Status ให้เป็น enabled ก่อน

define("WEB_BASE_API",  "https://api.taximail.com/v2/");
define("WEB_LOGIN_EMAIL",  "test@taximail.com"); // login email
define("WEB_LOGIN_PASSWORD",  "test"); // login password

?>