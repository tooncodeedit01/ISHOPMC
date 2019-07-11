<?php
// Script by NowKung_ 
require('setting.php');
if(isset($_GET['login'])) {
	if(empty($_POST['username']) || empty($_POST['password']))  {
		DisplayMSG('error','Error', 'กรุณาอย่าเว้นช่องว่าง.','false');
		}
	$username = $connect->real_escape_string($_POST['username']);
	$password = $_POST['password'];
	$query = $connect->query('SELECT * FROM user WHERE username = "'.$username.'" and password = "'.$password.'" ');
	$username_check = $query->num_rows;
	$account = $query->fetch_assoc();
  if($username_check == 0){
	  DisplayMSG('error','Error', 'ชื่อผู้ใช้์ หรือ รหัสผ่านไม่ถูกต้อง.','false');
  }
  if($account['ban'] == "true"){
	  DisplayMSG('error','Banned !!!', 'บัญชีของคุณถูกแบนถาวร !!!','false');
  }else {
	  $_SESSION['username'] = $username;
	  $connect->query("UPDATE `user` SET `ip` = '".$_SERVER['REMOTE_ADDR']."' WHERE `user`.`username` = '$username' ;");
	  DisplayMSG('success','Login Success !!!', 'เข้าสู่ระบบสำเร็จ !!','true');
  }
}
if(isset($_GET['register'])) {
	if(empty($_POST['username']) || empty($_POST['password']))  {
	   DisplayMSG('error','Error', 'กรุณาอย่าเว้นช่องว่าง.','false');
		}
	if (!preg_match('/^[a-zA-Z0-9\_]*$/', $_POST['username'])) {
		DisplayMSG('error','Error', 'ชื่อผู้ใช้ไม่ถูกต้อง ต้องเป็น A-Z 0-9 เท่านั้น !!.','false');
	}
	if(mb_strlen($_POST['username']) <= 4) {
		DisplayMSG('error','Error', 'ชื่อผู้ใช้อย่างน้อย 5 ตัวขึ้นไป !!','false');
	}
	if(mb_strlen($_POST['username']) >= 25) {
		DisplayMSG('error','Error', 'ชื่อผู้ใช้สูงสุด 24 ตัวขึ้นไป !!','false');
	}
	if(strlen($_POST['password']) <= 4) {
		DisplayMSG('error','Error', 'รหัสผ่านอย่างน้อย 5 ตัวขึ้นไป !!','false');
	}
	if(mb_strlen($_POST['password']) >= 25) {
		DisplayMSG('error','Error', 'รหัสผ่านสูงสุด 24 ตัว !!','false');
	}
	if($_POST['password'] != $_POST['repassword'])  {
	  DisplayMSG('error','Error', 'รหัสผ่าน ไม่ตรงกัน !!','false');
		}
	if (trim($_POST['captcha']) != $_SESSION['cap_code']){
		DisplayMSG('error','Error', 'รหัสความปลอดภัย ไม่ถูกต้อง !!!','false');
	}
	$username = $connect->real_escape_string($_POST['username']);
	$password = $_POST['password'];
	$query = $connect->query('SELECT * FROM user WHERE username = "'.$username.'" ');
	$username_check = $query->num_rows;
  if($username_check >= 1){
	  DisplayMSG('error','Error', ' มีผู้ใช้งานไปแล้ว !!!','false');
  }else {
	  $query = $connect->query
	  ('
		INSERT INTO `user` (`id`, `username`, `password`, `ip`, `point`, `ban`, `rank`) VALUES 
		(NULL, "'.$username.'", "'.$password.'", "'.$_SERVER['REMOTE_ADDR'].'", "0", "false", "Member");
	  ');
	  DisplayMSG('success','Register Success !!!', 'สมัครสมาชิกสำเร็จ !!!..','true');
  }
}
if(isset($_SESSION['username'])) {
		$user = $connect->query(' SELECT * FROM `user` WHERE `username` = "'.$_SESSION['username'].'" ')->fetch_assoc();
		if(isset($_GET['cpassword'])) {
			if(empty($_POST['password_old']) || empty($_POST['password_new']) || empty($_POST['repassword_new']) || empty($_POST['captcha']))  {
				DisplayMSG('error','Error', 'กรุณาอย่าเว้นช่องว่าง.','false');
				}
			if(strlen($_POST['password_new']) <= 4) {
				DisplayMSG('error','Error', 'รหัสผ่านอย่างน้อย 4 ตัวขึ้นไป !!','false');
				exit();
			}
			if(mb_strlen($_POST['password_new']) >= 21) {
				DisplayMSG('error','Error', 'รหัสผ่านสูงสุด 20 ตัว !!','false');
				exit();
			}
			if($_POST['password_new'] != $_POST['repassword_new'])  {
			  DisplayMSG('error','Error', 'รหัสผ่าน ไม่ตรงกัน !!','false');
				}
			if (trim($_POST['captcha']) != $_SESSION['cap_code']){
				DisplayMSG('error','Error', 'รหัสความปลอดภัย ไม่ถูกต้อง !!!','false');
			}
			$password = $connect->real_escape_string($_POST['password_old']);
			$password_query = $connect->query('SELECT * FROM user WHERE username = "'.$user['username'].'" and password = "'.$password.'" ');
			$password_check = $password_query->num_rows;
		  if($password_check == 0){
			  DisplayMSG('error','Error', 'รหัสเก่าไม่ถูกต้อง.','false');
		  }else {
			  $password_new = $_POST['password_new'];
			  $connect->query("UPDATE `user` SET `password` = '$password_new' WHERE `user`.`id` = ".$user['id']);
			  session_destroy();
			  DisplayMSG('success','Change Password !!!', 'เปลี่ยนรหัสผ่านสำเร็จ','true');
		  }
		}
	if(isset($_GET['truemoney'])) {
			if(empty($_SESSION['username']) || empty($_POST['truemoney'])) {
				DisplayMSG('error','Error', 'กรุณาอย่าเว้นช่องว่าง.','false');
		}
			if(!is_numeric($_POST['truemoney']) || strlen($_POST['truemoney'])!='14' || $_POST['truemoney'] < 1) { 
				DisplayMSG('error','Error', 'กรุณากรอกเลขทรูมันนี่ให้ถูกต้อง.','false');
		}
			$ijson = WALLET('https://payment-gateway.itorkungz.me/truemoney?card='.$_POST['truemoney']);
			$itopup = json_decode($ijson, true);
			if($itopup['code'] == 3) {
				DisplayMSG('error','Error', 'กรุณาติดต่อแอดมิน !!','false');
			}
			if($itopup['code'] == 2) {
				DisplayMSG('error','Error', 'บัตรทรูมันนี่ ถูกใช้ไปแล้ว..','false');
			}
			if ($itopup['code'] == 1) {
			$point = $itopup['amount'] * $config['promotion_tm'];
			$connect->query("  INSERT INTO `log_topup` (`id`, `value`, `transaction`, `time`, `point`, `amount`, `username`, `status`) VALUES (NULL, 'Truemoney', '".$_POST['truemoney']."', '".time()."', '".$amount."', '".$itopup['amount']."', '".$user['username']."', 'success'); ");
			$connect->query("UPDATE `user` SET `point` = point+'$point' WHERE `user`.`id` = ".$user['id']);
				DisplayMSG('success','Success Topup', 'เติมเงินสำเร็จ <br>จำนวน : '.$itopup['amount'].' บาท <br>ได้รับพ้อย : '.$amount.' <i class="fas fa-gift"></i>.','false');
			}else{
				$connect->query("  INSERT INTO `log_topup` (`id`, `value`, `transaction`, `time`, `point`, `amount`, `username`, `status`) VALUES (NULL, 'Truemoney', '".$_POST['truemoney']."', '".time()."', '0', '0', '".$user['username']."', 'fail'); ");
				DisplayMSG('error','Error', 'บัตรทรูมันนี่ ไม่ถูกต้อง..','false');
			}
		}
	if(isset($_GET['truewallet'])) {
			if(empty($_SESSION['username']) || empty($_POST['truewallet'])) {
				DisplayMSG('error','Error', 'กรุณาอย่าเว้นช่องว่าง.','false');
		}
			if(!is_numeric($_POST['truewallet']) || strlen($_POST['truewallet'])!='14' || $_POST['truewallet'] < 1) { 
				DisplayMSG('error','Error', 'กรุณากรอกเลขทรูมันนี่ให้ถูกต้อง.','false');
		}
			$ijson = WALLET('https://payment-gateway.itorkungz.me/truewallet?transaction='.$_POST['truewallet']);
			$itopup = json_decode($ijson, true);
			if($itopup['code'] == 3) {
				DisplayMSG('error','Error Topup', 'กรุณาติดต่อแอดมิน !!','false');
			}
			$transaction = $connect->query('SELECT * FROM log_topup WHERE transaction = "'.$_POST['truewallet'].'" AND value = "Truewallet" ');
			$transaction = $transaction->num_rows;
			  if($transaction >= 1){
				  DisplayMSG('error','Error Topup', 'เลขอ้างอิง ถูกใช้ไปแล้ว..','false');
			  }
			if ($itopup['code'] == 1) {
			 if($itopup['msg'] == $config['truewallet_msg']){
					$point = $itopup['amount'] * $config['promotion_tw'];
					$connect->query("  INSERT INTO `log_topup` (`id`, `value`, `transaction`, `time`, `point`, `amount`, `username`, `status`) VALUES (NULL, 'Truewallet', '".$_POST['truewallet']."', '".time()."', '".$amount."', '".$itopup['amount']."', '".$user['username']."', 'success'); ");
					$connect->query("UPDATE `user` SET `point` = point+'$point' WHERE `user`.`id` = ".$user['id']);
					DisplayMSG('success','Success Topup', 'เติมเงินสำเร็จ <br>จำนวน : '.$itopup['amount'].' บาท <br>ได้รับพ้อย : '.$point.' <i class="fas fa-gift"></i>.','false');
				}else {
					DisplayMSG('error','Error Topup', 'คุณกรอกข้อความไม่ตรงกับระบบกำหนด !!..','false');
				}
			}else{
				$connect->query("  INSERT INTO `log_topup` (`id`, `value`, `transaction`, `time`, `point`, `amount`, `username`, `status`) VALUES (NULL, 'Truemoney', '".$_POST['truewallet']."', '".time()."', '0', '0', '".$user['username']."', 'fail'); ");
				DisplayMSG('error','Error Topup', 'ไม่พบเลขอ้างอิงนี้..','false');
			}
		}
		if(isset($_GET['shop'])) {
			$id = $_GET['id'];
			if(empty($id)) {
				DisplayMSG('error','Error Buy','ไม่พบสินค้านี้','false');
			}
			$query = $connect->query('SELECT * FROM shop WHERE id = "'.$id.'"');
			if($query->num_rows == 0) {
			DisplayMSG('error','Error Buy','ไม่พบสินค้านี้','false');
			}
			$shop = $query->fetch_assoc();
			if($user['point'] >= $shop['price']) {
				$filename =  '_dist/id/'.$shop['dist'];
				$data = rmtxt($filename);
				if($data == "Stock" || $data == "Error") {
					DisplayMSG('error','Error Buy','สินค้าหมด !!','false');
				}
				$lib = explode(":",$data);
				$connect->query("INSERT INTO `log_shop` (`id`, `name`, `lore`, `price`, `time`, `username`, `email`, `password`) VALUES (NULL, '".$shop['name']."', '".$shop['lore']."', '".$shop['price']."', '".time()." ', '".$user['username']."', '".$lib[0]."', '".$lib[1]."'); ");
				$connect->query("UPDATE `user` SET `point` = point-'".$shop['price']."' WHERE `user`.`id` = ".$user['id']." ");
				DisplayMSG('success','Success Buy', 'ซื้อสินค้า <U>"'.$shop['name'].'"</U> สำเร็จ <br>คุณสามารถรับ ข้อมูลการใช้งานที่ <br><a class="btn btn-success" href="?page=history"><i class="fas fa-gift"></i>&nbsp;ประวัตการซื้อเลย</a>','false');
			}else {
				DisplayMSG('error','Error Buy','พ้อยของคุณไม่เพียงพอ','false');
			}
		}
}
function DisplayMSG($function,$title,$msg,$reload){
	global $url;
	if($reload == 'true') {
		$data = exit("<script>$function('$title', '$msg', 'true');setTimeout(function(){ location.href = \"$url\"; }, 2500);</script>");
	}else {
	$data = exit("<script>$function('$title', '$msg', 'false');</script>");
	}
	return $data;
}
function iDisplayMSG($function,$title,$msg,$reload,$url){
	if(empty($url)) {
		$url = "..";
	}else {
		$url = $url;
	}
	if($function == 'isuccess' || $function == 'ierror') {
		if($reload == 'true') {
			$data = "<script>$function('$title', '$msg', 'true', '$url');setTimeout(function(){ location.href = \"$url\"; }, 2500);</script>";
		}else {
			$data = "<script>$function('$title', '$msg', 'false','');</script>";
		}
	}else {
		if($reload == 'true') {
			$data = "<script>$function('$title', '$msg', 'true');setTimeout(function(){ location.href = \"$url\"; }, 2500);</script>";
		}else {
			$data = "<script>$function('$title', '$msg', 'false');</script>";
		}
	}
	echo $data;
}
function WALLET($url) {
	global $config;
	$ch = curl_init();  
	$post = [
		'email' => $config['truewallet_email'],
		'password' => $config['truewallet_password']
	];
	curl_setopt($ch, CURLOPT_URL, $url);    
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$data = curl_exec($ch);     
	curl_close($ch);    
	return $data; 
}
$months =array( 
			"0"=>"", "1"=>"มกราคม", "2"=>"กุมภาพันธ์", "3"=>"มีนาคม","4"=>"เมษายน","5"=>"พฤษภาคม","6"=>"มิถุนายน", "7"=>"กรกฎาคม","8"=>"สิงหาคม","9"=>"กันยายน","10"=>"ตุลาคม","11"=>"พฤศจิกายน","12"=>"ธันวาคม"
				  );
function th($time){
	global $months;
		@$th.= date("H",$time);
		@$th.= ":".date("i",$time);
		@$th.= "  วันที่ ".date("j",$time);
		@$th.= " ".$months[date("n",$time)];
		@$th.= " พ.ศ.".(date("Y",$time)+543);
	return $th;
}
function rmtxt($FileName) {
	$text = array();
	$open = fopen($FileName, 'r+');
	if($open)
	{
		while(!feof($open))
		{
			$file = fgets($open, 4096);
			array_push($text, str_replace("\n", "", $file));
		}
		fclose($open);
		if(count($text) <= 1)
			return "Stock";
		else
		{
			$Buy = $text[rand(0, count($text)-1)];
			$text = null;
			$text = array();
			$open = fopen($FileName, 'r+');
			while(!feof($open))
			{
				$file = fgets($open, 4096);
				if(str_replace("\n", "", $file) != $Buy)
					array_push($text, str_replace("\n", "", $file));
			}
			fclose($open);
			$open = fopen($FileName, 'w');
			for($i = 0; $i <= count($text)-1; $i++)
			{
				if($i == count($text)-1)
					$t[$i] = $text[$i];
				else
					$t[$i] = $text[$i].'
';
				fwrite($open, $t[$i]); 
			}
			if($open) 
			{
				return $Buy;
			}
			else
			{
				return "Error";
			}
			fclose($open);
		}
	}
	else
	{
		return "Error";
	}
}
function stock($filename) {
	  @$data = file_get_contents('_dist/id/'.$filename);
	  if(!$data) {
		  file_put_contents('_dist/id/'.$filename,'');
	  }
	  $count = explode("\n",$data);
	  if($data == NULL) {
	  $count = 0; 
	  }else {
		  $count = count($count);
	  }
	return $count;
}
function Read($file) {
	$i = file_get_contents($file);
	return $i;
}
function Write($file,$txt){
	$fp = fopen($file, "w+");
	$data = str_replace(array("\r\n","\r"),"\n",$txt);
	fwrite($fp, $data);
	fclose($fp);
}
?>