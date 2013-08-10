<?php
	JHtml::_('behavior.multiselect');
	JHtml::_('formbehavior.chosen', 'select');
	JHtml::_('bootstrap.tooltip');
	$user = JFactory::getUser();
	$user_id = $user->get('id');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<input type="hidden" name="option" value="com_subtext" />
	<input type="hidden" name="scope" value="" />
	<input type="hidden" name="task" value="subtext.filter" />
	<input type="hidden" name="chosen" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $this->filter->filter_order; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter->filter_order_Dir; ?>" />
	<?php echo JHtml::_('form.token')."\n"; ?>
	<div id="filter-bar" class="btn-toolbar">
		<div class="btn-group pull-right">
			<?php echo $this->page->getLimitBox(); ?>
		</div>
		<div class="btn-group pull-left">
			<input type="text" name="filter_search" id="filter-search_" class="input-large" placeholder="<?php echo JText::_('COM_SUBTEXT_FILTER_SEARCH_LABEL'); ?>" value="<?php echo $this->filter->filter_search; ?>" />
		</div>
		<div class="btn-group pull-left">
			<input type="button" class="btn" name="submit_button" id="submit-button_" value="Go" onclick="document.forms.adminForm.task.value='filter';document.forms.adminForm.submit();"/>
			<input type="button" class="btn" name="reset_button" id="reset-button_" value="Reset" onclick="document.forms.adminForm.filter_search.value='';document.forms.adminForm.task.value='filter';document.forms.adminForm.submit();"/>
		</div>
	</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="5">
					<?php echo JText::_('Num'); ?>
				</th>
				<th width="5">
					<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this)" />
				</th>
				<th class="title" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_SUBTEXT_LIST_SUBTEXT_NAME_LABEL', 'subtext_name', $this->filter->filter_order_Dir, $this->filter->filter_order, 'subtext.filter'); ?>
				</th>
				<th width="5%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_SUBTEXT_LIST_PUBLISHED_LABEL', 'published', $this->filter->filter_order_Dir, $this->filter->filter_order, 'subtext.filter'); ?>
				</th>
				<th class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_SUBTEXT_LIST_ORDERING_LABEL', 'ordering', $this->filter->filter_order_Dir, $this->filter->filter_order, 'subtext.filter');?>
				</th>
				<th class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_SUBTEXT_LIST_ACCESS_LABEL', 's.access', $this->filter->filter_order_Dir, $this->filter->filter_order, 'subtext.filter'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_SUBTEXT_LIST_DESCRIPTION_LABEL'); ?>
				</th>
				<th width="1%">
					<?php echo JText::_('COM_SUBTEXT_LIST_ID_LABEL'); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$k = 0;
		for($i=0; $i < count($this->items); $i++){
			$row		= $this->items[$i];
			$checked	= JHtml::_('grid.id', $i, $row->subtext_id);
			$link		= JRoute::_('index.php?option=com_subtext&task=subtext.edit&subtext_id='. $row->subtext_id.'&'.JSession::getFormToken().'=1');
			$canCreate  = $user->authorise('core.create',     'com_subtext');
			$canEdit    = $user->authorise('core.edit',       'com_subtext');
			$canCheckin = $user->authorise('core.manage',     'com_checkin') || $row->checked_out == $user_id || $row->checked_out == 0;
			$canEditOwn = $user->authorise('core.edit.own',   'com_subtext');
			$canChange  = $user->authorise('core.edit.state', 'com_subtext') && $canCheckin;
			?>
			<tr class="row<?php echo $k; ?>">
				<td>
					<?php echo $this->page->getRowOffset($i); ?>
				</td>
				<td align="center">
					<?php echo $checked; ?>
				</td>
				<td  class="nowrap">
					<?php
					if($row->checked_out){
						echo JHtml::_('jgrid.checkedout', $i, $row->editor, $row->checked_out_time, 'subtext.', $canCheckin);
						echo "<span class=\"title\">".JText::_( $row->subtext_name)."</span>";
					}else{
						if($canEdit || $canEditOwn){
							echo "<a href=\"{$link}\">" . htmlspecialchars($row->subtext_name, ENT_QUOTES) . "</a>";
						}else{
							echo "<span class=\"title\">".JText::_( $row->subtext_name)."</span>";
						}
					}
					?>
				</td>
				<td align="center">
					<?php echo JHtml::_('jgrid.published', $row->published, $i, 'subtext.', $canChange, 'cb'); ?>
				</td>
				<td class="order">
					<div class="input-prepend input-append">
					<?php echo str_replace('btn btn-micro', 'btn add-on', $this->page->orderUpIcon( $i, ($this->page->getRowOffset($i) > 1), 'subtext.orderup', 'Move Up')); ?>
					<input type="text" name="order[]" class="input-mini" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
					<?php echo str_replace('btn btn-micro', 'btn add-on', $this->page->orderDownIcon( $i, count($this->items), true, 'subtext.orderdown', 'Move Down')); ?>
					</div>
				</td>
				<td align="center">
					<?php echo $row->access; ?>
				</td>
				<td>
					<?php $words = explode(" ", strip_tags($row->subtext_description)); echo implode(" ", array_splice($words, 0, 55)); ?>
				</td>
				<td>
					<?php echo $row->subtext_id; ?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="10">
					<?php echo $this->page->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
</form>
