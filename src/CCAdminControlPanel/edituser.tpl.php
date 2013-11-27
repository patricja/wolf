<h1>Edit user <?=$edituser['name']?></h1>

<?php if($is_authenticated && $user['hasRoleAdmin']): ?>
<p>View and update user profiles</p>
<?=$profile_form?>
<p>You were created at <?=$user['created']?> and last updated at <?=$user['updated']?>.</p>
<?php else: ?>
<p>Access denied.</p>
<?php endif; ?>
