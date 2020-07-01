<?php require_once './core/init.php'; ?>
<?php include './includes/header.php'; ?>

<div class="pullout">
    <h2 class="pullout-header">
        <?php echo Session::get('result-title'); ?>
    </h2>

    <p class="pullout-paragraph">
        <?php echo Session::get('result-message'); ?>
    </p>
</div>

<a href="<?php echo Session::get('result-redirect'); ?>">Redirect</a>

<?php include './includes/footer.php'; ?>