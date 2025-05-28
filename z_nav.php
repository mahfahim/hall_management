<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<header class="z-navbar">
    <div class="z-container-nav">
        <div class="z-logo">🅱🅸🅹🅾🆈 24 🅷🅰🅻🅻</div>
        <nav>
            <ul class="z-nav-menu">
                <li><a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">ℍ𝕠𝕞𝕖</a></li>
                <li><a href="administration.php" class="<?= $current_page == 'administration.php' ? 'active' : '' ?>">𝔸𝕕𝕞𝕚𝕟𝕚𝕤𝕥𝕣𝕒𝕥𝕚𝕠𝕟</a></li>
                <li><a href="notice.php" class="<?= $current_page == 'notice.php' ? 'active' : '' ?>">ℕ𝕠𝕥𝕚𝕔𝕖</a></li>
                <li><a href="log_button.php" class="<?= $current_page == 'log_button.php' ? 'active' : '' ?>">𝕃𝕠𝕘𝕚𝕟</a></li>
            </ul>
        </nav>
    </div>
</header>
