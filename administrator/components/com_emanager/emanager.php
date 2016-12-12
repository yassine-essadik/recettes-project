<?php
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.controller');
 
$controller = JControllerLegacy::getInstance('Emanager');
 
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
$controller->redirect();