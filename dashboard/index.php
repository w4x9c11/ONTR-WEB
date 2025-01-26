<?php
error_reporting(0);
require '../Privacy/keyauth.php';
require '../Privacy/credentials.php';

session_start();

if (!isset($_SESSION['user_data'])) {
    header("Location: ../");
    exit();
}

$KeyAuthApp = new KeyAuth\api($name, $ownerid);

function findSubscription($name, $list) {
    for ($i = 0; $i < count($list); $i++) {
        if ($list[$i]->subscription == $name) {
            return true;
        }
    }
    return false;
}

$username = $_SESSION["user_data"]["username"];
$subscriptions = $_SESSION["user_data"]["subscriptions"];
$subscription = $_SESSION["user_data"]["subscriptions"][0]->subscription;
$expiry = $_SESSION["user_data"]["subscriptions"][0]->expiry;
$ip = $_SESSION["user_data"]["ip"];
$creationDate = $_SESSION["user_data"]["createdate"];
$lastLogin = $_SESSION["user_data"]["lastlogin"];

if (isset($_POST['logout'])) 
{
    session_destroy();
    header("Location: ../");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | ONTR</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.keyauth.cc/dashboard/unixtolocal.js"></script>
    <link rel="stylesheet" href="CSS/User.css">
    <link rel="stylesheet" href="../CSS/Notify.css">
</head>
<body>
    <?php $KeyAuthApp->log("New login from: " . $username); ?>

    <div class="dashboard-container">
        <div class="header">
            <h1>欢迎回来, <?= htmlspecialchars($username) ?></h1>
            <form method="post">
                <button type="submit" name="logout" class="logout-btn">
                    退出账号
                </button>
            </form>
        </div>

        <div class="user-info">
            <div class="info-card">
                <div class="info-label">IP</div>
                <div class="info-value"><?= htmlspecialchars($ip) ?></div>
            </div>

            <div class="info-card">
                <div class="info-label">创建账户</div>
                <div class="info-value"><?= date('Y-m-d H:i:s', $creationDate) ?></div>
            </div>

            <div class="info-card">
                <div class="info-label">上次登录</div>
                <div class="info-value"><?= date('Y-m-d H:i:s', $lastLogin) ?></div>
            </div>
        </div>

        <div class="subscription-list">
            <h2>您的订阅</h2>
            <?php for ($i = 0; $i < count($subscriptions); $i++): ?>
                <div class="subscription-item">
                    <div>
                        <h3><?= htmlspecialchars($subscriptions[$i]->subscription) ?></h3>
                        <p>订阅编号 #<?= $i + 1 ?></p>
                    </div>
                    <div>
                        到期时间: <script>document.write(convertTimestamp(<?= $subscriptions[$i]->expiry ?>));</script>
                    </div>
                </div>
            <?php endfor; ?>
        </div>

        <div class="subscription-list">
    <h2>更新日志</h2>
    <div class="subscription-item">
        <div>
            <h3>当前版本号 1.0</h3>
            <p>2025/1/25</p>
        </div>
        <div>
            <button class="download-btn" onclick="downloadSoftware()">下载</button>
        </div>
    </div>
</div>
        
    </div>
    

    <script src="JS/User.js"></script>
    <script src="../JS/Notify.js"></script>
</body>
</html>