<?php $current_page = basename($_SERVER['PHP_SELF']); ?>

<div class="z-sidebar">
    <h2 class="zz-logo">BIJOY 24 HALL</h2>
    <ul class="zz-nav-links">

    <?php if ($_SESSION['role'] === 'student') { ?>
        <li><a href="bar_student.php" class="<?= $current_page == 'bar_student.php' ? 'active' : '' ?>"><i>🎓</i> Student Dashboard</a></li>
        <li><a href="bar_std_payment.php" class="<?= $current_page == 'bar_std_payment.php' ? 'active' : '' ?>"><i>💳</i> My Payment</a></li>
        <li><a href="bar_ad_room.php" class="<?= $current_page == 'bar_ad_room.php' ? 'active' : '' ?>"><i>🛏️</i> All Room</a></li>
        <li><a href="bar_std_room_appli.php" class="<?= $current_page == 'bar_std_room_appli.php' ? 'active' : '' ?>"><i>🛏️</i> Room Application</a></li>
        <li><a href="bar_std_problem.php" class="<?= $current_page == 'bar_std_problem.php' ? 'active' : '' ?>"><i>🛠️</i> Problem Assign</a></li>
    <?php } elseif ($_SESSION['role'] === 'super_admin') { ?>
        <li><a href="bar_admin.php" class="<?= $current_page == 'bar_admin.php' ? 'active' : '' ?>"><i>👨‍💼</i> Admin Dashboard</a></li>
        <li><a href="bar_ad_student.php" class="<?= $current_page == 'bar_ad_student.php' ? 'active' : '' ?>"><i>👨‍💼</i> All Student</a></li>
        <li><a href="bar_ad_payment.php" class="<?= $current_page == 'bar_ad_payment.php' ? 'active' : '' ?>"><i>💳</i> Payment</a></li>
        <li><a href="bar_ad_room.php" class="<?= $current_page == 'bar_ad_room.php' ? 'active' : '' ?>"><i>🛏️</i> Room</a></li>
        <li><a href="bar_ad_problem.php" class="<?= $current_page == 'bar_ad_problem.php' ? 'active' : '' ?>"><i>🛠️</i> Problem</a></li>
        <li><a href="bar_ad_room_appli.php" class="<?= $current_page == 'bar_ad_room_appli.php' ? 'active' : '' ?>"><i>🛠️</i> Room Application</a></li>
        <li><a href="bar_ad_notice.php" class="<?= $current_page == 'bar_ad_notice.php' ? 'active' : '' ?>"><i>📢</i> Notice Manage</a></li>
    <?php } ?>

        <li><a href="logout.php" class="<?= $current_page == 'logout.php' ? 'active' : '' ?>"><i>🚪</i> Logout</a></li>
    </ul>

    <div class="z-user-profile">
        <span style="font-size: 40px;">👤</span>
        <span>
            <?= htmlspecialchars(
                isset($_SESSION['student_name']) ? $_SESSION['student_name'] :
                (isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'User')
            ); ?>
        </span>
    </div>
</div>
