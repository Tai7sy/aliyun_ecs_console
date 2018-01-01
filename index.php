<!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width" name="viewport">
<title>阿里云管理</title>
<body>
<?php
include_once 'operate.php';
if (isset($_GET['key']) && isset($_GET['op'])) {


    // 配置管理密钥 -> 地区 + 实例ID
    $allId = array(
        'key1' => array('cn-shenzhen', 'i-94oxaxinl'),
        'key2' => array('cn-shenzhen', 'i-94oxaxinl'),
    );
    $key = $_GET['key'];
    if (!isset($allId[$key]))
        die('Key错误');
    $ins = $allId[$key];


    // AccessKey 从这里获取
    // https://ak-console.aliyun.com/
    $ecs = new OperateEcs($ins[0], 'accessKey', 'accessSecret');

    $op = $_GET['op'];
    try {
        switch ($op) {
            case 'status':
                echo("操作成功: <br>");
                print_r($ecs->status($ins[1]));
                break;
            case 'start':
                echo("操作成功: <br>");
                print_r($ecs->start($ins[1]));
                break;
            case 'stop':
                echo("操作成功: <br>");
                print_r($ecs->stop($ins[1]));
                break;
            case 'reboot':
                echo("操作成功: <br>");
                print_r($ecs->reboot($ins[1]));
                break;
            case 'rebuild':
                echo("操作成功: <br>");
                print_r($ecs->rebuild($ins[1]));
                break;
            default:
                break;
        }
    } catch (Exception $e) {
        print_r("出现错误: " . $e->getMessage());
    }


    exit;
} else {
    echo '请选择操作<br>';
}

//print_r($ecs->status());

?>


<form method="get">
    <label>Key
        <input type="text" name="key" required>
    </label>
    <label>请选择操作
        <select name="op">
            <option value="status">查询状态</option>
            <option value="start">启动</option>
            <option value="stop">停止</option>
            <option value="reboot">重启</option>
            <option value="rebuild">重装(请先停止)</option>
        </select>
    </label>
    <button type="submit">确认操作</button>
</form>
</body>
</html>
