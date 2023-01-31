<?php
    // Use config to log into database and initialize the session
    require_once "../config.php";
    session_start();
    $quot = chr(34);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Html Setup -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="gaming, video games, games, game, rubix, rubix games, rubix, rubik's games, rubiks games, rubik games, rubix game, fun video games, indie games, best indie games, amazing games, fun games, team, team sports, team tennis, team: tennis, team sports: tennis, best video games of 2021, best video games of 2022, best video games of 2023, best video games of 2024">
        <!-- Import Icons and Fonts -->
        <link href = "../inhousefont/galiver/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Set Page Favicon, Title, Descripton, and CSS Styling -->
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="./css/legal.css">
        <link rel="shortcut icon" href="/media/favicon.ico" type="image/x-icon">
        <title>Policies - Rubix Games</title>
        <meta description="Rubix Games legal information.">
    </head>
    <body>
        <script src="/js/navtoggleicon.js"></script>
        <div class="bar">
            <div class="bar__content u-centered">
                <a href="../" class="bar__logo"><img class="bar__logo"></a>
                <input type="checkbox" id="navtoggle" onchange="navToggle()">
                <label for="navtoggle" class="bar__navtog"><i class="mdi mdi-menu" id="navlabel"></i></label>
                <nav class="nav">
                    <a href="../games" class="nav__link">Games</a>
                    <a href="../store" class="nav__link">Store</a>
                    <a href="<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { echo("../logout"); } else { echo("../login"); } ?>" class="nav__link"><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { echo("Log Out"); } else { echo("Log In"); } ?></a>
                    <a href="../register" class="nav__link">Sign Up</a>                   
                    <a href="https://discord.gg/GEYxMnmQer" class="nav__link discord_b"><i class="mdi mdi-discord"></i> Discord Server</a>
                    <a href="https://discord.gg/GEYxMnmQer" class="nav__link discord_a"><i class="mdi mdi-discord"></i></a>
                </nav>
            </div>
        </div>
        <div class="wrapper">
            <div class="legal u-centered">
                <div class="legal__header">
                    <h1>We, the <h1 class="legal__BIG">RUBI<i>X</i> GAMES <red>C</red><blue>O</blue><white>M</white><green>P</green><yellow>A</yellow><red>N</red><orange>Y</orange></h1></h1>
                    <h2>To be refered to in the following documents as <i>"Rubix" OR "Rubix Games"</i>, and to be referenced to with the pronouns as 'we' etc. as if the entity was a group(doing so in preperation for conversion to a Limited Liability Company) :</h2>
                </div>
                <div class="legal__decl">
                    <p class="dec__txt">Are a <b>Sole Proprietorship</b> in the state of California in the United States of America that creates consumer products in the field of <b>Electronic Entertainment</b> and <b>Home Video Games</b>.</p>
                </div>
            </div>
        </div>
        <footer class="footer">    
            <div class="footer__text container">
                <p class="footer__text--tp">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum perferendis accusantium nostrum unde sunt vero. Sit ratione id, reprehenderit assumenda corrupti deserunt harum praesentium officiis mollitia, tenetur veritatis, quae labore.
                </p>
                <p>Copyright Rubix Games LLC<a href="../legal">*</a> - &copy;2021-2023</p>
                <hr class="footer__hr">
                <div class="footer__pages">
                    <a href="../" class="footer__page"><i class="mdi mdi-home"></i> Home</a>
                    <a href="../about" class="footer__page"><i class="mdi mdi-apps"></i> About Us</a>
                    <a href="../legal" class="footer__page"><i class="mdi mdi-gavel"></i> Legal</a>
                    <a href="../help" class="footer__page"><i class="mdi mdi-account-heart"></i> Customer Service</a>
                </div>
            </div>
            <div class="footer__socials">
                <a href="https://youtube.com/@Rubix-Games" class="footer__link" target="_blank"><i class="mdi mdi-youtube"></i></a>
                <a href="https://twitter.com/RubixGames_" class="footer__link" target="_blank"><i class="mdi mdi-twitter"></i></a>
                <a href="https://patreon.com/KingedKimed" class="footer__link" target="_blank"><i class="mdi mdi-patreon"></i></a>
                <a href="https://steamcommunity.com/id/rubixgames" class="footer__link" target="_blank"><i class="mdi mdi-steam"></i></a>
                <a href="https://www.rubixgames.net/" class="footer__link" target="_blank"><i class="mdi mdi-web"></i></a>
            </div>       
        </footer>
    </body>
</html>