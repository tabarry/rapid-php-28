<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('inc-head.php'); ?>
        <title><?php echo $getSettings['site_name']; ?></title>
    </head>
    <body>
        <?php include('inc-navbar.php'); ?>
        <div class="container">
            <h4>Authenticate this Device</h4>
            <div id="error-area">
                <ul></ul>
            </div> 
            <div class="row">
                <form class="col s12" action="<?php echo QRCODE_AUTHENTICATE_URL; ?>remote<?php echo PHP_EXTENSION; ?>/login/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="user__Email" name="user__Email" type="email" class="validate" required="required" autocomplete="off">
                            <label for="user__Email">Email</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="user__Password" name="user__Password" type="password" class="validate" required="required" autocomplete="off">
                            <label for="user__Password">Password</label>
                        </div>
                        <button class="btn waves-effect waves-light red darken-4 right" type="submit" name="action"><i class="fa fa-check"></i>
                            Authenticate
                            
                        </button>

                    </div>
                    <p><a href="<?php echo QRCODE_AUTHENTICATE_URL; ?>forgot-password<?php echo PHP_EXTENSION; ?>/">Forgot password?</a></p>
                    <input name="user__Session" type="hidden" value="<?php echo $_GET['session'];?>" >
                </form>
            </div>
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php include('inc-footer.php'); ?>
    </body>
    <?php suIframe(); ?>
</html>
