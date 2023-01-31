<?php
    //Import config and initialize session
    require_once "./config.php";
    session_start();

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
        header("location: ./");
        exit;
    }

    //Use config to log into database
    require_once "./config.php";

    $quot = chr(34);

    //Define variables with empty values
    $username = $email = $password = "";
    $username_err = $email_err = $password_err = $general_err = "";

    //Get form data on submit
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //Pre-validate username
        if(empty(trim($_POST["username"]))) {
            $username_err = "<i class=".$quot."mdi mdi-alert".$quot.";></i> Please enter your username.<br>";
        } else {
            $username = trim($_POST["username"]);
        }

        //Pre-validate email
        if(empty(trim($_POST["email"]))) {
            $email_err = "<i class=".$quot."mdi mdi-alert".$quot.";></i> Please enter your email address.<br>";
        } else {
            $email = trim($_POST["email"]);
        }

        //Pre-validate password
        if(empty(trim($_POST["password"]))) {
            $password_err = "<i class=".$quot."mdi mdi-alert".$quot.";></i> Please enter your password.<br>";
        } else {
            $password = trim($_POST["password"]);
        }

        //Validate username, email, and password
        if(empty($username_err) && empty($email_err) && empty($password_err)) {
            //Prepare to S E L E C T
            $sql = "SELECT id, username, email, password, created_at FROM users WHERE username = ?";

            if($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;
                if(mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $username, $bound_email, $hashed_password, $created_at);
                        if(mysqli_stmt_fetch($stmt)) {
                            if(password_verify($password, $hashed_password)) {
                                if($bound_email == $email) {
                                    //Credentials Correct
                                    session_start();

                                    //Store data in session then redirect to home page
                                    $_SESSION["loggedin"] = true;
                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                    $_SESSION["email"] = $email;
                                    $_SESSION["birthday"] = date($created_at);
                                    $_SESSION["status"] = 0;

                                    header("location: ./");


                                } else {
                                    //Email incorrect
                                    $email_err = "<i class=".$quot."mdi mdi-alert".$quot.";></i> Invalid address. This email address is not linked to this account.<br>";
                                }
                            } else {
                                //Password incorrect
                                $password_err = "<i class=".$quot."mdi mdi-alert".$quot.";></i> Invalid password.<br>";
                            }
                        }
                    } else {
                        //Username does not exist
                        $username_err = "<i class=".$quot."mdi mdi-alert".$quot.";></i> User does not exist. Check if you spelled your username correctly or <a>click here</a> to make an account.<br>";
                    }
                }

                mysqli_stmt_close($stmt);
            }
        }

        mysqli_close($link);
    }
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
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@mdi/font@6.9.96/css/materialdesignicons.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- Set Page Favicon, Title, Descripton, and CSS Styling -->
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/login.css">
        <link rel="shortcut icon" href="/media/favicon.ico" type="image/x-icon">
        <title>Log in to Rubix Games</title>
        <meta description="Sign in to your Rubix Games account">
    </head>
    <body>
        <script src="/js/navtoggleicon.js"></script>
        <div class="bar">
            <div class="bar__content u-centered">
                <a href="./" class="bar__logo"><img class="bar__logo"></a>
                <input type="checkbox" id="navtoggle" onchange="navToggle()">
                <label for="navtoggle" class="bar__navtog"><i class="mdi mdi-menu" id="navlabel"></i></label>
                <nav class="nav">
                    <a href="./games" class="nav__link">Games</a>
                    <a href="./store" class="nav__link">Store</a>
                    <a href="./register" class="nav__link">Sign Up</a>
                    <a href="https://discord.gg/GEYxMnmQer" class="nav__link discord_b"><i class="mdi mdi-discord"></i> Discord Server</a>
                    <a href="https://discord.gg/GEYxMnmQer" class="nav__link discord_a"><i class="mdi mdi-discord"></i></a>
                </nav>
            </div>
        </div>
        <div class="wrapper">
            <div class="login">
                <form class="login__container container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h1 class="login__header">Log in to your RUBIX GAMES Account</h1>
                    <hr class="login__hr">
                    <span class="login__err"><?php echo $username_err; ?></span>
                    <label class="login__label" for="username">Username: </label>
                    <input type="text" name="username" class="login__input <?php echo (!empty($username_err)) ? "is-invalid" : ""; ?>" value="<?php echo $username; ?>">
                    <br>
                    <span class="login__err"><?php echo $email_err; ?></span>
                    <label class="login__label" for="email">Email address: </label>
                    <input type="text" name="email" class="login__input <?php echo (!empty($email_err)) ? "is-invalid" : ""; ?>" value="<?php echo $email; ?>">
                    <br>
                    <span class="login__err"><?php echo $password_err; ?></span>
                    <label class="login__label" for="password">Password: </label>
                    <input type="password" name="password" class="login__input <?php echo (!empty($password_err)) ? "is-invalid" : ""; ?>" value="<?php echo $password; ?>">
                    <br>
                    <input class="login__submit" type="submit" value="Let's Go!"><br>
                    <input type="reset" value="Reset" class="login__reset">
                </form>
            </div>
        </div>
        <footer class="footer">    
            <div class="footer__text container">
                <p class="footer__text--tp">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum perferendis accusantium nostrum unde sunt vero. Sit ratione id, reprehenderit assumenda corrupti deserunt harum praesentium officiis mollitia, tenetur veritatis, quae labore.</p>
                <p>Copyright Rubix Games LLC<a href="../legal">*</a> - &copy;2021-2023</p>
                <hr class="footer__hr">
                <div class="footer__pages">
                    <a href="./" class="footer__page"><i class="mdi mdi-home"></i> Home</a>
                    <a href="./about" class="footer__page"><i class="mdi mdi-apps"></i> About Us</a>
                    <a href="./legal" class="footer__page"><i class="mdi mdi-gavel"></i> Legal</a>
                    <a href="./help" class="footer__page"><i class="mdi mdi-account-heart"></i> Customer Service</a>
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