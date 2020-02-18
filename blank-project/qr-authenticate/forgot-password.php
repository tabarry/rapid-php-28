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
            <h4>Retrieve Password</h4>
            <div class="row">
                <form class="col s12" action="<?php echo QRCODE_AUTHENTICATE_URL; ?>remote<?php echo PHP_EXTENSION; ?>/retrieve/" accept-charset="utf-8" name="suForm" id="suForm" method="post" target="remote">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="user__Email" name="user__Email" type="text" class="validate">
                            <label for="user__Email">Email</label>
                        </div>

                        <button class="btn waves-effect waves-light right red darken-4" type="submit" name="action">Send
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                    <p><a href="<?php echo QRCODE_AUTHENTICATE_URL; ?>login<?php echo PHP_EXTENSION; ?>/">Login</a></p>
                </form>
            </div>
        </div>
        <!--JavaScript at end of body for optimized loading-->
        <?php include('inc-footer.php'); ?>

    </body>
    <?php suIframe(); ?>
</html>
