<nav class="nav">
    <div class="nav-logo">
        <span class="logo">eChest</span>
    </div>
    <div class="nav-links">
        <ul>
            <li class="nav-link">
                <a href="/dashboard/index.php">Dashboard</a>
            </li>
            <li class="nav-link">
                <p class="dropdown-item">Help <i class="fas fa-caret-down"></i></p>
                <ul class="dropdown">
                    <li class="nav-link">
                        <a href="">Account activation</a>
                    </li>
                    <li class="nav-link">
                        <a href="">Another link</a>
                    </li>
                    <li class="nav-link">
                        <a href="">Bablabl</a>
                    </li>
                </ul>
            </li>
            <?php if ($user->hasPermission('dashboard')) : ?>
                <li class="nav-link">
                    <a href="/admin/index.php">Admin dashboard</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="nav-buttons">
        <div class="nav-link">
            <div class="avatar">
                <img src="<?php echo $user->avatar() ?>" alt="">
                <span class="name"><?php echo escape($user->data()['nickname']) ?></span>
                <i class="fas fa-caret-down"></i>
            </div>
            <ul class="dropdown">
                <li class="nav-link">
                    <a href="#">My account</a>
                </li>
                <li class="nav-link">
                    <a href="/logout.php">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>