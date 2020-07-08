<?php require_once './core/init.php'; ?>
<?php include './includes/top.php'; ?>
<?php Redirect::to(Session::get('result-redirect'), 4000) ?>

<div class="flex center height-screen align-center">
    <div>
        <h1 class="mb-2">
            <?php if (Session::get('result-type') == 'success') : ?>
                <i class="fas fa-check-circle success"></i>
            <?php else : ?>
                <i class="fas fa-times-circle error"></i>
            <?php endif; ?>
        </h1>
        <h1>
            <?php echo Session::get('result-title'); ?>
        </h1>

        <h2 class="muted mb-2">
            <?php echo Session::get('result-message'); ?>
        </h2>
        <div class="mb-2">
            <div class="waiter">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <p class="m-a">You will be <a href="<?php echo Session::get('result-redirect'); ?>">redirected</a> in just a moment</p>
    </div>
</div>

<?php include './includes/bottom.php'; ?>