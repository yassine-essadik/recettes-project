<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_emanager
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Controller for a single hotel
 *
 * @package     Joomla.Administrator
 * @subpackage  com_emanager
 * @since       1.6
 */
class EmanagerControllerSubcategorie extends JControllerForm
{
	
	public function __construct($config = array())
	{
		parent::__construct($config);
	}
	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		$user = JFactory::getUser();
		$allow = null;


		// In the absense of better information, revert to the component permissions.
		return parent::allowAdd($data);

	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;

			// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
		
	}

	/**
	 * Function that allows child controller access to model data after the data has been saved.
	 *
	 * @param   JModelLegacy  $model      The data model object.
	 * @param   array         $validData  The validated data.
	 *
	 * @return  void
	 * @since   3.1
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
	}
	
	public function changeLanguage()
	{
		$contextId  	 = JRequest::getInt('id');
		$session 	 = JFactory::getSession();
		$session->set('com_emanager.categorie.'.$contextId.'.lang', JRequest::getVar('Language'));
	
		$this->setRedirect('index.php?option=com_emanager&task=subcategorie.edit&id='.$contextId);
	}	
}
