<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_hockey');
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

 function searchPlayer(val) {
    var f = document.adminForm;
    if(f){
        f.elements['filter_search'].value = val;
        f.submit();
    }
};
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&view=players'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty($this->sidebar)): ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
<?php else : ?>
        <div id="j-main-container">
<?php endif; ?>
<div id="filter-bar" class="btn-toolbar">
    <div class="filter-search btn-group pull-left">
        <label for="filter_search" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER'); ?></label>
        <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
    </div>
    <div class="btn-group pull-left">
        <button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
        <button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value = '';
            this.form.submit();"><i class="icon-remove"></i></button>
    </div>
    <div class="btn-group pull-right hidden-phone">
        <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
        <?php echo $this->pagination->getLimitBox(); ?>
    </div>
    <div class="btn-group pull-right hidden-phone">
        <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
        <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
            <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
            <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
            <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
        </select>
    </div>
    <div class="btn-group pull-right">
        <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
        <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
            <option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
            <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
        </select>
    </div>
</div>    
<div class="clearfix"></div>
<div class="row-fluid  span12 center">
    <div class="span12 btn-toolbar hidden-phone">
    <?php
       for ($i = 65; $i < 91; $i++) {
           echo '<a class="btn btn-mini" href="javascript:searchPlayer(\'' . chr($i) . '\')">' . chr($i) . '</a>';
       }
    ?>
    </div>    
</div>
<table class="table table-striped" id="playerList">
    <thead>
        <tr>
            <th width="1%" class="hidden-phone">
                <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
            </th>
            <th width="1%" class="nowrap center">
                <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
            </th>
            <th class='left'>
                <?php echo JHtml::_('grid.sort', 'COM_HOCKEY_PLAYERS_NAME', 'a.name', $listDirn, $listOrder); ?>
            </th>
            <th class='left'>
                <?php echo JHtml::_('grid.sort', 'COM_HOCKEY_PLAYERS_FIRST_NAME', 'a.first_name', $listDirn, $listOrder); ?>
            </th>
            <th class='left hidden-phone'>
                <?php echo JHtml::_('grid.sort', 'COM_HOCKEY_PLAYERS_POSITION', 'a.position', $listDirn, $listOrder); ?>
            </th>
             <th class='left hidden-phone'>
                <?php echo JHtml::_('grid.sort', 'COM_HOCKEY_PLAYERS_TEAM', 'team', $listDirn, $listOrder); ?>
            </th>
            <th width="1%" class="nowrap center hidden-phone">
                <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
            </th>
        </tr>
    </thead>
    <tfoot>
        <tr>
         <td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach ($this->items as $i => $item) :  
            $canCreate = $user->authorise('core.create', 'com_hockey');
            $canEdit = $user->authorise('core.edit', 'com_hockey');
            $canCheckin = $user->authorise('core.manage', 'com_hockey');
            $canChange = $user->authorise('core.edit.state', 'com_hockey');
            ?>
            <tr class="row<?php echo $i % 2; ?>">
                <td class="center hidden-phone"><?php echo JHtml::_('grid.id', $i, $item->id); ?> </td>
                <td class="center"><?php echo JHtml::_('jgrid.published', $item->state, $i, 'players.', $canChange, 'cb'); ?></td>
                <td>
                    <?php if ($canEdit) : ?>
                        <a href="<?php echo JRoute::_('index.php?option=com_hockey&task=player.edit&id=' . (int) $item->id); ?>">
                            <?php echo $this->escape($item->name); ?>
                        </a>
                    <?php else : ?>
                        <?php echo $this->escape($item->name); ?>
                    <?php endif; ?>
                </td>
                <td><?php echo $item->first_name; ?></td>
                <td class="hidden-phone"><?php echo HockeyHelper::getPositionString($item->position); ?></td>
                <td class="hidden-phone"><?php echo $item->team; ?></td>
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


