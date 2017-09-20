<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>
<?php
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	$currentdir = PNsController::getcurrentdir($this->path);
	sort($currentdir);
?>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm" >
<table  width="100%">
		<tr>
			<td width="35%" >
				<?php echo JText::_('Please select file to download')?>
				
			</td>
	</table>
<table class="admintable" cellpadding="1"  >
<?
for ($i=0;$i<count($currentdir);$i++) {
	$entry = $currentdir[$i];
	if (!is_dir($entry)) {		
		$name = $entry;	
		$name_array = explode("/", $name);
		$name_file = $name_array[count($name_array)-1];
	}
?>
  <tr>
    <td ><input type="checkbox" name="zdir[]" value="<?=$entry?>" />&nbsp;<?=$name_file?></td>
  </tr>
<? } ?>
<tr>
    <td  ><input type="checkbox" name="all"onclick="javascript:checkall();" />&nbsp;Select all</td>
  </tr>
</table>
<br />
<table>
<tr>
    <td>File name : <input type="text" name="filename" value="PNsZip" size="40" />.zip</td>
	<td align="right"><input type="submit" name="submit" value="Start" /></td>
  </tr>
</table>
<input type="hidden" name="option" value="com_apdmpns" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="pns_id" value="<?php echo $this->lists['pns_id'];?>"  />
<input type="hidden" name="return" value="<?php echo $this->lists['pns_id'];?>"  />
<input type="hidden" name="cd" value="<?php echo $this->lists['pns_id'];?>"  />
</form>


