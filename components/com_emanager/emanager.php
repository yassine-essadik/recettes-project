<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_newsfeeds
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

//require_once JPATH_COMPONENT.'/helpers/route.php';

$controller	= JControllerLegacy::getInstance('Emanager');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
