<!DOCTYPE html>
<!--Source: https://www.w3schools.com/bootstrap/bootstrap_templates.asp-->
<?php

function getMenuItems($active) {
    $activeClass = "";

    if ($active) {
        $activeClass = " class=\"active\"";
    }

    $menu = "
<li{$activeClass}><a href=\"menu.php\">Menu</a></li>
<li><a href=\"Level_1/Level_1.php\">Level 1</a></li>
<li><a href=\"Level_2/Level_2.php\">Level 2</a></li>
<li><a href=\"Level_3/Level_3.php\">Level 3</a></li>
<li><a href=\"Level_4/Level_4.php\">Level 4</a></li>
<li><a href=\"Level_5/Level_5.php\">Level 5</a></li>
<li><a href=\"Level_6/Level_6.php\">Level 6</a></li>
<li><a href=\"Level_7/Level_7.php\">Level 7</a></li>
<li><a href=\"Level_8/Level_8.php\">Level 8</a></li>
<li><a href=\"Level_9/Level_9.php\">Level 9</a></li>
";
    return $menu;
}
?>
<html lang="en">
<head>
    <title>SOWA Demo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="common/menu.css">
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">COMP1688</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <?php echo getMenuItems(true); ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
        </div>
        <div class="col-sm-8 text-left">
            <h1>Welcome to Service Oriented Web Applications!</h1>
            <p>
                Use the links at the top or below to navigate to appropriate level.
                This will bring you to a simple submenu page that links to the appropriate services and files.
            </p>
            <hr>

            <ul>
                <?php echo getMenuItems(true); ?>
            </ul>

            <h3>Useful Links</h3>
            <p><a href="http://stuweb.cms.gre.ac.uk/~mkg01/comp1688/schedule.html">SOWA Teaching Schedule</a></p>
        </div>
        <div class="col-sm-2 sidenav">
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>Student: Raymond Wong | ID: 000 777 808</p>
</footer>

</body>
</html>
