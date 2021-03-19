<?php
    $error = "";
    if (isset($_POST['username']) && isset($_POST['password'])) {

        $username = $_POST['username'];
        $pass = $_POST['password'];
        $loginInfo = $db->getTheUserPasswordForLogin($username);
        if ($loginInfo->num_rows === 0) { 
            $error = $lang['USERNOTFOUND'];
        }
        while ($result = $loginInfo->fetch_array(MYSQLI_ASSOC)){
            // this is a check if the password is correct
            if (password_verify($pass, $result['password'])) {
                // this is a checkbox check for the remember me check 
                if (!empty($_POST["remember"])) {
                    setcookie("member_login", $username);
                } else {
                    setcookie("member_login", '');
                }
                // this changes the cookie lang to the users database prefred lang
                setcookie("lang", $result['lang'], time()+(3600 * 24 * 30));

                // store values in session
                $_SESSION['username'] = $result['username'];
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['Team'] = $result['Team'];
                
				echo "<script>window.location.href='home';</script>";
				exit;
            } else {
                $error = $lang['PASSWORDINCORRECT'];
            }
        }
    }
?>

<div id="neoBlockContainer">
    <div class="neonBlock Content">
        <h1 class="blockTitle"><?php echo $lang["LOGIN"];?></h1>
        <form method="POST">
            <div class="error"><?php echo $error; ?></div>
            <input value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" type="text" name="username" placeholder="<?php echo $lang["USERNAME"];?>" required>
            <input type="password" name="password" placeholder="<?php echo $lang["PASSWORD"];?>" required>
            <label class="check">
                <input type="checkbox" name="remember" id="remember"
                <?php if(isset($_COOKIE["member_login"])) { ?> checked 
                <?php } ?> /> <?php echo $lang["REMEMBER_USERNAME"];?>
            </label><br>
            <button class="inloggen" type="submit"><?php echo $lang["LOGIN"];?></button><br>
        </form>
    </div>
</div>