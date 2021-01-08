<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title = "Login";

// include login checker
$require_login=false;
include_once "login_checker.php";

// default to false
$access_denied=false;

// if the login form was submitted
if($_POST){
    // include classes
    include_once "config/database.php";
    include_once "objects/user.php";

// get database connection
    $database = new Database();
    $db = $database->getConnection();

// initialize objects
    $user = new User($db);

// check if email and password are in the database
    $user->email=$_POST['email'];

// check if email exists, also get user details using this emailExists() method
    $email_exists = $user->emailExists();

// validate login
    if ($email_exists && password_verify($_POST['password'], $user->password) && $user->status==1){

        // if it is, set the session value to true
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['access_level'] = $user->access_level;
        $_SESSION['firstname'] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8') ;
        $_SESSION['lastname'] = $user->lastname;

        // if access level is 'Admin', redirect to admin section
        if($user->access_level=='Admin'){
            header("Location: {$home_url}admin/index.php?action=login_success");
        }

        // else, redirect only to 'Customer' section
        else{
            header("Location: {$home_url}index.php?action=login_success");
        }
    }

// if username does not exist or password is wrong
    else{
        $access_denied=true;
    }
}

// include page header HTML
include_once "layout_head.php";

echo "<div class='col-sm-6 col-md-4 col-md-offset-4'>";

// get 'action' value in url parameter to display corresponding prompt messages
$action=isset($_GET['action']) ? $_GET['action'] : "";

// tell the user he is not yet logged in
if($action =='not_yet_logged_in'){
    echo "<div class='alert alert-danger margin-top-40' role='alert'>Please login.</div>";
}

// tell the user to login
else if($action=='please_login'){
    echo "<div class='alert alert-info'>
        <strong>Please login to access that page.</strong>
    </div>";
}

// tell the user email is verified
else if($action=='email_verified'){
    echo "<div class='alert alert-success'>
        <strong>Your email address have been validated.</strong>
    </div>";
}

// tell the user if access denied
if($access_denied){
    echo "<div class='alert alert-danger margin-top-40' role='alert'>
        Access Denied.<br /><br />
        Your username or password maybe incorrect
    </div>";
}

// actual HTML login form
echo "<div class='account-wall'>";
echo "<div id='my-tab-content' class='tab-content'>";
echo "<div class='tab-pane active' id='login'>";
echo "<img class='profile-img' src='data:image/png;base64,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'>";
echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
echo "<input type='text' name='email' class='form-control' placeholder='Email' required autofocus />";
echo "<input type='password' name='password' class='form-control' placeholder='Password' required />";
echo "<input type='submit' class='btn btn-lg btn-primary btn-block' value='Log In' />";
echo "</form>";
echo "</div>";
echo "</div>";
echo "</div>";

echo "</div>";

// footer HTML and JavaScript codes
include_once "layout_foot.php";
?>