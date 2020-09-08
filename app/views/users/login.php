<?php require APP_ROOT."/views/inc/header.php"; ?>

<section id="form">
	<div class="form-group">
		<h3>Login</h3>
		<p>Provide your credentials to login.</p>	
	</div>
	
	<?php require APP_ROOT."/views/inc/errors.php"; ?>

	<form action="/users/login"	method="post">
		<div class="form-group">
			<label for="role">Role:</label>
			<select id="role" name="role">
				<option value="">(select a role)</option>
				<?php
					$roles = ["student", "approver", "cashier"];
					foreach($roles as $role):
						$selected = $data->role->value == $role ? " selected" : "";
				?>
				<option value="<?= $role; ?>"<?= $selected; ?>><?= $role; ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-group">
			<label for="email">Email:</label>
			<input type="text" id="email" name="email" value="<?= $data->email->value; ?>">
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" value="<?= $data->password->value; ?>">
		</div>

		<div class="form-group">
			<button type="submit" class="btn">Login</button>
			<div class="to-right">
				No account?
				<a href="/users/register">Register</a>
			</div>
		</div>
	</form>
</section>

<?php require APP_ROOT."/views/inc/focus.php"; ?>

<?php require APP_ROOT."/views/inc/footer.php"; ?>