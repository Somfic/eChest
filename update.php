<?php require_once './core/init.php'; ?>
<?php require './core/needslogin.php'; ?>

<?php
if (Token::check(Input::get('token'))) {
    $validate = new Validation();
    $validation = $validate->check($_POST, array(
        "nickname" => array(
            'required' => true,
            'min' => 3,
            'max' => 32
        )
    ));

    if ($validation->passed()) {
        try {
            $user->update(array(
                'nickname' => Input::get('nickname')
            ));

            Result::error('Account updated', 'Your account has been updated', '/index.php');
        } catch (Exception $ex) {
            Result::error('Account could not be updated', $ex->getMessage(), '/update.php');
        }
    } else {
        foreach ($validation->errors() as $error) {
            echo "{$error}<br>";
        }
    }
}
?>

<?php include './includes/header.php'; ?>
<form action="" method="POST">
    <div class="form-input">
        <label for="nickname">Nickname</label>
        <input type="text" name="nickname" id="nickname" value="<?php echo escape($user->data()['nickname']) ?>">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
    <input class="button" type="submit" value="Update profile">
</form>
<?php include './includes/footer.php'; ?>