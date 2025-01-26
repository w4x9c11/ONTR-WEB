<?php
require '../Privacy/credentials.php';

$key = isset($_POST['key']) ? $_POST['key'] : '';
$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($key)) {
    $url = $GetAPI . "?sellerkey=" . urlencode($SellerKey) . "&type=info&key=" . urlencode($key);
    
    try {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $response = curl_exec($curl);
        
        if ($response === false) {
            throw new Exception('cURL Error: ' . curl_error($curl));
        }
        
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            throw new Exception('HTTP Error: ' . $httpCode);
        }
        
        curl_close($curl);
        
        $result = json_decode($response, true);
        if ($result === null) {
            throw new Exception('JSON decode error: ' . json_last_error_msg());
        }
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.notification) {
                    window.notification.showError('" . addslashes($e->getMessage()) . "');
                }
            });
        </script>";
    }
}
?>

<html lang="en">
<head>
    <title>KEY | CODE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/KeyVerfiy.css">
    <link rel="stylesheet" href="../CSS/Notify.css">
</head>
<body>
    <div class="verify-container">
        <div class="verify-header">
            <h1>O N T R</h1>
            <p>官方授权 & 卡密状态</p>
        </div>
            
        <form method="POST">
            <div class="input-group">
                <input type="text" 
                       name="key" 
                       placeholder=" "
                       value="<?php echo htmlspecialchars($key); ?>"
                       required>
            </div>
            <button type="submit" class="verify-btn">
                查询密钥
            </button>
        </form>

        <?php if ($result): ?>
            <div class="result-container <?php echo isset($result['success']) && $result['success'] ? 'success' : 'error'; ?>">
                <?php if (isset($result['success']) && $result['success']): ?>
                    <div class="result-items">
                        <div class="result-item">
                            <span class="result-label">卡密状态:</span>
                            <span class="result-value"><?php echo htmlspecialchars($result['status']); ?></span>
                        </div>
                        <div class="result-item">
                            <span class="result-label">有效时间:</span>
                            <span class="result-value"><?php echo htmlspecialchars($result['duration']); ?> 秒</span>
                        </div>
                        <div class="result-item">
                            <span class="result-label">官方授权:</span>
                            <span class="result-value"><?php echo htmlspecialchars($result['createdby']); ?></span>
                        </div>
                        <div class="result-item">
                            <span class="result-label">创建日期:</span>
                            <span class="result-value datetime"><?php echo htmlspecialchars($result['creationdate']); ?></span>
                        </div>
                        <?php if ($result['status'] === 'Used'): ?>
                            <div class="result-item">
                                <span class="result-label">使用者:</span>
                                <span class="result-value"><?php echo htmlspecialchars($result['usedby']); ?></span>
                            </div>
                            <div class="result-item">
                                <span class="result-label">使用时间:</span>
                                <span class="result-value datetime"><?php echo htmlspecialchars($result['usedon']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            if (window.notification) {
                                window.notification.showError('无效的密钥或发生错误');
                            }
                        });
                    </script>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <script src="../JS/Notify.js"></script>
    <script src="JS/KeyVerfiy.js"></script>
</body>
</html>