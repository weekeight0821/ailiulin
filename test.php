<?php

$code = $_POST['code'];
$appid = "wx38770a80299936aa";
$secret = "9fda945e79cc97f26c0dd8ff11770f3f";

$url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

echo $url;