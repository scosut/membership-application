<nav id="nav"<?= Utility::isActive('/') ? "class=\"fadeInDown\"" : ""; ?>>
	<div class="logo">
		<i class="fas fa-university"></i>
		<div class="logo-text">					
			<h2>Business Club</h2>
			<h1>Hillsdale College</h1>
		</div>
	</div>

	<hr>

	<ul class="items">
		<li><a href="/"<?= Utility::setActive('/') ?>>Home</a></li>
		<?php if(Utility::isLoggedIn()): ?>
			<?php if(Utility::isRole("student") && !Utility::hasApplied()): ?>
				<li><a href="/applications/add"<?= Utility::setActive('/applications/add') ?>>Apply</a></li>
			<?php endif; ?>
			<li><a href="/applications"<?= Utility::setActive('/applications') ?>>Dashboard</a></li>
			<li><a href="/users/logout"<?= Utility::setActive('/users/logout') ?>>Logout</a></li>
		<?php else: ?>
			<li><a href="/users/register"<?= Utility::setActive('/users/register') ?>>Register</a></li>
			<li><a href="/users/login"<?= Utility::setActive('/users/login') ?>>Login</a></li>
		<?php endif; ?>
	</ul>
</nav>