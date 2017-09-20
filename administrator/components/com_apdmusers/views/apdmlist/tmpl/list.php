<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>


<script language="javascript">
function UpdateUser(){	
	if ($('boxchecked').value==0){
		alert('Please select value.');
		return false;	
	}else{		
		var url = 'index.php?option=com_apdmusers&task=ajax_user';				
		var MyAjax = new Ajax(url, {
			method:'post',
			data:  $('adminFormUser').toQueryString(),
			onComplete:function(result){			
			
				window.parent.document.getElementById('listAjaxUser').innerHTML = result;
				window.parent.document.getElementById('sbox-window').close();	
				

			}
		}).request();

	}
	
}
</script>

<form action="index.php?option=com_apdmusers&task=get_list&tmpl=component" method="post" name="adminForm" id="adminFormUser">
	<table width="100%">
		<tr>
			<td width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="30" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				
			</td>
			
		</tr>
		<tr align="right">
			<td align="right"><input type="button" name="btinsert" value="Insert" onclick="UpdateUser();" /> </td>	
		</tr>
	</table>

	<table class="adminlist" cellpadding="1">
		<thead>
			<tr>
				<th width="2%" class="title">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="3%" class="title">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>
				<th class="title" width="10%">
					<?php echo JHTML::_('grid.sort',   'TEXT_NAME', 'u.name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title" >
					<?php echo JHTML::_('grid.sort',   'EMAIL', 'u.email', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>			
			
				<!--<th width="5%" class="title" nowrap="nowrap">
					<?php //echo JHTML::_('grid.sort',   'TEXT_ENABLE', 'a.user_enable', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>-->
				
				<th width="8%" class="title">
					<?php echo JHTML::_('grid.sort',   'TEXT_GROUP', 'a.user_group', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
			
				
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
			$k = 0;
			for ($i=0, $n=count( $this->items ); $i < $n; $i++)
			{
				$row 	=& $this->items[$i];

				$img 	= $row->user_enable ? 'publish_x.png' : 'tick.png';
				$task 	= $row->user_enable ? 'unblock' : 'block';
				$alt 	= $row->user_enable ? JText::_( 'ENABLE' ) : JText::_( 'UNENABLE' );
				
				if ($row->lastvisitDate == "0000-00-00 00:00:00") {
					$lvisit = JText::_( 'Never' );
				} else {
					$lvisit	= JHTML::_('date', $row->lastvisitDate, '%m-%d-%Y %H:%M:%S');
				}
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
					<?php echo $i+1+$this->pagination->limitstart;?>
				</td>
				<td>
					<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
				</td>
				<td>
					
						<?php echo $row->name; ?>
				</td>
				<td>
					<?php echo $row->email; ?>
					
				</td>			
				
				<!--<td align="center" width="5%">
					
						<img src="images/<?php //echo $img;?>" width="16" height="16" border="0" alt="<?php //echo $alt; ?>" />
				</td>-->
				<td width="8%">
					<?php echo ($row->user_group==23) ? JText::_( 'User' ) : JText::_( 'Administrator' ); ?>
				</td>
				
			
				
				
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_apdmusers" />	
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="boxchecked" value="0" id="boxchecked" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php //echo JHTML::_( 'form.token' ); ?>
</form>