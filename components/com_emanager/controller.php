<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_emanager
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Newsfeeds Component Controller
 *
 * @package     Joomla.Site
 * @subpackage  com_emanager
 * @since       1.5
 */
class EmanagerController extends JControllerLegacy
{
	/**
	 * Method to show a emanager view
	 *
	 * @param   boolean			If true, the view output will be cached
	 * @param   array  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		return parent::display($cachable, $urlparams);
	}

}
