<?php
header('Cache-Control:no-cache,must-revalidate');   
header('Pragma:no-cache');   
header("Expires:0"); 
date_default_timezone_set('Asia/Shanghai');
$date=$_GET['d'];
if (empty($_GET['d'])) {
?>
<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VIYF 校园 - 起床签到 - 查看签到结果</title>
</head>
<body>
<h1>请在下面输入你想要查看的日期，然后点击查询。</h1>
<form action="" charset="utf-8">
<input name="d" type="text" title="日期：" value="<?php echo(date("Ymd")); ?>" />
<button type="submit" title="查询" />
</form>
</body>
</html>
<?php
exit();
}
$date_length=strlen($date);
if (!($date_length === 8)) {
echo ("日期长度有误，允许的日期长度为 8 个阿拉伯数字。");
exit();
}
date_default_timezone_set('Asia/Shanghai');
$file='./reporta/#'.$date.'.txt';
if (file_exists($file)) {
$to_array_data = json_decode(file_get_contents($file), true);
echo "<pre>";print_r($to_array_data);echo "<pre>";
// var_dump($to_array_data);
} else {
echo("暂无数据。");
}
?>
