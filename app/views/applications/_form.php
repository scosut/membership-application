<?php
$fieldProp = $formAction == "add" ? "" : " disabled";
$params    = empty($data->appId->value) ? "" : "/{$data->appId->value}";
?>

<?php require APP_ROOT."/views/inc/errors.php"; ?>

<form action="/applications/<?= $formAction; ?><?= $params; ?>" method="post">
	<div class="form-group">
		<label for="sid">Student ID:</label>
		<input type="text" id="sid" name="sid" value="<?= $data->sid->value; ?>"<?= $fieldProp; ?>>
	</div>

	<div class="form-group">
		<label for="first">First Name:</label>
		<input type="text" id="first" name="first" value="<?= $data->first->value; ?>"<?= $fieldProp; ?>>
	</div>

	<div class="form-group">
		<label for="last">Last Name:</label>
		<input type="text" id="last" name="last" value="<?= $data->last->value; ?>"<?= $fieldProp; ?>>
	</div>

	<div class="form-group">
		<label for="email">Email:</label>
		<input type="text" id="email" name="email" value="<?= $data->email->value; ?>" readonly>
	</div>

	<div class="form-group">
		<label for="mon">Day Preference for Events:</label>
		<div class="checkbox-wrapper">
			<?php
				$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
				foreach($days as $ndx=>$day):
					$prefix  = strtolower(substr($day, 0, 3));
					$checked = stripos($data->daypref->value, $prefix) !== false ? " checked" : "";
			?>
			<div>
				<input type="checkbox" id="<?= $prefix; ?>" name="daypref[]" value="<?= $prefix; ?>"<?= $checked; ?><?= $fieldProp; ?>>&nbsp;<label for="<?= $prefix; ?>"><?= $day; ?></label>
			</div>
			<?php if (($ndx + 1) % 3 == 0): ?>
			<div class="break"></div>
			<?php endif; ?>
			<?php endforeach; ?>																																																		
		</div>
	</div>

	<div class="form-group">
		<label for="timepref">Time Preference for Events:</label>
		<select id="timepref" name="timepref"<?= $fieldProp; ?>>
			<option value="">(select a time)</option>
			<?php
				$times = ["mornings", "afternoons", "evenings"];
				foreach($times as $time):
					$selected = $data->timepref->value == $time ? " selected" : "";
			?>
			<option value="<?= $time; ?>"<?= $selected; ?>><?= $time; ?></option>
			<?php endforeach; ?>			
		</select>
	</div>

	<div class="form-group">
		<button type="submit" class="btn">
		<?php if($formAction == "add"): ?>
		Submit
		<?php else: ?>
		<?= ucfirst($formAction); ?>
		<?php endif; ?>
	</button>
	</div>
</form>