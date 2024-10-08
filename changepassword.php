<?php require_once './core/init.php'; ?>
<?php require './core/needslogin.php'; ?>

<?php if (!$user->hasPermission('profile.edit.own')) {
    Logger::log('{name} tried to access changepassword.php', $user, 2);
    Redirect::to('/index.php');
    exit();
} ?>

<?php include './includes/top.php'; ?>
<?php include './includes/nav.php'; ?>

<?php
if (Token::check(Input::get('token'))) {
    $validate = new Validation();
    $validation = $validate->check($_POST, array(
        "password" => array(
            "required" => true,
        ),
        "password_new" => array(
            "required" => true,
            "min" => 6,
        ),
        "password_new_confirm" => array(
            "required" => true,
            "min" => 6,
            "matches" => "password_new"
        ),
    ));

    if ($validation->passed()) {
        if (Hash::make(Input::get('password'), $user->data()['salt']) !== $user->data()['password']) {
            echo 'Wrong password!';
        } else {
            $salt = Hash::salt(32);

            try {
                $user->update(array(
                    'password' => Hash::make(Input::get('password_new'), $salt),
                    'salt' => $salt
                ));

                Logger::log('{name} changed their password', $user, 1);
                Result::success('Password changed', 'Take that, hackers!', '/index.php');
            } catch (Exception $ex) {
                Result::error('Password could not be changed', $ex->getMessage(), '/changepassword.php');
            }
        }
    } else {
        foreach ($validation->errors() as $error) {
            echo "{$error}<br>";
        }
    }
}
?>

<main>
    <form action="" method="POST">
        <div class="form-input floating">
            <label for="password">Current password</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="form-input floating">
            <label for="password_new">New password</label>
            <input type="password" name="password_new" id="password_new">
        </div>

        <div class="form-input floating">
            <label for="password_new_confirm">New password confirm</label>
            <input type="password" name="password_new_confirm" id="password_new_confirm">
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
        <input class="button" type="submit" value="Update profile">
    </form>
</main>
<?php include './includes/footer.php'; ?>
<?php include './includes/bottom.php'; ?>