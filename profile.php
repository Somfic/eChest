<?php require_once 'core/init.php'; ?>
<p>hi</p>


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

<?php include 'includes/header.php'; ?>
<p>hi</p>
<div class="row">
    <div class="col-4">
        <img class="pb-2" src="<?php echo escape($user->avatar()) ?>" alt="">
        <h2><?php echo escape($data['nickname']) ?></h2>
        <h3><?php echo escape($data['username']) ?></h3>
    </div>
</div>

<?php include 'includes/footer.php'; ?>