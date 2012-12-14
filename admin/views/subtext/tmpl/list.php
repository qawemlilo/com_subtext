<?php
	defined('_JEXEC') or die('Restricted access');
	JHtml::_('behavior.modal');
	JHtml::_('behavior.tooltip');
	JHtml::_('behavior.formvalidation');
	$user	= JFactory::getUser();
	$uri	= JURI::getInstance();
	$base = $uri->root();
?>

<form action="index.php" method="post" name="adminForm">
	<input type="hidden" name="option" value="com_subtext" />
	<input type="hidden" name="scope" value="" />
	<input type="hidden" name="task" value="subtext.filter" />
	<input type="hidden" name="chosen" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<? echo $this->filter->filter_order; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<? echo $this->filter->filter_order_Dir; ?>" />
	<? echo JHTML::_('form.token')."\n"; ?>
	<table>
		<tr>
			<td width="100%">
				<? echo JText::_('COM_SUBTEXT_FILTER_SEARCH_LABEL'); ?>
				<input type="text" name="filter_search" id="filter-search_" value="<? echo $this->filter->filter_search; ?>" />
				<input type="button" name="submit_button" id="submit-button_" value="Go" onclick="document.forms.adminForm.task.value='filter';document.forms.adminForm.submit();"/>
				<input type="button" name="reset_button" id="reset-button_" value="Reset" onclick="document.forms.adminForm.filter_search.value='';document.forms.adminForm.task.value='filter';document.forms.adminForm.submit();"/>
			</td>
		</tr>
	</table>
	<table class="adminlist">
		<thead>
			<tr>
				<th width="5">
					<? echo JText::_('Num'); ?>
				</th>
				<th width="5">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<? echo count( $this->items ); ?>);" />
				</th>
				<th class="title" nowrap="nowrap">
					<? echo JHTML::_('grid.sort', JText::_('COM_SUBTEXT_LIST_SUBTEXT_NAME_LABEL'), 'subtext_name', $this->filter->filter_order_Dir, $this->filter->filter_order, 'subtext.filter'); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<? echo JHTML::_('grid.sort', JText::_('COM_SUBTEXT_LIST_PUBLISHED_LABEL'), 'published', $this->filter->filter_order_Dir, $this->filter->filter_order, 'subtext.filter'); ?>
				</th>
				<th width="10%" nowrap="nowrap">
					<? echo JHTML::_('grid.sort', JText::_('COM_SUBTEXT_LIST_ORDERING_LABEL'), 'ordering', $this->filter->filter_order_Dir, $this->filter->filter_order, 'subtext.filter');?>
					<? echo JHTML::_('grid.order', $this->items, 'filesave.png', 'subtext.saveorder'); ?>
				</th>
				<th nowrap="nowrap">
					<? echo JHTML::_('grid.sort', JText::_('COM_SUBTEXT_LIST_ACCESS_LABEL'), 's.access', $this->filter->filter_order_Dir, $this->filter->filter_order, 'subtext.filter'); ?>
				</th>
				<th>
					<? echo JText::_('COM_SUBTEXT_LIST_DESCRIPTION_LABEL'); ?>
				</th>
				<th width="1%">
					<? echo JText::_('COM_SUBTEXT_LIST_ID_LABEL'); ?>
				</th>
			</tr>
		</thead>
		<tbody>
		<?
		$k = 0;
		for($i=0; $i < count($this->items); $i++){
			$row		= $this->items[$i];
			$checked	= JHTML::_('grid.id', $i, $row->subtext_id);
			$link		= JRoute::_('index.php?option=com_subtext&task=subtext.edit&subtext_id='. $row->subtext_id.'&'.JUtility::getToken().'=1');
			?>
			<tr class="row<? echo $k; ?>">
				<td>
					<? echo $this->page->getRowOffset($i); ?>
				</td>
				<td align="center">
					<? echo $checked; ?>
				</td>
				<td  nowrap="nowrap">
					<?
					if(JTable::isCheckedOut($user->get('id'), $row->checked_out)){
						echo JHTML::_('grid.checkedout', $row, $i, 'subtext_id');
						echo JText::_( $row->subtext_name);
					}else{
						echo "<a href=\"{$link}\">" . htmlspecialchars($row->subtext_name, ENT_QUOTES) . "</a>";
					}
					?>
				</td>
				<td align="center">
					<?php echo JHtml::_('jgrid.published', $row->published, $i, 'subtext.', true, 'cb'); ?>
				</td>
				<td class="order">
					<span><? echo $this->page->orderUpIcon( $i, ($this->page->getRowOffset($i) > 1), 'subtext.orderup', 'Move Up'); ?></span>
					<span><? echo $this->page->orderDownIcon( $i, count($this->items), true, 'subtext.orderdown', 'Move Down'); ?></span>
					<input type="text" name="order[]" size="5" value="<? echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<td align="center">
					<? echo $row->access; ?>
				</td>
				<td>
					<? echo implode(" ", array_splice(explode(" ", strip_tags($row->subtext_description)), 0, 55)); ?>
				</td>
				<td>
					<? echo $row->subtext_id; ?>
				</td>
			</tr>
			<?
			$k = 1 - $k;
		}
		?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="10">
					<? echo $this->page->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
</form>