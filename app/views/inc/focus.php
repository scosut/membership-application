<?php 
	$field = Validate::getFirstError($data);
	$field = $field == "daypref" ? "mon" : $field;
?>
<?php if ($field): ?>
<script>
	var field = document.getElementById("<?= $field; ?>");

	if (field) {
		field.focus();
	}
</script>
<?php endif; ?>