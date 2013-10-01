<!DOCTYPE html>
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>DozBu</title>
    <link rel="stylesheet" href="css/screen.css">
    <link rel="stylesheet" href="css/foundation.css">
    <script src="js/vendor/custom.modernizr.js"></script>
    <script src="./js/jquery2.js"></script>
    <script>
    $(document).ready(function(){
        $('.deleteLabel').click(function(){
            $('.delete').fadeToggle(500);
            return false;
        });
    });
    </script>

</head>
<body>

<div id="wrapper">
    <div class="row navi">
        <?php if($_SESSION['status'] == admin && $_COOKIE['LOGGED_IN'] == true){
            echo'
                <nav class="">
                    <a href="'.$_SERVER['PHP_SELF'] .'?p=booking" class="button">Buchung Erzeugen</a>
                    <a href="'.$_SERVER['PHP_SELF'] .'?p=settings" class="button">Dozenten verwalten</a>
                    <a href="'.$_SERVER['PHP_SELF'] .'?p=casview" class="button">CAS Datenansicht</a>
                    <a href="'.$_SERVER['PHP_SELF'] .'?p=upload" class="button success">Upload</a>
                    <a href="'.$_SERVER['PHP_SELF'] .'?action=logout" class="button alert logout">Logout</a>
                </nav>
            ';
        }?>
        <img src="img/sae_logo.png" class="logo" width="110" height="70"/>

    </div>
    <?php
    if ($_SESSION['status'] == 'admin' && $_COOKIE['LOGGED_IN'] == true) {
        if(!isset($_GET['p'])){
            include './modules/Booking/templates/tpl-booking.php';
        }else{
            include './modules/' . $this->data['path'] . '/templates/' . $this->data['siteContent']->template . '.php';
        }
    } else {
        include './modules/Login/templates/tpl-login.php';
    }
    ?>
</div>
<footer>
    <p>Idea by Joachim Theiss @ SAE Leipzig | port to PHP by Marten Stockenberg @ SAE Leipzig - 2013</p>
</footer>
<script>
    document.write('<script src=' +
        ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
        '.js><\/script>')
</script>

<script src="js/foundation.min.js"></script>
<script src="js/foundation/foundation.forms.js"></script>
<script>
    $(document).foundation();
</script>
</body>
</html>

