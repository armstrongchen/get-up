<?php
date_default_timezone_set('Asia/Shanghai');
$name=$_GET['n'];
$date=$_GET['d'];
$time=$_GET['t'];
$name = strtolower($name);
$file='./reporta/#'.$date.'.txt';
if (file_exists($file)) {
$import_data = file_get_contents($file);
$to_array_data = json_decode($import_data, true);
if(array_key_exists($name,$to_array_data)){
echo ("这位同学已经录入，请不要重复操作！");
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
echo ($order.". ".$name." 录入成功！");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VIYF 校园 - 起床签到 - 早期数据录入</title>
</head>
<body>
<h1>请在下面输入你要录入的信息，然后点击提交。</h1>
<form action="" charset="utf-8">
<input name="n" id="n" type="text" title="昵称："/>
<SCRIPT LANGUAGE="JavaScript">setTimeout("document.all.n.focus();",500);</SCRIPT>
<input name="t" type="text" title="时间：" value="06:30:00"/>
<input name="d" type="text" title="日期：" value="<?php echo $date; ?>"/>
<button type="submit" title="提交" />
</form>
</body>
</html>
