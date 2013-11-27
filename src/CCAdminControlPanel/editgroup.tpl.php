<h2>Edit group: <?=$editgroup['name']?></h2>

<?php if($is_authenticated && $user['hasRoleAdmin']): ?>
	<p>View and update group profile</p>
<?=$group_form?>
<?php else: ?>
	<p>Access denied.</p>
<?php endif; ?>
