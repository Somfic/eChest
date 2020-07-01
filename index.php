<?php require_once './core/init.php'; ?>
<?php include './includes/header.php'; ?>

<?php
$user = new User();
if ($user->isLoggedIn()) : ?>
    <p>Hi <a href="/profile.php?user=<?php echo escape($user->data()['uid']) ?>"><?php echo escape($user->data()['username']) ?></a></p>

    <ul>
        <li><a href="logout.php">Log out</a></li>
        <li><a href="update.php">Edit profile</a></li>
        <li><a href="changepassword.php">Change password</a></li>
    </ul>

    <?php if ($user->hasPermission('changename')) : ?>
        <p>You're an administrator</p>
    <?php endif; ?>
<?php else : ?>
    <p>Please <a href="login.php">log in</a> or <a href="register.php">register</a> first.</p>
<?php endif; ?>

<?php include './includes/footer.php'; ?>