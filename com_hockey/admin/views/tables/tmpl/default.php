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
	$saveOrderingUrl = 'index.php?option=com_hockey&task=tables.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'tableList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
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
<form action="<?php echo JRoute::_('index.php?option=com_hockey&view=tables'); ?>" method="post" name="adminForm" id="adminForm">
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
        <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
            <option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
            <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
        </select>
    </div>
</div>        
<div class="clearfix"> </div>
<table class="table table-striped" id="tableList">
    <thead>
        <tr>
            <th width="1%" class="nowrap center hidden-phone">
                <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
            </th>
            <th width="1%" class="hidden-phone">
                <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
            </th>
            <th width="1%" class="nowrap center hidden-phone">
                <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
            </th>
            <th class='left'><?php echo JText::_('COM_HOCKEY_TABLES_TEAM_ID'); ?></th>
            <th class='left'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_MATCHDAY', 'a.matchday', $listDirn, $listOrder); ?>
            </th>
            <th class='left'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_POINTS', 'a.points', $listDirn, $listOrder); ?>
            </th>
            <th class='left hidden-phone'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_WON', 'a.won', $listDirn, $listOrder); ?>
            </th> 
            <th class='left hidden-phone'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_TIES', 'a.ties', $listDirn, $listOrder); ?>
            </th>
            <th class='left hidden-phone'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_LOST', 'a.lost', $listDirn, $listOrder); ?>
            </th>
            <th class='left hidden-phone'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_GOALS_SCORED', 'a.goals_scored', $listDirn, $listOrder); ?>
            </th>
            <th class='left hidden-phone'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_GOALS_AGAINST', 'a.goals_against', $listDirn, $listOrder); ?>
            </th>
            <th class='left hidden-phone'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_DIFFERENCE', 'a.difference', $listDirn, $listOrder); ?>
            </th>
            <th class='left hidden-phone'>
            <?php echo JHtml::_('grid.sort',  'COM_HOCKEY_TABLES_GROUP', 'a.group', $listDirn, $listOrder); ?>
            </th>
            <th width="1%" class="nowrap center hidden-phone">
            <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
            </th>
        </tr>
    </thead>
    <tfoot>
        <tr><td colspan="14"><?php echo $this->pagination->getListFooter(); ?></td></tr>
    </tfoot>
    <tbody>
    <?php foreach ($this->items as $i => $item) :
        $ordering   = ($listOrder == 'a.ordering');
        $canCreate	= $user->authorise('core.create',		'com_hockey');
        $canEdit	= $user->authorise('core.edit',			'com_hockey');
        $canCheckin	= $user->authorise('core.manage',		'com_hockey');
        $canChange	= $user->authorise('core.edit.state',	'com_hockey');
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
                    <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering;?>" class="width-20 text-area-order " />
                <?php else : ?>
                    <span class="sortable-handler inactive" ><i class="icon-menu"></i></span>
                <?php endif; ?>
            </td>
            <td class="center hidden-phone"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
            <td class="center hidden-phone"><?php echo JHtml::_('jgrid.published', $item->state, $i, 'tables.', $canChange, 'cb'); ?></td> 
            <td>
            <?php if ($canEdit) : ?>
            <a href="<?php echo JRoute::_('index.php?option=com_hockey&task=table.edit&id=' . (int) $item->id); ?>">
                <?php echo $this->escape($item->team); ?>
            </a>
            <?php else : ?>
                 <?php echo $this->escape($item->team);?>
            <?php endif; ?>
            </td>
            <td><?php echo $item->matchday; ?></td>
            <td><?php echo $item->points; ?></td>
            <td  class="hidden-phone"><?php echo $item->won; ?></td>
            <td  class="hidden-phone"><?php echo $item->ties; ?></td>
            <td  class="hidden-phone"><?php echo $item->lost; ?></td>
            <td  class="hidden-phone"><?php echo $item->goals_scored; ?></td>
            <td  class="hidden-phone"><?php echo $item->goals_against; ?></td>
            <td  class="hidden-phone"><?php echo $item->difference; ?></td>
            <td  class="hidden-phone"><?php echo $item->group; ?></td>
            <td class="center hidden-phone"><?php echo $item->id; ?></td>
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

		
