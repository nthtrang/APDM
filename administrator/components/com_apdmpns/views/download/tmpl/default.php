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

	$step = $_POST['step'];
	
	$conf['dir'] = "../uploads/pns/cads/PNsZip";
	//echo $this->path;
//	$conf['dir'] = JPATH_ROOT.DS."uploads".DS."pns".DS."cads".DS."PNsZip";
?>
<script language="javascript">
function checkForm(){

	if ($('boxchecked').value==0){
		alert('Please select file.');
		return false;
	}
	return true;
}
</script>
<form action="../uploads/pns/cads/<?php echo $this->ccs_code?>/<?php echo $this->pns_code?>/zip.php?step=1" method="post" name="adminForm" onsubmit="return checkForm();" >
<input type="hidden" name="step" value="1" />
<input type="hidden" name="folderfile" value="<?php echo JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'.DS.$this->ccs_code.DS.$this->pns_code;?>" />
<?php if ($step !=1) { ?> 
<table  width="100%">
		<tr>
			<td align="center">
				<strong><?php echo JText::_('Please select file to download')?></strong>
				
			</td>
	</table>
<table class="adminlist" cellpadding="1"  >
	<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($currentdir);?>, 'zdir');" />
				</th>
				<th class="title" width="20%">
				<?php echo JText::_( 'File Name' ); ?>
				</th>	
				<th class="title" width="20%">
				<?php echo JText::_( 'File Size (KB)' ); ?>
				</th>			
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">
					File name : <input type="text" name="filename" value="<?php echo $this->file_name_zip;?>" size="40" />.zip &nbsp;&nbsp;
					<span>Total size: <input type="text" readonly="readonly" name="total" id="total" value="0" /> (KB)</span>
					<input type="submit" name="submit" value=" Start " />
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php
			$j=1;
			 $path_pns = JPATH_SITE.DS.'uploads'.DS.'pns'.DS.'cads'; 
			for ($i=0;$i<count($currentdir);$i++) {
				
				$entry = $currentdir[$i];

				if (!is_dir($entry)) {		
					$name = $entry;	
					$name_array = explode("/", $name);
					$name_file = $name_array[count($name_array)-1];
					$pns_code  = $name_array[count($name_array)-2];
					$cc = $name_array[count($name_array)-3];
				}
    			   $path_file = $path_pns.DS.$cc.DS.$pns_code.DS.$name_file;
				   $filesize =  ceil( filesize($path_file) / 1000 );                
				if ($name_file !='zip.php' && $name_file !='log_file.txt') {
			?>
			  <tr>
			  	<td><?php echo $j?></td>
				<td align="center" ><input type="checkbox" onclick="isCheckedFile(this.checked, <?php echo $j;?>);"  id="zdir<?php echo $j?>" name="zdir[]" value="<?php echo $name_file?>" /></td>
					<td>&nbsp;<?php echo $name_file?></td>
					<td>&nbsp;<?php echo $filesize?>
					<input type="hidden" name="sizefile<?php echo $j;?>" id="sizefile<?php echo $j;?>" value="<?php echo $filesize?>" />
					</td>
			  </tr>
			<?php $j++;
			}
		
			}?>
		</tbody>

</table>



<?php
 }else {
 	$zdir = $_POST['zdir'];
	if (count($zdir)>0) {
		$dirarray=array();
		$dirsize=0;
		$zdirsize=0;
		for ($i=0;$i<count($zdir);$i++) {
			$ffile = $zdir[$i];
			if (is_dir($ffile)) {
				getdir($ffile);
			} else {
				if ($fsize=@filesize($ffile)) $zdirsize+=$fsize;
			}
		}
		$zdirsize+=$dirsize;
		for ($i=0;$i<count($dirarray);$i++) {
			$zdir[] = $dirarray[$i];
		}
		if (!@is_dir($conf['dir'])) {
			$res = @mkdir($conf['dir'],0777);
			if (!$res) $txtout = "Cannot create dir !<br>";
		} else @chmod($conf['dir'],0777);
	
		$zipname = $_POST['filename'];
		$zipname=str_replace("/","",$zipname);
		if (empty($zipname)) $zipname="PNsZip";
		$zipname.=".zip";
		
		$ziper = new zipfile();
		$ziper->addFiles($zdir);
		$ziper->output("{$conf['dir']}/{$zipname}");
	
		if ($fsize=@filesize("{$conf['dir']}/{$zipname}")) $zipsize=$fsize;
		else $zipsize=0;
		
		$zdirsize = size_format($zdirsize);
		$zipsize = size_format($zipsize);
		
	} 
}?>
<input type="hidden" name="boxchecked" id="boxchecked" value="0" />

<input type="hidden" name="tmpl" value="component" />
</form>


<?php
function size_format($bytes="") {
  $retval = "";
  if ($bytes >= 1048576) {
	$retval = round($bytes / 1048576 * 100 ) / 100 . " MB";
  } else if ($bytes  >= 1024) {
	    $retval = round($bytes / 1024 * 100 ) / 100 . " KB";
    } else {
        $retval = $bytes . " bytes";
      }
  return $retval;
}

?>