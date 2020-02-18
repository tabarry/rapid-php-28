<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');

//If QR Login disabled
if ($getSettings['qr_login'] == 'Disable') {
    exit;
}
//Get session
$user_session = suSegment(1);
$msg = QR_SUCCESS;
$heading = QR_SUCCESS_HEADING;
//Check if cookie set
if ($_COOKIE[SESSION_PREFIX . 'ck_uid'] == '') {
    $url = QRCODE_AUTHENTICATE_URL . 'login' . PHP_EXTENSION . '/?session=' . $user_session;
    suPrintJs("parent.window.location.href='{$url}';");
    exit();
}
////

if (isset($user_session) && $user_session != '') {
    $user_uid = $_COOKIE[SESSION_PREFIX . 'ck_uid'];
    $user_uid = explode('-', $user_uid);
    $user_id = $user_uid[0];
    $user_uid = $user_uid[1];
    $sql = "UPDATE sulata_qr_sessions SET qr_session__UID='{$user_uid}' WHERE qr_session__Session='{$user_session}';";
    $result = suQuery($sql);
    if ($result['affected_rows'] == 0) {
        $msg = RESCAN_QR;
        $heading = RESCAN_QR_HEADING;
    } else {
        suRedirect(QRCODE_AUTHENTICATE_URL);
    }
}
///
$pageName = 'Authenticate this Device';
$pageTitle = 'Authenticate this Device';
?>
<!DOCTYPE html>
<head>
    <?php include('inc-head.php'); ?>
    <title><?php echo $getSettings['site_name']; ?></title>
</head>
<body>
    <?php include('inc-navbar.php'); ?>

    <div class="container">
        <h4><?php echo $heading; ?></h4>
        <div class="row">
            <div id="load-alerts">
                <i class="fa fa-check color-green"></i> <?php echo $msg; ?>
            </div>
        </div>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>

</body>
<?php suIframe(); ?>
</html>
