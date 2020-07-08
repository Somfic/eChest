<?php require_once './core/init.php'; ?>
<?php include './core/needslogin.php' ?>

<?php
$accounts = $db->where('user_id', $user->data()['id'])->join('accounts', 'accounts_owners.account_id = accounts.id')->get('accounts_owners');
?>

<?php include './includes/top.php'; ?>
<?php include './includes/nav.php'; ?>

<main>
    <div class="row">
        <div class="col-12">
            <h2>Hi, <?php echo escape($user->data()['nickname']) ?>!</h2>
        </div>
        <div class="col-3">
            <p>Quick links</p>
            <?php if ($user->data()['group'] == 'Unactivated') : ?>
                <p>Please <a href="">activate your account</a></p>
            <?php endif; ?>

            <ul>
                <li><a href="logout.php">Log out</a></li>

                <?php if ($user->hasPermission('accounts.create.own')) : ?>
                    <li><a href="/accounts/create.php">Create a new account</a></li>
                <?php endif; ?>

                <?php if ($user->hasPermission('profiles.create.own')) : ?>
                    <li><a href="update.php">Create a new account</a></li>
                <?php endif; ?>

                <?php if ($user->hasPermission('profile.edit.own')) : ?>
                    <li><a href="update.php">Edit profile</a></li>
                    <li><a href="changepassword.php">Change password</a></li>
                <?php endif; ?>

                <?php if ($user->hasPermission('profile.read')) : ?>
                    <li><a href="#">All accounts</a></li>
                <?php endif; ?>

                <?php if ($user->hasPermission('audits.read')) : ?>
                    <li><a href="/admin/audit.php">Audit logs</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="col-9">
            <?php if (count($accounts) == 0) : ?>
                <div class="pullout">
                    <div class="pullout-header">
                        <h2>Start your online banking experience now!</h2>
                    </div>
                    <div class="pullout-paragraph">
                        <a href="/accounts/create.php" class="button">Create your first eChest bank account</a>
                    </div>
                </div>
            <?php else : ?>
                <?php foreach ($accounts as $account) : ?>
                    <p><?php echo $account['name'] ?></p>
                <?php endforeach; ?>

                <?php if ($user->hasPermission('accounts.create.own')) : ?>
                    <div class="row">
                        <div class="col-10"><input type="text"></div>
                        <div class="col-2"><button>button</button></div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php if ($user->hasPermission('changename')) : ?>
    <p>You're an administrator</p>
<?php endif; ?>

<?php include './includes/footer.php'; ?>
<?php include './includes/bottom.php'; ?>