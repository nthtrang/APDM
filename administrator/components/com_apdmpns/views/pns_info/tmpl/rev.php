<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php	

	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
        $partnumber = $this->row->ccs_code.'-'.$this->row->pns_code;
        if ($this->row->pns_revision) 
                $partnumber .= '-'.$this->row->pns_revision;	
	JToolBarHelper::title( $partnumber , 'cpanel.png' );
        $role = JAdministrator::RoleOnComponent(6);      
	if (in_array("E", $role)&& $this->row->pns_life_cycle =='Create') {
                if (!intval($edit)) {
                        JToolBarHelper::save('save', 'Save & Add new');
                }

                JToolBarHelper::apply('edit_pns', 'Save');
                JToolBarHelper::addPnsRev("Rev Roll",$this->row->pns_id);
        }
	if ( $edit ) {
		// for existing items the button is renamed `close`
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}
        
	$cparams = JComponentHelper::getParams ('com_media');
	$editor = &JFactory::getEditor();
?>

<?php
	// clean item data
	JFilterOutput::objectHTMLSafe( $user, ENT_QUOTES, '' );

	
?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
                var mf_info= document.getElementsByName("mf_info[]");
                for(var i=0;i<mf_info.length;i++)
                {
                        if(mf_info[i].value =='')
                        {
                                alert("Must input PNS");
                                return;
                        }
                }
		submitform( pressbutton );
	}
        function removeMf(id)
        {
                var parent = document.getElementById("manufacture_get");
                var mf = document.getElementById(id);
                parent.removeChild(mf);
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
			<li><a id="detail"  href="index.php?option=com_apdmpns&task=detail&cid[0]=<?php echo $this->row->pns_id?>"><?php echo JText::_( 'Detail' ); ?></a></li>
			<li><a id="bom" href="index.php?option=com_apdmpns&task=bom&id=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'BOM' ); ?></a></li>
			<li><a id="whereused" href="index.php?option=com_apdmpns&task=whereused&id=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'Where Used' ); ?></a></li>
                        <li><a id="specification" href="index.php?option=com_apdmpns&task=specification&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'Specification' ); ?></a></li>
                        <li><a id="mep" href="index.php?option=com_apdmpns&task=mep&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'MEP' ); ?></a></li>
                        <li><a id="rev" class="active"><?php echo JText::_( 'REV' ); ?></a></li>
                        <li><a id="dash" href="index.php?option=com_apdmpns&task=dash&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'DASH ROLL' ); ?></a></li>
                        <li><a id="pos" href="index.php?option=com_apdmpns&task=po&cid[]=<?php echo $this->row->pns_id;?>"><?php echo JText::_( 'POs' ); ?></a></li>                        
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
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" >	
		<?php if (count($this->revision) > 0) { ?>
		<table class="adminlist" cellspacing="1" width="400">
				<thead>
					<tr>
                                                <th width="100"><?php echo JText::_( 'No' ); ?></th>
                                                <th width="200"><?php echo JText::_( 'P/N' ); ?></th>
					<th width="100"><?php echo JText::_( 'Revision' ); ?></th>
						<th width="100"><?php echo JText::_( 'State' ); ?></th>
						<th width="100"><?php echo JText::_( 'ECO' ); ?></th>
                                                <th width="100"><?php echo JText::_( 'REV ROLL' ); ?></th>
					</tr>
				</thead>
				<tbody>					
					<?php 
                                        $i=0;
                                        foreach($this->revision as $rev) { 
                                             $i++;  
                                                ?>
					<tr>
                                                <td><?php echo $i;?></td>
                                                <td><input type="hidden" name="m_exist[]" value="<?php echo $rev->pns_rev_id;?>" >
                                                        <input type="hidden" name="m_exist_id[]" value="<?php echo $rev->pns_rev_id;?>" >
                                                        <?php echo $rev->parent_pns_code?> 
                                                </td>
                                                <td><input type="text" size="40" value="<?php echo $rev->pns_revision;?>" name="pns_revision[]" /> </td>
                                                <td><?php echo $rev->pns_life_cycle;?> </td>
                                                <td><?php echo $rev->eco_name;?></td>
                                                <td><a href="index.php?option=com_apdmpns&task=update_rev_roll&rev=<?php echo $rev->pns_revision;?>&id=<?php echo $rev->pns_rev_id;?>&pns_id=<?php echo $this->row->pns_id?>" title="Click to remove"><?php echo JText::_('Set rev')?></a>
                                                </td></tr>
		<?php }
		 } ?>
				</tbody>
				</table>		
	
<div style="display:none"><?php
						// parameters : areaname, content, width, height, cols, rows
						echo $editor->display( 'text',  $row->text , '10%', '10', '10', '3' ) ;
						?></div>
	<input name="nvdid" value="<?php echo $this->lists['count_vd'];?>" type="hidden" />
	<input name="nspid" value="<?php echo $this->lists['count_sp'];?>" type="hidden" />
	<input name="nmfid" value="<?php echo $this->lists['count_mf'];?>" type="hidden" />
	<input type="hidden" name="pns_id" value="<?php echo $this->row->pns_id;?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->row->pns_id;?>" />	
	<input type="hidden" name="option" value="com_apdmpns" />
	<input type="hidden" name="task" value="" />
        <input type="hidden" name="redirect" value="mep" />
	<input type="hidden" name="return" value="<?php echo $this->cd;?>"  />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
