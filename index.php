<?php require_once './core/init.php'; ?>
<?php
$user = new User();
if (!$user->isLoggedIn()) {
    Redirect::to('/login.php');
    exit();
} ?>

<?php include './includes/top.php'; ?>
<?php include './includes/nav.php'; ?>

<main>
    <p>Hi <a href="/profile.php?user=<?php echo escape($user->data()['uid']) ?>"><?php echo escape($user->data()['username']) ?></a></p>

    <div class="row">
        <div class="col-2">
            <nav class="sidebar">
                <div class="sidebar-item">
                    trait_exists</div>
            </nav>
        </div>
        <div class="col-10">
            <ul>
                <li><a href="logout.php">Log out</a></li>
                <li><a href="update.php">Edit profile</a></li>
                <li><a href="changepassword.php">Change password</a></li>
            </ul>
        </div>
    </div>
    </div>
</main>

<?php if ($user->hasPermission('changename')) : ?>
    <p>You're an administrator</p>
<?php endif; ?>

<?php include './includes/footer.php'; ?>
<?php include './includes/bottom.php'; ?>