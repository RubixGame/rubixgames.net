<?php
    //Use config to log into database and then initilize session
    require_once "./config.php";
    session_start();

    $quot = chr(34);

    //Define variables with empty values
    $username = $email = $password = $confirm_password = "";
    $username_err = $email_err = $password_err = $confirm_password_err = $general_err = "";

    //Get form data on submit
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //Validate username
        if(empty(trim($_POST["username"]))) {
            $username_err = "<i class=".$quot."mdi mdi-alert".$quot.";></i> Please enter a username.<br>";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
            $username_err = "<i class=".$quot."mdi mdi-alert".$quot."></i> Invalid username. Username can only contain letters, numbers, and underscore.<br>";
        } elseif(strlen(trim($_POST["username"])) < 4) {
            $username_err = "<i class=".$quot."mdi mdi-alert".$quot.";></i> Your username must be at least 4 letters long.<br>";
        } else {
            // Prepare an SQL Statement to make sure the username isn't already taken
            $sql = "SELECT id FROM users WHERE username = ?";

            if($stmt = mysqli_prepare($link, $sql)) {
                //Bind the variables to parameters, which are then bound to the statement
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                //Set parameters
                $param_username = trim($_POST["username"]);

                //Attempt to execute the statement
                if(mysqli_stmt_execute($stmt)) {
                    //Store the result
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "<i class=".$quot."mdi mdi-alert".$quot."></i> Username already taken.<br>";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    $general_err = "Huh? There was an error while processing your request. Check back with us later and see if the problem persists.";
                }

                //Close statement
                mysqli_stmt_close($stmt);
            }
        }

        //Validate email
        if(empty(trim($_POST["email"]))) {
            $email_err = "<i class=".$quot."mdi mdi-alert".$quot."></i> Please enter your email.<br>";
        } else if(!filter_var(trim($_POST["email"], FILTER_VALIDATE_EMAIL))) {
            $email_err = "<i class=".$quot."mdi mdi-alert".$quot."></i> Invalid Email. Must be in proper email format.<br>";
        } else {
            $email = trim($_POST["email"]);
        }

        //Validate password
        if(empty(trim($_POST["password"]))) {
            $password_err = "<i class=".$quot."mdi mdi-alert".$quot."></i> Please enter a password.<br>";
        } elseif(strlen(trim($_POST["password"])) < 8) {
            $password_err = "<i class=".$quot."mdi mdi-alert".$quot."></i> Password must have at least 8 characters.<br>";
        } else {
            $password = trim($_POST["password"]);
        }

        //Confirm password
        if(empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "<i class=".$quot."mdi mdi-alert".$quot."></i> Please reiterate your password.<br>";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "<i class=".$quot."mdi mdi-alert".$quot."></i> Passwords do not match.<br>";
            }
        }

        //Check if there are any errors before inserting data
        if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
            //Prepare an insertion statement
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

            if($stmt = mysqli_prepare($link, $sql)) {
                //Bind variables to parameters, which are then bound to the statement
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password);
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT); /* Hash the password for safety */

                //Attempt to execute statement
                if(mysqli_stmt_execute($stmt)) {
                    //Log user in then take them to homepage
                    session_start();

                    mysqli_stmt_close($stmt);

                    //Get generated user id
                    $sql = "SELECT id, created_at from users WHERE username = ?";
                    if($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                        $param_username = $username;
                        if(mysqli_stmt_execute($stmt)) {
                            mysqli_stmt_store_result($stmt);
                            mysqli_stmt_bind_result($id, $created_at);
                        } else {
                            //Cannot get ID. Redirect to login
                            mysqli_stmt_close($stmt);
                            session_destroy();
                            header("location: ./");
                            exit;
                        }
                    }

                    //Store data in session
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;
                    $_SESSION["email"] = $email;
                    $_SESSION["birthday"] = date($created_at);
                    $_SESSION["status"] = 0;
                    header("location: ./");

                } else {
                    $general_err = "Looks like there was an error while creating your account. Check back later and see if the problem persists.";
                }

                //Close statement
                mysqli_stmt_close($stmt);
            }
        }
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
        <link rel="stylesheet" href="./css/register.css">
        <link rel="shortcut icon" href="/media/favicon.ico" type="image/x-icon">
        <title>Join - Rubix Games</title>
        <meta description="Create a free Rubix Games account and join the fun today!">
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
                    <a href="<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { echo("./logout"); } else { echo("./login"); } ?>" class="nav__link"><?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { echo("Log Out"); } else { echo("Log In"); } ?></a>
                    <a href="https://discord.gg/GEYxMnmQer" class="nav__link discord_b"><i class="mdi mdi-discord"></i> Discord Server</a>
                    <a href="https://discord.gg/GEYxMnmQer" class="nav__link discord_a"><i class="mdi mdi-discord"></i></a>
                </nav>
            </div>
        </div>
        <div class="wrapper">
            <div class="register">
                <form class="register__container container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h1 class="register__header">Create an Account</h1>
                    <hr class="register__hr">
                    <span class="register__err"><?php echo $username_err; ?></span>
                    <label class="register__label" for="username">Username: </label>
                    <input type="text" name="username" class="register__input <?php echo (!empty($username_err)) ? "is-invalid" : ""; ?>" value="<?php echo $username; ?>">
                    <br>
                    <span class="register__err"><?php echo $email_err; ?></span>
                    <label class="register__label" for="email">Email address: </label>
                    <input type="text" name="email" class="register__input <?php echo (!empty($email_err)) ? "is-invalid" : ""; ?>" value="<?php echo $email; ?>">
                    <br>
                    <span class="register__err"><?php echo $password_err; ?></span>
                    <label class="register__label" for="password">Password: </label>
                    <input type="password" name="password" class="register__input <?php echo (!empty($password_err)) ? "is-invalid" : ""; ?>" value="<?php echo $password; ?>">
                    <br>
                    <span class="register__err"><?php echo $confirm_password_err; ?></span>
                    <label class="register__label" for="confirm_password">Confirm password: </label>
                    <input type="password" name="confirm_password" class="register__input <?php echo (!empty($confirm_password_err)) ? "is-invalid" : ""; ?>" value="<?php echo $confirm_password; ?>">
                    <br>
                    <input class="register__submit" type="submit" value="Let's Go!"><br>
                    <input type="reset" value="Reset" class="register__reset">
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