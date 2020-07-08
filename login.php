<?php require_once './core/init.php'; ?>
<?php $title = "eChest - Login"; ?>
<?php include './includes/top.php'; ?>

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
            Logger::log('{name} logged in', $user);
            Result::success('Logged in', greeting() . ' ' . $user->data()['nickname'] . '!', 'index.php');
        } else {
            Result::error('You weren\'t logged in', 'Hmm, let\'s try that again...', 'index.php');
        }
    } else {
        foreach ($validation->errors() as $error) {
            echo "{$error}<br>";
        }
    }
}
?>
<div class="row height-screen">
    <div class="col-12 col-lp-6 flex center bg-contrast">
        <div class="align-center width-full py-2">
            <h1><b>eChest</b></h1>
            <h3>Please log in to continue</h3>
            <p>
            </p>
        </div>
    </div>
    <div class="col-12 col-lp-6 flex center px-4">
        <form action="" method="POST">
            <div class="form-input floating">
                <label for="username">Minecraft name</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-input floating">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-input">
                <label for="remember">
                    <input type="checkbox" name="remember" id="remember">
                    <span class="check-text">Remember me</span>
                </label>
            </div>

            <input type="hidden" name="token" value="<?php echo Token::generate() ?>">

            <input class="button primary width-full mb-2 mt-3" type="submit" value="Log in">
        </form>
        <div class="align-center mt-2 flex-vertical">
            <a href="/register.php">Register an account</a>
            <a href="#">Forgot your password?</a>
        </div>
    </div>
</div>
<?php include './includes/bottom.php'; ?>