<?php defined('_JEXEC') or die('Restricted access'); ?>
<table width="100%" cellpadding="0" cellspacing="3">
  <thead>
  <th>#No</th>
    <th><?php echo JText::_('List Email')?></th>
    </thead>
  <tbody>
  <?php $i =1;
  foreach ($this->items as $item) { ?>
  	<tr>
		<td><?php echo $i;?>.<input type="checkbox" name="mail_user[]" checked="checked" value="<?php echo $item->email; ?>"  /></td>
		<td><?php echo $item->email; ?></td>
	</tr>
	<?php $i++; } ?>
    </tbody>
</table>
