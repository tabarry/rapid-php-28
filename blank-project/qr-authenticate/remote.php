<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
$do = suSegment(1);

/* login */
if ($do == 'login') {

    //Validation array
    $validateAsArray = array('user__Name_validateas' => 'required', 'user__Phone_validateas' => 'required', 'user__Email_validateas' => 'email', 'user__Password_validateas' => 'required');
    //---------

    $sql = "SELECT user__ID, user__UID FROM sulata_users WHERE user__Email='" . suStrip($_POST['user__Email']) . "' AND user__Password='" . crypt(suStrip($_POST['user__Password']), API_KEY) . "' AND user__dbState='Live' AND user__Status='Active'";

    $result = suQuery($sql);
    if ($result['num_rows'] == 1) {
        $_SESSION[SESSION_PREFIX . 'user__ID'] = $result['result'][0]['user__ID'];
        $_SESSION[SESSION_PREFIX . 'user__UID'] = $result['result'][0]['user__UID'];
        //Set cookie
        $qr_cookie = $_SESSION[SESSION_PREFIX . 'user__ID'] . '-' . $_SESSION[SESSION_PREFIX . 'user__UID'];
        setcookie(SESSION_PREFIX . 'ck_uid', $qr_cookie, time() + (365 * 86400), '/'); //Set sessison cookie for uid
//Redirect
        $url = QRCODE_AUTHENTICATE_URL . 'index.php/' . $_POST['user__Session'] . '/';
        $js = "window.top.location.href ='" . $url . "'";
        suPrintJS($js);
    } else {
        $js = "parent.M.toast({html: '" . INVALID_LOGIN . "'})";
        suPrintJS($js);
    }
    exit();
}
/* retrieve */
if ($do == 'retrieve') {
    //Validation array
    $validateAsArray = array('user__Email_validateas' => 'email');

    $sql = "SELECT user__ID,user__Name FROM sulata_users WHERE user__Email='" . suStrip($_POST['user__Email']) . "' AND user__dbState='Live'";

    $result = suQuery($sql);
    $row = $result['result'][0];
    if ($result['num_rows'] == 1) {
        $temp_password = suGeneratePassword();
        //Update password
        $sql2 = "UPDATE sulata_users SET user__Password='" . crypt($temp_password, API_KEY) . "',user__Password_Reset='Yes' WHERE user__ID='" . $row['user__ID'] . "'";
        suQuery($sql2);
        $email = file_get_contents('../sulata/mails/lost-password.html');
        $email = str_replace('#NAME#', suUnstrip($row['user__Name']), $email);
        $email = str_replace('#SITE_NAME#', $getSettings['site_name'], $email);
        $email = str_replace('#EMAIL#', $_POST['user__Email'], $email);
        $email = str_replace('#URL#', BASE_URL, $email);
        $email = str_replace('#PASSWORD#', $temp_password, $email);
        $subject = sprintf(LOST_PASSWORD_SUBJECT, $getSettings['site_name']);
        //Send mails
        suMail($_POST['user__Email'], $subject, $email, $getSettings['site_name'], $getSettings['site_email'], TRUE);
//Redirect
        $js = "parent.M.toast({html: '" . LOST_PASSWORD_DATA_SENT . "'})";
        suPrintJS($js);
    } else {
        $js = "parent.M.toast({html: '" . NO_LOST_PASSWORD_DATA . "'})";
        suPrintJS($js);
    }
    exit();
}