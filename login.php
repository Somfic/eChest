<?php require_once './core/init.php'; ?>
<?php include './includes/header.php'; ?>

<?php
if (Token::check(Input::get('token'))) {
    $validate = new Validation();
    $validation = $validate->check($_POST, array(
        "username" => array("required" => true),
        "password" => array("required" => true),
    ));

    if ($validation->passed()) {
        $user = new User();

        $remember = (Input::get('remember') === 'on') ? true : false;

        $login = $user->login(Input::get('username'), Input::get('password'), $remember);

        if ($login) {
            Result::success('Logged in', 'You are succesfully logged in!', 'index.php');
        } else {
            Result::success('You weren\'t logged in', 'You could not be succesfully logged in', 'index.php');
        }
    } else {
        foreach ($validation->errors() as $error) {
            echo "{$error}<br>";
        }
    }
}
?>

<h2>Login</h2>
<form action="" method="POST">
    <div class="form-input floating">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="off">
    </div>
    <div class="form-input floating">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="off">
    </div>
    <div class="form-input">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember">
            <span class="check-text">Remember me</span>
        </label>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
    <input class="button" type="submit" value="Log in">
</form>
<?php include './includes/footer.php'; ?>