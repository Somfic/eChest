<?php require_once '../core/init.php'; ?>
<?php include '../core/needslogin.php' ?>

<?php
$accounts = $db->where('user_id', $user->data()['id'])->join('accounts', 'accounts_owners.account_id = accounts.id')->get('accounts_owners');
?>

<?php include '../includes/top.php'; ?>
<?php include '../includes/nav.php'; ?>

<main>
    <div class="row">
        <div class="col-4">

        </div>
        <div class="col-8">

            <div class="col-12 mb-2">
                <h2>Hi, <?php echo escape($user->data()['nickname']) ?>!</h2>
            </div>
            <div class="col-12 col-mb-3">
                <p>Quick links</p>
                <?php if ($user->data()['group'] == 'Unactivated') : ?>
                    <p>Please <a href="">activate your account</a></p>
                <?php endif; ?>

                <ul>
                    <?php if ($user->hasPermission('profile.read')) : ?>
                        <li><a href="#">All accounts</a></li>
                    <?php endif; ?>

                    <?php if ($user->hasPermission('audits.read')) : ?>
                        <li><a href="/admin/audit.php">Audit logs</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

    </div>
</main>

<?php include '../includes/footer.php'; ?>
<?php include '../includes/bottom.php'; ?>