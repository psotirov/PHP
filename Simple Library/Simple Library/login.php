<?php
    $pageTitle='Login form';
    include 'header.php';
    
    // if username and password are supplied - checks their validity
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $usr = $_POST['username'];
        $usr =  isValidUsername($usr)?$usr:'';
        $pwd = $_POST['password'];
        $pwd =  isValidUsername($pwd)?$pwd:'';
        if(!$usr || !$pwd) echo '<p>Invalid characters in username or password (only alfabets and digits are allowable)</p>';
    }
    
    $username = 0;  
    $userid = 0;
    // proceed register or login, depending on submitted button
    $isRegister = isset($_POST['register']);
    if ((isset($_POST['login']) || $isRegister) && $usr && $pwd) {
        $userid = getUser($usr, $pwd, $isRegister);
        if ($userid){
            $username = $usr;
        } else if ($userid == -1) {
            echo '<p>could not connect to database</p>';
        } else {
            echo ($isRegister)?'<p>username already registered</p>':'<p>username and/or password are wrong</p>';
        }
    }
    
    session_start();    
    if($username) {
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $userid;
        $_SESSION['logged'] = true;
    }
    

    if(isset($_SESSION['logged']) && $_SESSION['logged']) {     
        if (isset($_GET['logout'])) { // logout request
            $_SESSION = array(); // Unsets all of the session variables.
            if (ini_get("session.use_cookies")) { // deletes the session cookie.
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]);
            }
        
            session_destroy(); // Finally, destroy the session.
        }
        header("Location: index.php"); 
    }
?>
<form method="POST">
    <input type="text" name="username" /><br />
    <input type="password" name="password" /><br />
    <input type="submit" name="login" value="Login" />
    <input type="submit" name="register" value="Register" />
</form>

<?php
    include 'footer.php';
    // functions
    function isValidUsername($text) {
        return preg_match("/^[a-z0-9]+$/i", $text); // case insesitive check if string contains only alphabets and digits 
    }
    
    function getUser(&$username, $password, $type = 0) { // $type == 1 => register, $type == 0 => login
        $con = mysqli_connect("localhost","root", "", "books");
        if (!$con) return -1; // no connection to database error
        mysqli_set_charset($con, "utf8");
        // check if username exists
        $query = "SELECT * FROM users WHERE username='".mysqli_real_escape_string($con, $username)."';";
        $pwd = sha1($password);
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result)) {
            if ($type) return false; // there is such user already            
            $user = mysqli_fetch_array($result);
            if($user["password"] == $pwd) {
                echo $user["id"];
                return $user["id"]; // return users id as result (and $username as a parameter by reference)
            }
            
            return false; // wrong password error            
        } else if($type) { // register new user
            $insertQuery = "INSERT INTO users (username,password) VALUES ('".mysqli_real_escape_string($con, $username)."', '".$pwd."');";
            if (mysqli_query($con, $insertQuery))
            {
                $result = mysqli_query($con, $query);
                if ($result && mysqli_num_rows($result)) {
                    $user = mysqli_fetch_array($result);
                    $username =  $user["username"];
                    return $user["id"];
                }
                
                echo "must not be here";
            }
        }
        
        return false;
    }
?>