<?php include_once 'languages.php'; ?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo _("Register");?></title>
</head>
<body>
    <center></br>
        <form name="myform" method="post">
        <select name="locale" onchange="myform.submit();">
            <option value="en_US" <?php if ($_POST["locale"] == "en_US") echo "selected='selected' " ?> >English</option>
            <option value="fr_FR" <?php if ($_POST["locale"] == "fr_FR") echo "selected='selected' " ?> >Français</option>
        </select>  
    </form>
    <h1><?php echo _("Hello"); ?></h1>
    <?php echo _("logout"); ?>
    <p><?php echo _("My Ticket"); ?></p>
    </center>
</body>
</html>
