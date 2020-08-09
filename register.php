<?php require_once './core/init.php'; ?>
<?php include './includes/top.php'; ?>

<?php
if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validation();
        $validation = $validate->check($_POST, array(
            "username" => array(
                'required' => true,
                'min' => 3,
                'max' => 16,
                'unique' => 'users',
                'validminecraft' => true
            ),
            "password" => array(
                'required' => true,
                'min' => 6
            ),
            "password_repeat" => array(
                'required' => true,
                'matches' => 'password'
            ),
            "agree" => array(
                'required' => true
            )
        ));

        if ($validation->passed()) {
            $user = new User();
            try {
                $user->register(Input::get('username'), Input::get('password'));
                $user->login(Input::get('username'), Input::get('password'));
                Logger::log('{name} registered an account', $user, 1);
                Result::success('Account created', 'Your account has succesfully been created', 'index.php');
            } catch (Exception $ex) {
                Result::error('Account could not be created', $ex->getMessage(), '/register.php');
            }
        }
    }
}
?>

<div class="row height-screen">
    <div class="col-12 col-lp-6 flex center bg-gradient">
        <div class="align-center width-full py-2">
            <h1><b>eChest</b></h1>
            <h3>Create a new account</h3>
        </div>
    </div>
    <div class="col-12 col-lp-6 flex center px-4">
        <form action="" method="POST">
            <?php if (isset($validation) && !$validation->passed()) {
                foreach ($validation->errors() as $error) {
                    echo "{$error}<br>";
                }
            } ?>

            <div class="form-input floating">
                <label for="username">Minecraft name</label>
                <input type="text" name="username" id="username" value="<?php echo escape(Input::get('username')) ?>" autocomplete="off">
            </div>
            <div class="form-input floating">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" value="" autocomplete="off">
            </div>

            <div class="form-input floating">
                <label for="password_repeat">Password confirm</label>
                <input type="password" name="password_repeat" id="password_repeat" value="" autocomplete="off">
            </div>
            <div class="form-input">
                <label for="agree">
                    <input type="checkbox" name="agree" id="agree" required>
                    <span class="check-text">I agree with the <a class="link" href="">terms and conditions</a></span>
                </label>
            </div>
            <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
            <input class="button primary width-full mb-2 mt-3" type="submit" value="Register">
        </form>
        <div class="align-center mt-2 flex-vertical">
            <a class="link" href="/login.php">I already have an account</a>
        </div>
    </div>
</div>

<?php include './includes/bottom.php'; ?>