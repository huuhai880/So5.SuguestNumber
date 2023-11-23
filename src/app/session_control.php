<?php 
// Set the session timeout to 30 minutes (1800 seconds)
$GLOBALS['session_timeout'] = 300; //5 phút

// Start the session


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập.
    header('Location: dang_nhap.php');
    exit;
  }


// Check if the session has timed out
if (isset($_SESSION['last_activity_time']) && time() > ($_SESSION['last_activity_time'] + $GLOBALS['session_timeout'])) {
    // The session has timed out, do something here
    session_destroy();
    header('Location: dang_nhap.php');
    exit;
}
// Set the session timeout based on the global variable
$_SESSION['last_activity_time'] = time() + $GLOBALS['session_timeout'];

?>