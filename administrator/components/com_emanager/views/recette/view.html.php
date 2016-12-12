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
 * View class for a list of items.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_emanager
 * @since       1.6
 */
class EmanagerViewRecette extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		// Initialise variables.
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		$this->lang = $this->get('lang');
		$this->lists['Languages'] = JHTML::_('select.genericlist', EmanagerHelper::getlanguages(), 'Language', 'onchange="submitbutton(\'recette.changeLanguage\')"', 'value', 'text', $this->lang);
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		
		$this->addToolbar();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);

		$canDo		= EmanagerHelper::getActions();
		
		JToolbarHelper::title(JText::_('COM_EMANAGER_MANAGER_RECETTE'), 'emanager.png');

		// Build the actions for new and existing records.
		if ($isNew)
		{
			// For new records, check the create permission.
			if ($isNew && ($canDo->get('core.create')))
			{
				JToolbarHelper::apply('recette.apply');
				JToolbarHelper::save('recette.save');
				JToolbarHelper::save2new('recette.save2new');
			}

			JToolbarHelper::cancel('recette.cancel');
		}
		else
		{
			// Can't save the record if it's checked out.
			/*if (!$checkedOut)
			{*/
				// Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
				if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					JToolbarHelper::apply('recette.apply');
					JToolbarHelper::save('recette.save');

					// We can save this record, but check the create permission to see if we can return to make a new one.
					if ($canDo->get('core.create'))
					{
						JToolbarHelper::save2new('recette.save2new');
					}
				}
			//}

			// If checked out, we can still save
			if ($canDo->get('core.create'))
			{
				JToolbarHelper::save2copy('recette.save2copy');
			}

			JToolbarHelper::cancel('recette.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();
		JToolbarHelper::help('JHELP_COMPONENTS_EMANAGER_RECETTE_EDIT');
	}
}
