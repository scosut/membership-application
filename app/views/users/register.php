<?php require APP_ROOT."/views/inc/header.php"; ?>

<section id="form">
	<div class="form-group">
		<h3>Create an Account</h3>
		<p>Complete this form to register.</p>	
	</div>
	
	<?php require APP_ROOT."/views/inc/errors.php"; ?>

	<form action="/users/register"	method="post">
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="text" id="email" name="email" value="<?= $data->email->value; ?>">
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" value="<?= $data->password->value; ?>">
		</div>

		<div class="form-group">
			<label for="confirm">Confirm Password:</label>
			<input type="password" id="confirm" name="confirm" value="<?= $data->confirm->value; ?>">
		</div>

		<div class="form-group">
			<button type="submit" class="btn">Register</button>
			<div class="to-right">
				Have an account?
				<a href="/users/login">Login</a>
			</div>
		</div>
	</form>
</section>

<?php require APP_ROOT."/views/inc/focus.php"; ?>

<?php require APP_ROOT."/views/inc/footer.php"; ?>