<?php
/**
 * Secure Login Page
 * Uses prepared statements and modern password hashing
 */
require_once 'DatabaseConnection.php';
require_once 'lib/Security.php';
error_reporting(0);
ini_set('display_errors', 0);

if (isset($_SESSION['user_name'])) {
    header('location: homepage');
    exit;
}

include_once './lib/RequestHandler.php';
$DatabaseCo = new DatabaseConnection();
include_once './lib/Config.php';
$configObj = new Config();

if (isset($_GET['invalid']) && $_GET['invalid'] == 'true') {
    echo "<script>alert('Your Username or Password is wrong.');</script>";
}

$getdata = isset($_COOKIE['planId']) ? $_COOKIE['planId'] : '';

if (isset($_REQUEST['member_login'])) {
    if (!empty(trim($_POST['username'])) && !empty(trim($_POST['password']))) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        // Validate input format
        if (strlen($username) > 100 || strlen($password) > 255) {
            header('location: login?invalid=true');
            exit;
        }

        // Check if user is blocked using prepared statement
        $stmt = $DatabaseCo->dbLink->prepare(
            "SELECT id, matri_id FROM blocked_registrations WHERE email = ?"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $blockedResult = $stmt->get_result();
        
        if ($blockedResult->num_rows > 0) {
            $blockedRow = $blockedResult->fetch_object();
            $_SESSION['profile_suspended_id'] = $blockedRow->matri_id;
            $stmt->close();
            header('location: profile_blocked');
            exit;
        }
        $stmt->close();

        // Set remember me cookies with secure flags
        if (isset($_POST['keep_login'])) {
            $cookieOptions = [
                'expires' => time() + (86400 * 30),
                'path' => '/',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ];
            setcookie("user", $username, $cookieOptions);
            setcookie("pass", hash('sha256', $password . 'secure_salt'), $cookieOptions);
        }

        // Query user with prepared statement (search by matri_id, email, or samyak_id)
        $stmt = $DatabaseCo->dbLink->prepare(
            "SELECT email, matri_id, mobile, phone, username, m_status, birthdate, gender, 
                    index_id, request_photo_id, status, mobile_verify_status, photo1, 
                    adminrole_view_status, photo_id, photo_id_approve, family_origin, 
                    profile_text, income, part_income, part_frm_age, part_height, 
                    password, password_hash, msg_id 
             FROM register 
             LEFT JOIN delete_request ON register.matri_id = delete_request.msg_from
             WHERE matri_id = ? OR email = ? OR samyak_id = ?"
        );
        $stmt->bind_param("sss", $username, $username, $username);
        $stmt->execute();
        $SQL_STATEMENT = $stmt->get_result();

        // Regenerate session ID for security
        session_regenerate_id(true);

        if ($userRow = $SQL_STATEMENT->fetch_object()) {
            // Verify password
            $passwordValid = false;
            
            // Check for modern password hash first (Argon2ID or bcrypt)
            if (!empty($userRow->password_hash)) {
                $passwordValid = password_verify($password, $userRow->password_hash);
            }
            // Fallback: Check legacy MD5 hash and upgrade if valid
            elseif (!empty($userRow->password) && $userRow->password === md5($password)) {
                $passwordValid = true;
                
                // Upgrade to modern password hash
                $newHash = password_hash($password, PASSWORD_ARGON2ID, [
                    'memory_cost' => 65536,
                    'time_cost' => 4,
                    'threads' => 3
                ]);
                
                $updateStmt = $DatabaseCo->dbLink->prepare(
                    "UPDATE register SET password_hash = ? WHERE matri_id = ?"
                );
                $updateStmt->bind_param("ss", $newHash, $userRow->matri_id);
                $updateStmt->execute();
                $updateStmt->close();
            }
            
            if ($passwordValid) {
                $DatabaseCo->dbRow = $userRow;
                $stmt->close();
                @require_once 'login_services.php';
                exit;
            }
        }
        
        $stmt->close();
        header('location: login?invalid=true');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Buddhist Matrimonial Site | Secure & Reliable Matchmaking</title>
    <meta name="keyword" content="Buddhist Matrimonial, Buddhist Marriage, Buddhist Matchmaking, Buddhist Matrimony Site, Buddhist Wedding, Buddhist Bride, Buddhist Groom, Find Buddhist Partner, Buddhist Marriage Bureau, Online Buddhist Matrimony, Buddhist Marriage Services"/>
    <meta name="description" content="Looking for a compatible Buddhist life partner? Join our trusted Buddhist matrimonial platform to connect with genuine brides and grooms. Safe, secure, and reliable matchmaking. Register today to find your perfect match!"/>
    <link type="image/x-icon" href="img/<?php echo htmlspecialchars($configObj->getConfigFevicon()); ?>" rel="shortcut icon"/>
    <meta name="author" content="Manish Gupta">

    <!-- Fav and Touch Icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="images/ico/favicon.png">

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Gochi+Hand&family=Montserrat:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- COMMON CSS -->
    <link href="new-design/css/bootstrap.min.css" rel="stylesheet">
    <link href="new-design/css/style.css" rel="stylesheet">
    <link href="new-design/css/vendors.css" rel="stylesheet">

    <!-- CUSTOM CSS -->
    <link href="new-design/css/custom.css" rel="stylesheet">

</head>
<body>

<?php
require_once 'layouts/new-header.php';
?>

<main>
    <section id="hero" class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                    <div id="login">
                        <h4 class="font-weight-bold text-center">Login to your account</h4>
                        <hr>
                        <form action="login" method="post" name="login-form" id="login_form">
                            <?php echo Security::csrfField(); ?>
                            <div class="form-group">
                                <label for="login_username">Username</label>
                                <input id="login_username" type="text" name="username" class="form-control"
                                       placeholder="Profile ID / Email ID" maxlength="100" required/>
                            </div>
                            <div class="form-group">
                                <label for="login_password">Password</label>
                                <input id="login_password" type="password" name="password" class=" form-control"
                                       placeholder="Password" maxlength="255" required/>
                            </div>
                            <p class="small">
                                <a href="forgot-password">Forgot Password?</a>
                            </p>
                            <button type="submit" name="member_login"
                                    class="btn_full">Sign in
                            </button>
                            <a href="register" class="btn_full_outline">Register</a>
                        </form>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-12">
                                <p class="text-center">
                                    Reset password on WhatsApp <i
                                            class="fa fa-whatsapp"></i> <a style="font-weight: bold;"
                                                                           href="https://api.whatsapp.com/send?phone=919819886759&text=Please Reset my password">Click
                                        Here</a>
                                </p>
                                <p class="text-center">
                                    <span style="font-weight: bold">Reset Password using Mobile No</span> <i
                                            class="fa fa-phone"></i> <a style="font-weight: bold;" href="forgot-password">Click
                                        Here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End main -->

<?php
require_once 'layouts/new-footer.php';
?>

<!-- Common scripts -->
<script src="new-design/js/jquery-3.6.0.min.js"></script>
<script src="new-design/js/common_scripts_min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script src="new-design/js/functions.js"></script>

</body>
</html>
