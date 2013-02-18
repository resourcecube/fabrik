<?php
/**
 * Admin Lists List Tmpl
 *
 * @package     Joomla.Administrator
 * @subpackage  Fabrik
 * @copyright   Copyright (C) 2005 Fabrik. All rights reserved.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @since       3.0
 */

// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHTML::_('script','system/multiselect.js',false,true);
$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
?>
<form action="<?php echo JRoute::_('index.php?option=com_fabrik&view=audits'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>:</label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_FABRIK_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">

			<select name="filter_userid" class="inputbox" onchange="this.form.submit()">
				<option value="">-- <?php echo JText::_('COM_FABRIK_USER');?> --</option>
				<?php echo JHtml::_('select.options', $this->userOptions, 'value', 'text', $this->state->get('filter.userid'), true);?>
			</select>

			<select name="filter_listid" class="inputbox" onchange="this.form.submit()">
				<option value="">-- <?php echo JText::_('COM_FABRIK_LIST');?> --</option>
				<?php echo JHtml::_('select.options', $this->listOptions, 'value', 'text', $this->state->get('filter.listid'), true);?>
			</select>

		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="2%">
					<?php echo JHTML::_('grid.sort', 'JGRID_HEADING_ID', 'l.id', $listDirn, $listOrder); ?>
				</th>
				<th width="1%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(this);" />
				</th>
				<th width="16%">
					<?php echo JHTML::_('grid.sort', 'COM_FABRIK_LIST_NAME', 'list', $listDirn, $listOrder); ?>
				</th>
				<th width="17%">
					<?php echo JHTML::_('grid.sort', 'COM_FABRIK_ROW', 'rowid', $listDirn, $listOrder); ?>
				</th>
				<th width="14%">
					<?php echo JText::_('COM_FABRIK_DATE');?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_FABRIK_USER'); ?>
				</th>
				<th width="5%">
					<?php echo JText::_('COM_FABRIK_ACTION');?>
				</th>
				<th width="20%">
					<?php echo JText::_('COM_FABRIK_ROLLBACK_DATA_FROM'); ?>
				</th>
				<th width="20%">
					<?php echo JText::_('COM_FABRIK_ROLLBACK_DATA_TO'); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
				$ordering	= ($listOrder == 'ordering');
				$link	= JRoute::_('index.php?option=com_fabrik&task=list.edit&id='. $item->id);
				$params = new JRegistry($item->params);
				$elementLink = JRoute::_('index.php?option=com_fabrik&task=element.edit&id=0&filter_groupId=' . $this->table_groups[$item->id]->group_id);
 				$formLink = JRoute::_('index.php?option=com_fabrik&task=form.edit&id=' . $item->form_id);
 				$canChange= true;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td>
					<?php echo $item->id; ?>
				</td>
				<td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
				<td>
					<?php
					if ($item->checked_out && ( $item->checked_out != $user->get('id'))) {?>
					<span class="editlinktip hasTip"
						title="<?php echo $item->list . "::" . $params->get('note'); ?>"> <?php echo $item->list; ?>
					</span>
					<?php } else {?>
					<a href="<?php echo $link;?>">
						<span class="editlinktip hasTip" title="<?php echo $item->list . "::" . $params->get('note'); ?>">
							<?php echo $item->list; ?>
						</span>
					</a>
					<?php } ?>
				</td>
				<td>
					<?php echo $item->rowid;?>
				</td>
				<td>
					<?php echo $item->date?>
				</td>
				<td>
					<?php echo $item->user?>
				</td>
				<td>
					<?php echo $item->action?>
				</td>
				<td>
					<?php echo $item->curr?>
				</td>
				<td>
					<?php echo $item->diff?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>