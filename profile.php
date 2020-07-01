<?php require_once './core/init.php'; ?>
<?php
if (!$uid = Input::get('user')) {
    Result::error('Account not found', 'That account could not be found', '/index.php');
    exit();
} else {
    $user = new User($uid);
    if (!$user->exists()) {
        Result::error('Account not found', 'That account could not be found', '/index.php');
        exit();
    }

    $data = $user->data();
}
?>

<?php include './includes/header.php'; ?>
<h2><?php echo escape($data['nickname']) ?></h2>

<?php include './includes/footer.php'; ?>