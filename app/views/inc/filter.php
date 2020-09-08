<?php
$default = "approved";
$default = $data["role"] == "cashier" ? "recorded" : $default;
?>
<form action="/applications" method="post">
	<select id="filter" name="filter" onchange="this.form.submit();">
		<option value=""><?= ucfirst($default); ?></option>
		<optgroup label="Filter by:">
			<?php 
			$items = [$default, "pending", "all"];
			foreach($items as $item):
				$selected = $data["filter"] == $item ? " selected" : "";
			?>
			<option value="<?= $item; ?>"<?= $selected; ?>><?= $item; ?></option>
			<?php endforeach; ?>
			<?php 
			foreach($data["dates"] as $d): 
				$selected = $data["filter"] == $d ? " selected" : "";
			?>
				<option value="<?= $d; ?>"<?= $selected; ?>><?= date("n/j/Y", strtotime($d)); ?></option>
			<?php endforeach; ?>
		</optgroup>
	</select>
</form>