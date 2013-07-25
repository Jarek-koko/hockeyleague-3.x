<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

JFormHelper::loadFieldClass('list');
class JFormFieldSelectevent extends JFormFieldList
{
    /**
     * The form field type.
     *
     * @var		string
     * @since	1.6
     */
    protected $type = 'Selectevent';

    /**
     * Generate dropdown options
     */
    public function getOptions()
    {
        // Initialize variables.
        $options = array();

        $params = JComponentHelper::getParams('com_hockey');
        $options[] = JHtml::_('select.option', 0, JText::_('COM_HOCKEY_MATCHES_TYPE_FILTER_SPARRINGS'));
        
        for ($i = 1; $i < 10; $i++) {
            $options[] = JHTML::_('select.option', $i, $params->get('name' . $i));
        }

        return $options;
    }

}