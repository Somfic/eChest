<?php require_once './core/init.php'; ?>
<?php include './includes/header.php'; ?>

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
            )
        ));

        if ($validation->passed()) {
            $user = new User();
            try {
                $user->register(Input::get('username'), Input::get('password'));
                Result::success('Account created', 'Your account has succesfully been created.', 'index.php');
            } catch (Exception $ex) {
                Result::error('Account could not be created', $ex->getMessage(), '/register.php');
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo "{$error}<br>";
            }
        }
    }
}
?>

<form action="" method="POST">
    <div class="form-input floating">
        <label for="username">Username</label>
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
    </div>

    <input class="button" type="submit" value="Register">

    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
</form>

<?php include './includes/footer.php'; ?>