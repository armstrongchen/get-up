<?php
header('Cache-Control:no-cache,must-revalidate');   
header('Pragma:no-cache');   
header("Expires:0"); 
date_default_timezone_set('Asia/Shanghai');
if(isset($_COOKIE['issign'])){
echo ("您已经签到过了，请您明天再来签到吧！");
exit();
}
$h = date(H);
if ($h < 5) {
echo ("签到时间还没到，请在北京时间 5 点后再来签到。");
exit();
}
if ($h > 8) {
echo ("已经过了今天的签到时段，请在北京时间 9 点之前签到。");
exit();
}
if (empty($_GET['n'])) {
echo <<<html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VIYF 校园 - 起床签到</title>
</head>
<body>
<h1>请在下面输入你的昵称，然后点击提交。</h1>
<form action="" charset="utf-8">
<input name="n" type="text" title="昵称：" />
<button type="submit" title="提交" />
</form>
</body>
</html>
html;
exit();
}
$name=$_GET['n'];
$name_length=strlen($name);
if (!($name_length > 0 & $name_length < 32)) {
echo ("发生错误，昵称长度有误，允许的最大长度是 1 到 32 个英文字母，或 1 到 16 个汉字。");
exit();
}
$name = strip_tags($name);
$namechar = mb_detect_encoding($name, "gb2312", true);
if ($namechar === "EUC-CN") {
$name = iconv("gb2312","utf-8",$name);
}
$name = strtolower($name);
$date = date("Ymd");
$time = date("H:i:s");
$file='./reporta/#'.$date.'.txt';
if (file_exists($file)) {
$import_data = file_get_contents($file);
$to_array_data = json_decode($import_data, true);
if(array_key_exists($name,$to_array_data)){
echo ("您已经签到过了，请您明天再来签到吧！");
exit();
}
$array2_data = array ($name => $time);
$new_array_data = array_merge($to_array_data, $array2_data);
$output_data = json_encode($new_array_data);
$new_order = count($new_array_data);
if ($new_order > 200) {
echo ("今天签到已经满员了哦，请明天再来签到吧！");
exit();
}
file_put_contents($file, $output_data, LOCK_EX);
} else {
$array_data = array ($name => $time);
$output_data = json_encode($array_data);
file_put_contents($file, $output_data, LOCK_EX);
}
$order = 1;
if (isset($new_order)) {
if ($new_order > 1) {
$order = $new_order;
}
}
echo ($name . " 签到成功！您是第 ".$order." 位签到的同学。建议您将本页加入浏览器书签，便于明天继续签到。您也可以<a href='rule.htm' target='_blank'>点击这里查看奖励规则</a>。");
setCookie("issign","yes", time()+14400, "/get-up/");
?>
