<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php  JHTML::_('behavior.tooltip');  ?>

<?php
	JToolBarHelper::title( JText::_( 'APDM User Management' ), 'user.png' );	
	JToolBarHelper::editListX();
	JToolBarHelper::addNewX();

?>

<form action="index.php?option=com_apdmusers" method="post" name="adminForm">
	<table>
		<tr>
			<td width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" size="30" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				
			</td>
			<td nowrap="nowrap">
				<?php echo $this->lists['role'];?>
				<?php echo $this->lists['block'];?>
				<?php echo $this->lists['type'];?>
				<?php echo $this->lists['created_by'];?>
				<?php echo  JText::_('FILTER_DATE_CREATE').' '.JHTML::_('calendar', $this->lists['filter_date_created'], 'filter_date_created', 'filter_date_created', '%m-%d-%Y', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'10')); ?>		
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_type').value='0';this.form.getElementById('filter_block').value='-1';this.form.submit();this.form.getElementById('filter_role').value='0';this.form.getElementById('filter_created_by').value='0';this.form.getElementById('filter_date_created').value='';"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
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
					<?php echo JHTML::_('grid.sort',   'TEXT_USERNAME', 'a.username', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th class="title">
					<?php echo JText::_('TEXT_TITLE'); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'TEXT_ROLE' ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'TEXT_ENABLE', 'a.user_enable', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				
				<th width="8%" class="title">
					<?php echo JHTML::_('grid.sort',   'TEXT_GROUP', 'a.user_group', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
			
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JText::_( 'TEXT_HISTORY' ); ?>
				</th>
				<th width="10%" class="title">
					<?php echo JHTML::_('grid.sort',   'TEXT_LAST_VISIT', 'u.lastvisitDate', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="10%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'TEXT_DATE_CREATED', 'a.user_create', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
				<th width="5%" class="title" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'TEXT_CREATED_BY', 'a.user_create_by', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="12">
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
				$link 	= 'index.php?option=com_apdmusers&amp;view=apdmuser&amp;task=edit&amp;cid[]='. $row->id. '';

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
					<a href="<?php echo $link; ?>">
						<?php echo $row->name; ?></a>
				</td>
				<td><a href="mailto:<?php echo $row->username; ?>">
					<?php echo $row->username; ?>
					</a>
				</td>
				<td>
					<?php echo $row->user_title;?>
				</td>
				<td align="left" width="10%">
					<?php 	$GetRoleUser = APDMUsersController::GetRoleUser($row->id);
					if (count ($GetRoleUser) > 0){
						echo '- '.implode('<br /> - ', $GetRoleUser);
					}else{
						echo JText::_('EMPTY_ROLE');
					}
					?>
				</td>
				<td align="center" width="5%">
					<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /></a>
				</td>
				<td width="8%">
					<?php echo ($row->user_group==23) ? JText::_( 'User' ) : JText::_( 'Administrator' ); ?>
				</td>
				<!--<td>
					<a href="mailto:<?php //echo $row->user_email; ?>">
						<?php //echo $row->user_email; ?></a>
				</td>-->
				<td nowrap="nowrap">
						<a href="#" title="Click to see list history">Link</a>
				</td>
				<td nowrap="nowrap">
					<?php echo $lvisit; ?>
				</td>
				<td>
					<?php echo  JHTML::_('date', $row->user_create, '%m-%d-%Y %H:%M:%S'); ?>
				</td>
				<td width="5%">
					<?php echo APDMUsersController::GetValueAPDMUser($row->user_create_by, "name"); ?>
				</td>
			</tr>
			<?php
				$k = 1 - $k;
				}
			?>
		</tbody>
	</table>

	<input type="hidden" name="option" value="com_apdmusers" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>