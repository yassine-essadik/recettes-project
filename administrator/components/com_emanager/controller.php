<?php
defined('_JEXEC') or die;
require_once JPATH_COMPONENT.'/helpers/emanager.php';
 
class EmanagerController extends JControllerLegacy
{
        function display($cachable = false, $urlparams = false) 
        {
        		
                // set default view if not set
                $input = JFactory::getApplication()->input;
                $input->set('view', $input->getCmd('view', 'Recettes'));
 
                // call parent behavior
                parent::display($cachable);
        }       
}