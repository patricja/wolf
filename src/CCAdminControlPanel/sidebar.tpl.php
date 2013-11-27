<h3>ACP options</h3>
<?php if($is_authenticated && $user['hasRoleAdmin']): ?>
<ul>
<li><a href="<?=create_url('acp/users')?>">Manage users</a></li>
<li><a href="<?=create_url('acp/groups')?>">Manage groups</a></li>
<li><a href="<?=create_url('acp/content')?>">Manage content</a></li>
</ul>
<?php else: ?>
<p>You don't have permission to mange the ACP</p>
<?php endif; ?>
