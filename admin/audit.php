<?php require_once '../core/init.php'; ?>
<?php require '../core/needslogin.php'; ?>

<?php if (!$user->hasPermission('audits.read')) {
    Logger::log('{name} tried to access admin/audit.php', $user, 2);
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
    <h2>Audit log</h2>
    <div class="row">
        <div class="col-12 col-tb-6">
            <h3>User actions</h3>
            <p>Logging in, logging out, creating an account, creating a transaction</p>
            <div class="feed">
                <?php foreach ($audits as $audit) : ?>
                    <?php $thisUser = new User($audit['user_id']); ?>
                    <div class="feed-event">
                        <div class="feed-event-icon">
                            <img src="<?php echo $thisUser->avatar() ?>" alt="">
                        </div>
                        <div class="feed-event-content">
                            <p class="muted date"><?php echo escape(timeago($audit['timestamp'])) ?></p>
                            <p><?php echo str_replace('{name}', escape($thisUser->data()['username']), escape($audit['message'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-12 col-tb-6">
            <h3>Administrative actions</h3>
            <p>Confirming transactions, paying off owes, removing accounts</p>
            <div class="feed">
                <?php foreach ($adminAudits as $audit) : ?>
                    <?php $thisUser = new User($audit['user_id']); ?>
                    <div class="feed-event">
                        <div class="feed-event-icon">
                            <img src="<?php echo $thisUser->avatar() ?>" alt="">
                        </div>
                        <div class="feed-event-content">
                            <p class="muted date"><?php echo escape(timeago($audit['timestamp'])) ?></p>
                            <p><?php echo str_replace('{name}', escape($thisUser->data()['username']), escape($audit['message'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>
<?php include '../includes/footer.php'; ?>
<?php include '../includes/bottom.php'; ?>