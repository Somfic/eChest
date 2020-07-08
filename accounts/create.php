<?php require_once '../core/init.php'; ?>
<?php require '../core/needslogin.php'; ?>

<?php if (!$user->hasPermission('accounts.create.own')) {
    Logger::log('{name} tried to access accounts/create.php', $user, 2);
    Redirect::to('/index.php');
    exit();
}

$db = Database::getInstance();
$audits = $db->orderBy('timestamp')->where('action_type', 1)->get('audits');
$adminAudits = $db->orderBy('timestamp')->where('action_type', 2)->get('audits');
?>

<?php include '../includes/top.php'; ?>
<?php include '../includes/nav.php'; ?>

<main>
    <h2>Create a new account</h2>
    <form action="" method="POST">
        <div class="form-input floating">
            <label for="name">Account name</label>
            <input type="text" name="name" id="name" value="<?php echo escape(Input::get('name')) ?>" autocomplete="off">
        </div>
        <div class="form-input">
            <label for="uid">BIN - Bank Identification Number</label>
            <input type="text" name="uid" id="uid" value="" autocomplete="off">
        </div>
        <div class="form-input floating">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="" autocomplete="off">
        </div>

        <div class="form-input floating">
            <label for="password_repeat">Password confirm</label>
            <input type="password" name="password_repeat" id="password_repeat" value="" autocomplete="off">
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate() ?>">
        <input class="button primary width-full mb-2 mt-3" type="submit" value="Register">
    </form>
</main>
<?php include '../includes/footer.php'; ?>
<?php include '../includes/bottom.php'; ?>