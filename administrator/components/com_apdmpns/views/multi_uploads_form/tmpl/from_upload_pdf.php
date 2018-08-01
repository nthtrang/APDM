<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'MULTI_UPLOADS' ) , 'multi_upload.png' );
	JToolBarHelper::customX('save_multi_upload_pdf', 'upload', '', 'Upload', false);
	JToolBarHelper::cancel( 'cancel', 'Cancel' );

	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );


?>

<form action="index.php?option=com_apdmpns" method="post" name="adminForm" enctype="multipart/form-data" >
<div class="col width-50 center">
		<fieldset class="adminform">
			<p class="textupload"><strong><?php echo JText::_('Please choose file to upload')?></strong> <font color="#FF0000"><em><?php echo JText::_('(Please upload file less than 20Mb)')?></em></font></p>
			<table class="adminlist" cellpadding="1">
		 <thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>				
				<th class="title" >
					<?php echo  JText::_('PART_NUMBER_CODE'); ?>
				</th>
				<th><?php echo JText::_( 'DOWNLOAD_PDF' ); ?></th>
				<th><?php echo JText::_( 'PNS_IMAGE' ); ?></th>
							
			</tr>
		</thead>		
		<tbody>
		<?php
			$path_image = '../uploads/pns/images/';
			$k = 0;
			for ($i=0, $n=count( $this->rows ); $i < $n; $i++)
			{
				$row 	=& $this->rows[$i];
				$link 	= 'index.php?option=com_apdmpns&amp;task=detail&cid[0]='.$row->pns_id;					
                                if($row->pns_revision)
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                                else
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code;
                                
				$pns_code_pdf = $row->ccs_code.'_'.$row->pns_code.'_'.$row->pns_revision;
				if ($row->pns_image !=''){
					$pns_image = $path_image.$row->pns_image;
				}else{
					$pns_image = JText::_('NONE_IMAGE_PNS');
				}
				$pns_code_pdf = str_replace("-", "_", $pns_code_pdf);
				//echo $pns_image;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1;?>
				</td>				
				<td><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;300&quot; height=&quot;245&quot; />" >
					<?php echo $pns_code;?>
				</span>
				</td>
				<td align="center">
					<input type="file" name="file<?php echo $row->pns_id;?>"  />
					<input type="hidden" name="pns_id[]" value="<?php echo $row->pns_id;?>"  />
					<input type="hidden" name="pns_code[]" value="<?php echo $pns_code_pdf;?>" />
				</td>	
				<td align="center">
					<input type="file" name="file_img<?php echo $row->pns_id;?>"  /
				</td>		
				
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>
		</fieldset>
</div>
<input type="hidden" name="task" value="" />
</form>