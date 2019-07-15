<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>

<?php
	$role = JAdministrator::RoleOnComponent(5);
        $cid = JRequest::getVar( 'cid', array(0) );
	//$tabfiles = '<button onclick="javascript:hideMainMenu(); submitbutton(\'files\')" class="buttonfiles" style="vertical-align:middle"><span>Files </span></button>';
    //    $tabApprovers = '<button onclick="javascript:hideMainMenu(); submitbutton(\'approvers\')" class="buttonfiles" style="vertical-align:middle"><span>Approvers </span></button>';
     //   $tabSummary = '<button onclick="javascript:hideMainMenu(); submitbutton(\'summary\')" class="buttonfiles" style="vertical-align:middle"><span>Summary </span></button>';        
	//JToolBarHelper::title( JText::_( 'ADP ECO MAMANGEMENT' )  . ': <small><small>[ '. JText::_( 'Affected Parts Edit' ).' ]</small></small>'.$tabApprovers.$tabSummary, 'cpanel.png' );
	
	
        JToolBarHelper::title( JText::_($this->rowEco->eco_name));
	JToolBarHelper::cancel( 'cancel_listpns', 'Close' );
	if (in_array("E", $role) && $this->rowEco->eco_status !="Released" && $this->rowEco->eco_status !="Inreview") {
		JToolBarHelper::addPns("Add Part",$cid[0]);
                JToolBarHelper::addNew("new_part","New Part");        
	} 
        
//	if (in_array("E", $role)) {
//		JToolBarHelper::editListX();
//	}
	if (in_array("D", $role)&& $this->rowEco->eco_status !="Released" && $this->rowEco->eco_status !="Inreview") {
		JToolBarHelper::deletePns('Are you sure to delete it?',"removepns","Remove Part");
	}
	
	$cparams = JComponentHelper::getParams ('com_media');
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript">
function submitbutton(pressbutton) {
			var form = document.adminForm;
                        if (pressbutton == 'summary') {
                                window.location.assign("index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $cid[0]?>")
                                return;
                        }
//                        if (pressbutton == 'files') {
//                                window.location.assign("index.php?option=com_apdmeco&task=files&cid[]=<?php echo $cid[0]?>");
//                                return;
//                        }      
                        if (pressbutton == 'approvers') {
                                window.location.assign("index.php?option=com_apdmeco&task=approvers&cid[]=<?php echo $cid[0]?>");
                                return;
                        }      
			if (pressbutton == 'cancel_listpns') {				
				submitform( pressbutton );
				return;
			}
                        if (pressbutton == 'new_part') {				
				  window.location.assign("index.php?option=com_apdmpns&task=add&eco_id=<?php echo $cid[0]?>&eco_name=<?php echo $this->rowEco->eco_name?>");
				return;
			}
			if (pressbutton == 'export_bom') {				
				submitform( pressbutton );
				return;
			}
                        if(pressbutton == 'removepns')
                        {
                             submitform( pressbutton );
                             return;
                        }
}

</script>
<div class="submenu-box">
	<div class="t">
                <div class="t">
                        <div class="t"></div>
                </div>
        </div>
        <div class="m">
		<ul id="submenu" class="configuration">
			<li><a id="detail" href="index.php?option=com_apdmeco&task=detail&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="affected" class="active"><?php echo JText::_( 'Affected Parts' ); ?></a></li>
			<li><a id="initial" href="index.php?option=com_apdmeco&task=initial&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Initial Data' ); ?></a></li>
                        <li><a id="supporting" href="index.php?option=com_apdmeco&task=files&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Supporting Document' ); ?></a></li>
                        <li><a id="routes" href="index.php?option=com_apdmeco&task=routes&cid[]=<?php echo $this->rowEco->eco_id;?>"><?php echo JText::_( 'Routes' ); ?></a></li>                     
		</ul>
		<div class="clr"></div>
        </div>
        <div class="b">
                <div class="b">
                        <div class="b"></div>
                </div>
        </div>
</div>
<div class="clr"></div>
<p>&nbsp;</p>
<form action="index.php?option=com_apdmpns" method="post" name="adminForm" onsubmit="submitbutton('')" >
<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
				</th>
				<th class="title" width="12%">
					<?php echo  JText::_('PART_NUMBER_CODE'); ?>
                                </th>
				<th class="title" width="17%">
					<?php echo  JText::_('PNS_DESCRIPTION'); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('State'); ?>
				</th>				
<!--				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Status'); ?>
				</th>-->
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_('Make/Buy'); ?>
				</th>
                                <th width="8%" class="title"  >
					<?php echo JText::_( 'Vendor' ); ?>
				</th>
                                <th width="8%" class="title"  >
					<?php echo JText::_( 'Vendor PN' ); ?>
				</th>                                
				<th width="8%" class="title"  >
					<?php echo JText::_( 'Supplier' ); ?>
				</th>
				<th width="8%" class="title"  >
					<?php echo JText::_( 'Supplier PN' ); ?>
				</th>				
				<th width="8%" class="title">
					<?php echo JText::_( 'MFR Name' ); ?>
				</th>
				<th width="8%" class="title">
					<?php echo JText::_( 'MFG PN' ); ?>
				</th>                                
				<th width="10%"  class="title">&nbsp;
				</th>                                
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
                                $edit_link = 'index.php?option=com_apdmpns&amp;task=edit&cid[0]='.$row->pns_id;					
                                if($row->pns_revision)
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code.'-'.$row->pns_revision;
                                else
                                        $pns_code = $row->ccs_code.'-'.$row->pns_code;
                                
				$image = ECOController::GetImagePreview($row->pns_id);
				if ($image !=''){					
                                        $pns_image = "<img border=&quot;1&quot; src='".$path_image.$image."' name='imagelib' alt='".JText::_( 'No preview available' )."' width='100' height='100' />";
				}else{
					$pns_image = JText::_('None image for preview');
				}
				//echo $pns_image;
				$mf = EcoController::GetPnManufacture($row->pns_id);
				$mv = EcoController::GetPnVendor($row->pns_id);
                                $ms = EcoController::GetPnSupplier($row->pns_id);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $i+1;?>
				</td>
				<td align="center">
					<?php echo JHTML::_('grid.id', $i, $row->pns_id ); ?>
				</td>
				<td align="left"><span class="editlinktip hasTip" title="<?php echo $pns_image;?>" >
					<a href="<?php echo $link;?>" title="<?php echo JText::_('Click to see detail PNs');?>"><?php echo $pns_code;?></a>
				</span>
				</td>	
				
				<td align="left">
					<?php echo $row->pns_description; ?>
				</td>
				<td align="center">
					<?php echo $row->pns_life_cycle; ?>
				</td>		
<!--				<td align="center">
					<?php echo $row->pns_status; ?>
				</td>		                                -->
				<td align="center">
					<?php echo $row->pns_type;?>
				</td>
				<td align="left">
                    <table>
                        <?php
                        if (count($mv) > 0) {
                            $imv=1;
                            foreach ($mv as $m) {
                                $style="style='border-bottom:1px solid #eee;'";
                                if($imv==count($mv))
                                    $style ="style='border-bottom:none'";
                                echo "<tr><td ".$style.">".$m['vendor_name'] . '</tr></td>';
                                $imv++;
                            }
                        }
                        ?>
                    </table>
				</td>
				<td align="left">
                    <table>
                        <?php
                        if (count($mv) > 0) {
                            $imv1=1;
                            foreach ($mv as $m) {
                                $style="style='border-bottom:1px solid #eee;'";
                                if($imv1==count($mv))
                                    $style ="style='border-bottom:none'";
                                echo "<tr><td ".$style.">".$m['vendor_info'] . '</tr></td>';
                                $imv1++;
                            }
                        }
                        ?>
                    </table>
				</td>   
				<td align="left">
                    <table>
                        <?php
                        if (count($ms) > 0) {
                            $ims=1;
                            foreach ($ms as $m) {
                                $style="style='border-bottom:1px solid #eee;'";
                                if($ims==count($ms))
                                    $style ="style='border-bottom:none'";
                                echo "<tr><td ".$style.">".$m['supplier_name'] . '</tr></td>';
                                $ims++;
                            }
                        }
                        ?>
                    </table>

				</td>
				<td align="left">
                    <table>
                        <?php
                        if (count($ms) > 0) {
                            $ims1=1;
                            foreach ($ms as $m) {
                                $style="style='border-bottom:1px solid #eee;'";
                                if($ims1==count($ms))
                                    $style ="style='border-bottom:none'";
                                echo "<tr><td ".$style.">".$m['supplier_info'] . '</tr></td>';
                                $ims1++;
                            }
                        }
                        ?>
                    </table>
				</td>
                <td align="left">
                    <table>
                        <?php
                        if (count($mf) > 0) {
                            $imf=1;
                            foreach ($mf as $m) {
                                $style="style='border-bottom:1px solid #eee;'";
                                if($imf==count($mf))
                                    $style ="style='border-bottom:none'";
                                echo "<tr><td ".$style.">".$m['mf'] . '</tr></td>';
                                $imf++;
                            }
                        }
                        ?>
                    </table>
                </td>
                <td align="left">
                    <table>
                        <?php
                        if (count($mf) > 0) {
                            $imf1=1;
                            foreach ($mf as $m) {
                                $style="style='border-bottom:1px solid #eee;'";
                                if($imf1==count($mf))
                                    $style ="style='border-bottom:none'";
                                echo "<tr><td ".$style.">".$m['v_mf'] . '</tr></td>';
                                $imf1++;
                            }

                        }
                        ?> </table>
                </td>
				<td align="center">
					<?php 
     
if ($row->pns_life_cycle =='Create') {
		?>
                  <a href="<?php echo $edit_link;?>" class="toolbar">
<span class="icon-32-edit" title="Edit">
</span>
Edit
</a>
                                        <?php 
		
	}
        else
        {
                echo "Can not edit";
        }
        
					 ?>
				</td>                                
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<div class="clr"></div>	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
        <input type="hidden" name="eco" value="<?php echo $cid[0]?>" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>



