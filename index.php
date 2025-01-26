<?php
include 'Privacy/keyauth.php';
include 'Privacy/credentials.php';

if (isset($_SESSION['user_data'])) {
    header("Location: dashboard/");
    exit();
}

$KeyAuthApp = new KeyAuth\api($name, $ownerid);

if (!isset($_SESSION['sessionid'])) {
    $KeyAuthApp->init();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>O N T R</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="CSS/index.css">
    <link rel="stylesheet" href="CSS/Notify.css">
</head>
<body>
    <section>
        <div class="flex-wrap">
            
        <a href="/dashboard/KeyVerfiy.php" class="verify-badge">
        <span class="verify-text">卡密验证</span>
        <div class="verify-pulse"></div>
        </a>
        
        <div class="welcome-content" style="display: flex; flex-direction: column; min-height: 400px;">
        <h2 style="text-align: center; margin-top: 0;">O N <span>T R</span> 👋</h2>
        <h3 style="text-align: center; margin-top: 20px; color: #666;">♥️ 这是我用心开发的一款软件</h3>
        <h3 style="text-align: center; margin-top: 10px; color: #666;">✔️ 希望你有舒服愉悦的体验</h3>
        <h3 style="text-align: center; margin-top: 10px; color: #666;">✨ 简洁清爽的界面设计</h3>
        <h3 style="text-align: center; margin-top: 10px; color: #666;">🚀 快速响应的操作体验</h3>
        <h5 style="margin-top: auto;">SofaWare By <span>YRBOT</span></h5>
    </div>

            <div class="form-container">
    <div class="form-tabs">
        <button type="button" class="tab-btn active" data-form="login">Login</button>
        <button type="button" class="tab-btn" data-form="register">Register</button>
    </div>
    
    <form method="post" id="loginForm" class="active">
        <div class="input-group">
            <input type="text" id="username" name="username" placeholder=" " required>
            <label for="username">Username</label>
        </div>

        <div class="input-group">
            <input type="password" id="password" name="password" placeholder=" " required>
            <label for="password">Password</label>
        </div>

        <div class="button-group">
            <button type="submit" name="login">
                Login
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </form>

    <form method="post" id="registerForm">
        <div class="input-group">
            <input type="text" id="reg-username" name="username" placeholder=" " required>
            <label for="reg-username">Username</label>
        </div>

        <div class="input-group">
            <input type="password" id="reg-password" name="password" placeholder=" " required>
            <label for="reg-password">Password</label>
        </div>

        <div class="input-group">
            <input type="text" id="reg-key" name="key" placeholder=" " required>
            <label for="reg-key">License Key</label>
        </div>

        <div class="button-group">
            <button type="submit" name="register">
                Register
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </form>
</div>
</section>

<div class="page-loader">
    <svg class="loader-svg" viewBox="0 0 50 50">
        <circle class="loader-circle" cx="25" cy="25" r="20"/>
    </svg>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.tab-btn');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            if (this.dataset.form === 'login') {
                registerForm.classList.remove('active');
                void registerForm.offsetWidth;
                loginForm.classList.add('active');
            } else {
                loginForm.classList.remove('active');
                void loginForm.offsetWidth;
                registerForm.classList.add('active');
            }
        });
    });
});

const pageLoader = document.querySelector('.page-loader');
setTimeout(() => {
    pageLoader.classList.add('hide');
}, 500);

window.notification = 
{
    showSuccess: function() {
        const loading = document.querySelector('.page-loader');
        loading.classList.add('show');
        setTimeout(() => {
            loading.classList.remove('show');
        }, 500);
    },
};
</script>

<script src="JS/Notify.js"></script>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
<script>
<?php
if (isset($_POST['login'])) {
    try {
        if ($KeyAuthApp->login($_POST['username'], $_POST['password'])) {
            echo "window.notification.showSuccess();";
            echo "setTimeout(function() { window.location.href = 'dashboard/'; }, 2000);";
        }
    } catch (Exception $e) {
        echo "window.notification.showError('" . addslashes($e->getMessage()) . "');";
    }
}

if (isset($_POST['register'])) {
    try {
        if ($KeyAuthApp->register($_POST['username'], $_POST['password'], $_POST['key'])) {
            echo "window.notification.showSuccess();";
            echo "setTimeout(function() { window.location.href = 'dashboard/'; }, 2000);";
        }
    } catch (Exception $e) {
        echo "window.notification.showError('" . addslashes($e->getMessage()) . "');";
    }
}
?>
</script>
<?php endif; ?>
</body>
</html>