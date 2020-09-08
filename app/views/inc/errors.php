<?php if (!Validate::isValid($data)): ?>
<div class="form-errors">
	ERRORS:
	<ul>
	<?php foreach($data as $key => $obj): ?>
		<li><?= $obj->error; ?></li>
	<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>