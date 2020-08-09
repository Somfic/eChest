<?php require_once '../core/init.php'; ?>
<?php include '../core/needslogin.php' ?>

<?php
$accounts = $db->where('user_id', $user->data()['id'])->join('accounts', 'accounts_owners.account_id = accounts.id')->get('accounts_owners');
?>

<?php include '../includes/top.php'; ?>
<?php include '../includes/nav.php'; ?>

<main>
    <div class="row">
        <div class="col-12 mb-2">
            <h2>Hi, <?php echo escape($user->data()['nickname']) ?>!</h2>
        </div>
        <div class="col-12 col-mb-4">
            <div class="card">
                <h3>Quick links</h3>
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
                </ul>
            </div>
        </div>
        <div class="col-12 col-mb-8">
            <div class="card">
                <?php if (count($accounts) == 0) : ?>
                    <?php if ($user->hasPermission('accounts.create.own')) : ?>
                        <div class="pullout">
                            <div class="pullout-header mt-0">
                                <h2>Create an account to get into business!</h2>
                            </div>
                            <div class="pullout-paragraph">
                                <a href="/accounts/create.php" class="button">Create your first eChest bank account</a>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="pullout">
                            <div class="pullout-header mt-0">
                                <h2>Please activate your account to get started!</h2>
                            </div>
                            <div class="pullout-paragraph">
                                <a href="/accounts/create.php" class="button">Activate my account</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <h2>Your accounts</h2>
                    <p class="mb-2">An overview of all your accounts</p>
                    <?php foreach ($accounts as $accountData) : ?>
                        <?php $account = new Account($accountData['uid']) ?>
                        <div class="row">
                            <p class="col-6"><?php echo $account->data()['name'] ?></p>
                            <p class="col-6"><?php echo $account->data()['balance'] ?></p>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($user->hasPermission('accounts.create.own')) : ?>
                        <div class="row mt-2">
                            <a href="#" class="button">Create a new account</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>
<?php include '../includes/bottom.php'; ?>