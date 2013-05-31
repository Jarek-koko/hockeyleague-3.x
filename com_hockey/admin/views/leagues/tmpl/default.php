<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user	= JFactory::getUser();
$userId	= $user->get('id');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_hockey');
$saveOrder	= $listOrder == 'a.ordering';
if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_hockey&task=leagues.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'matchList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
Joomla.orderTable = function() {
    table = document.getElementById("sortTable");
    direction = document.getElementById("directionTable");
    order = table.options[table.selectedIndex].value;
    if (order != '<?php echo $listOrder; ?>') {
        dirn = 'asc';
    } else {
        dirn = direction.options[direction.selectedIndex].value;
    }
    Joomla.tableOrdering(order, dirn, '');
};
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&view=leagues'); ?>" method="post" name="adminForm" id="adminForm">
<?php if(!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>
<div id="filter-bar" class="btn-toolbar">
    <div class="btn-group pull-right hidden-phone">
        <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
        <?php echo $this->pagination->getLimitBox(); ?>
    </div>
    <div class="btn-group pull-right hidden-phone">
        <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
        <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
            <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
            <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
            <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
        </select>
    </div>
    <div class="btn-group pull-right">
        <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
        <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable();">
            <option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
            <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
        </select>
    </div>
</div>        
<div class="clearfix"> </div>
<table class="table table-striped" id="matchList">
    <thead>
      <tr>
          <th width="1%" class="nowrap center hidden-phone">
              <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
          </th>
          <th width="1%" class="hidden-phone">
              <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this);" />
          </th>
          <th width="1%" class="nowrap center hidden-phone"><?php echo JText::_('JSTATUS'); ?></th>
          <th class='left hidden-phone'><?php echo JText::_('COM_HOCKEY_MATCHES_DATA'); ?></th>
          <th class='left hidden-phone'><?php echo JText::_('COM_HOCKEY_MATCHES_TIME'); ?></th>
          <th class='left hidden-phone'><?php echo JText::_('COM_HOCKEY_MATCHES_PLACE'); ?></th>
          <th class='left'><?php echo JText::_('COM_HOCKEY_MATCHES_TEAM_1'); ?></th>
          <th class='left'><?php echo JText::_('COM_HOCKEY_MATCHES_SCORE'); ?></th>
          <th class='left'><?php echo JText::_('COM_HOCKEY_MATCHES_TEAM_2'); ?></th>
          <th class='left'><?php echo JText::_('COM_HOCKEY_MATCHES_REC_HEAD'); ?></th>
          <th width="1%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
          </th>
      </tr>
    </thead>
    <tfoot>
        <tr><td colspan="11"><?php echo $this->pagination->getListFooter(); ?></td></tr>
    </tfoot>
    <tbody>
    <?php foreach ($this->items as $i => $item) :
        $ordering   = ($listOrder == 'a.ordering');
        $canCreate	= $user->authorise('core.create',		'com_hockey');
        $canEdit	= $user->authorise('core.edit',			'com_hockey');
        $canCheckin	= $user->authorise('core.manage',		'com_hockey');
        $canChange	= $user->authorise('core.edit.state',	'com_hockey');
        $canCheckin = $user->authorise('core.manage',       'com_hockey') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
        ?>
        <tr class="row<?php echo $i % 2; ?>">
            <td class="order nowrap center hidden-phone">
            <?php if ($canChange) :
                $disableClassName = '';
                $disabledLabel	  = '';
                if (!$saveOrder) :
                    $disabledLabel    = JText::_('JORDERINGDISABLED');
                    $disableClassName = 'inactive tip-top';
                endif; ?>
                <span class="sortable-handler hasTooltip <?php echo $disableClassName?>" title="<?php echo $disabledLabel?>">
                    <i class="icon-menu"></i>
                </span>
                <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering;?>" class="width-20 text-area-order" />
            <?php else : ?>
                <span class="sortable-handler inactive" ><i class="icon-menu"></i></span>
            <?php endif; ?>
            </td>
            <td class="center hidden-phone"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
            <td class="center hidden-phone"><?php echo JHtml::_('jgrid.published', $item->state, $i, 'leagues.', $canChange, 'cb'); ?></td>
            <td class="hidden-phone">
                <?php if ($item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'hockey.', $canCheckin); ?>
				<?php endif; ?>
                <?php echo $item->data; ?>
            </td>
            <td class="hidden-phone"><?php echo $item->time; ?></td>
            <td class="hidden-phone"><?php echo $item->place; ?></td>
            <td><?php echo $item->team1; ?></td>
            <td><?php echo $item->score_1; ?> : <?php echo $item->score_2; ?></td>
            <td><?php echo $item->team2; ?></td>
            <td><a  class="btn btn-small btn-info" href='<?php echo JRoute::_('index.php?option=com_hockey&view=report&type=0&id_match=' . $item->id); ?>'>
                    <i class="icon-folder icon-white"></i>&nbsp;&nbsp;<?php echo JText::_('COM_HOCKEY_MATCHES_REC_BODY'); ?> 
                </a>
            </td>
            <td class="center hidden-phone"><?php echo (int) $item->id; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>        

		
