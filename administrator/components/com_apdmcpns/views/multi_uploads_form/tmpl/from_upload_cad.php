<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(6);
	JToolBarHelper::title( JText::_( 'MULTI_UPLOADS' ) , 'multi_upload.png' );
	JToolBarHelper::customX('save_multi_upload_cad', 'upload', '', 'Upload', false);
	JToolBarHelper::cancel( 'cancel', 'Cancel' );

	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );


?>
<script language="javascript">
	///for add more file 1
/*	window.addEvent('domready', function(){
			//File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier1 span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier1').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier1 span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	
		});*/
		///for add more file 2
	/*window.addEvent('domready', function(){
			//File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier2 span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier2').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier2 span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	
		});*/
		///for add more file 3
	/*window.addEvent('domready', function(){
			//File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier3 span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier3').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier3 span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	
		});*/
	///for add more file 4
	/*window.addEvent('domready', function(){
			//File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier4 span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier4').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier4 span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	
		});*/
		
		///for add more file 5
	/*window.addEvent('domready', function(){
			//File Input Generate
			var mid=0;			
			var mclick=1;
			$$(".iptfichier5 span").each(function(itext,id) {
				if (mid!=0)
					itext.style.display = "none";
					mid++;
			});
			$('lnkfichier5').addEvents ({				
				'click':function(){	
					if (mclick<mid) {
						$$(".iptfichier5 span")[mclick].style.display="block";
					//	alert($$(".iptfichier input")[mclick].style.display);
						mclick++;
					}
				}
			});	
		});*/
		
</script>

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
				<th class="title" width="15%" >
					<?php echo  JText::_('PART_NUMBER_CODE'); ?>
				</th>
				<th width="20%"><?php echo JText::_( 'DOWNLOAD_PDF' ); ?></th>
							
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
				$pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
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
				<td valign="top">
					<?php echo $i+1;?>
				</td>				
				<td valign="top"><span class="editlinktip hasTip" title="<img border=&quot;1&quot; src=&quot;<?php echo $pns_image; ?>&quot; name=&quot;imagelib&quot; alt=&quot;<?php echo JText::_( 'No preview available' ); ?>&quot; width=&quot;300&quot; height=&quot;245&quot; />" >
					<?php echo $pns_code;?>
				</span>
				</td>
				<td align="center">
					<div class="iptfichier<?php echo $i+1?>">
						<span id="1">
							<input type="file" name="pns_cad1<?php echo $row->pns_id?>" /><br />
						</span>
						<span id="2">
							<input type="file" name="pns_cad2<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="3">
							<input type="file" name="pns_cad3<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="4">
							<input type="file" name="pns_cad4<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="5">
							<input type="file" name="pns_cad5<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="6">
							<input type="file" name="pns_cad6<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="7">
							<input type="file" name="pns_cad7<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="8">
							<input type="file" name="pns_cad8<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="9">
							<input type="file" name="pns_cad9<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="10">
							<input type="file" name="pns_cad10<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="11">
							<input type="file" name="pns_cad11<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="12">
							<input type="file" name="pns_cad12<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="13">
							<input type="file" name="pns_cad13<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="14">
							<input type="file" name="pns_cad14<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="15">
							<input type="file" name="pns_cad15<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="16">
							<input type="file" name="pns_cad16<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="17">
							<input type="file" name="pns_cad17<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="18">
							<input type="file" name="pns_cad18<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="19">
							<input type="file" name="pns_cad19<?php echo $row->pns_id?>" /> <br />
						</span>
						<span id="20">
							<input type="file" name="pns_cad20<?php echo $row->pns_id?>" /> <br />
						</span>
					</div>
					<!--<a href="javascript:;"id="lnkfichier<?php //echo $i+1?>" title="Add more file CAD" ><?php //echo JText::_('Click here to add more CAD files');?></a>
-->
					<input type="hidden" name="pns_id[]" value="<?php echo $row->pns_id;?>"  />
					<input type="hidden" name="pns_code[]" value="<?php echo $pns_code;?>" />
					<input type="hidden" name="ccs_code[]" value="<?php echo $row->ccs_code;?>" />
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
<input type="hidden" name="nfile" value="<?php echo $i;?>" />
</form>