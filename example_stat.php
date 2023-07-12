<?php

require('system/config.php');

$RefMessageID = "d61c4e2489fc4229799b84e8efdfa8a2"; // MessageID ที่ใช้ในการ ส่ง email

$result = Login();
if($result['status'] == 'success'){
	$session_id = $result['data']['session_id'];
	$url = WEB_BASE_API."transactional/".$RefMessageID;
	$param = array();
	$param['session_id'] = $session_id; 
	$result = cURL('GET',$url,$param);
	echo json_encode($result);
}else{
	echo "Login Failed!! : ".$result['ErrorMessage'];
}


/*    - - - - - EXAMPLE RESPONSE - - - - -
{
    "Success": true,
    "ErrorCode": "",
    "ErrorMessage": "",
    "data": {
        "email": "chanwit@orisma.com", // email ที่ใช้สำหรับส่ง
        "ready": "2014-12-22 14:53:36", // เวลาที่เข้าระบบ transactional
        "sent": "2014-12-22 14:53:37", // เวลาที่ส่ง email ออกจากระบบ
        "open": [
            "2014-12-22 14:53:43" // แสดงระยะเวลาที่เปิด email
        ],
        "open_count": 1, // จำนวนในการเปิด email
        "click": [
            {
                "date": "2014-12-22 15:17:15", แสดงระยะเวลา และ ลิ้งที่ถูก click
                "url": "www.google.co.th"
            }
        ],
        "click_count": 1 แสดงจำนวนที่ click link ใน email
    }
}
	- - - - - - - - - - - - - - - - - - - - - -
*/ 

function Login(){
	$url = WEB_BASE_API.'user/login';
    $param = array();
    $param['username'] = WEB_LOGIN_EMAIL;
    $param['password'] = WEB_LOGIN_PASSWORD;
    $param['remember'] = 'T';
	$result = cURL('POST',$url,$param);
    $result = json_decode($result,true);
	return $result;
}

function cURL($mode="POST",$url=NULL,$params=array(),$opts=array()){
    if ($mode == "") {
        $mode = "POST";
    }

    if(isset($mode) && strtoupper($mode) == "GET"){
        $query_str = "";
        foreach ($params as $key => $value) {
            if($query_str != ""){
                $query_str .= "&";
            }
            $query_str .= $key."=".urlencode($value);
        }
        if($query_str != ""){
            $url .= "?".$query_str;
        }
    }else{
        $params = http_build_query($params);
        $opts[CURLOPT_POSTFIELDS] = $params;
    }
    
    $ch = curl_init();    // initialize curl handle

    if (strtoupper($mode) != "POST" && strtoupper($mode) != "GET") {
        $opts[CURLOPT_CUSTOMREQUEST] = strtoupper($mode);
    }
    
    $opts[CURLOPT_URL] = $url;

        if (isset($opts[CURLOPT_HTTPHEADER])) {
          $existing_headers = $opts[CURLOPT_HTTPHEADER];
          $existing_headers[] = "Expect:";
          $opts[CURLOPT_HTTPHEADER] = $existing_headers;
        } else {
          $opts[CURLOPT_HTTPHEADER] = array("Expect:","REQUESTFROM:127.0.0.1");
        }
    curl_setopt_array($ch, $opts);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch); // run the whole process
    curl_close($ch);
    return $result;
}

?>