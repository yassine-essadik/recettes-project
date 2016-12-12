<?php

defined('_JEXEC') or die;

class EmanagerViewRecettes extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		EmanagerHelper::addSubmenu('recettes');

		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		foreach ($this->items as &$item)
		{
			$item->order_up = true;
			$item->order_dn = true;
		}
		
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		$state	= $this->get('State');
		$canDo	= EmanagerHelper::getActions();
		$user	= JFactory::getUser();
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		
		JToolbarHelper::title(JText::_('COM_EMANAGER_MANAGER_RECETTES'));

		if ($canDo->get('core.create'))
		{
			JToolbarHelper::addNew('recette.add');
		}
		if ($canDo->get('core.edit'))
		{
			JToolbarHelper::editList('recette.edit');
		}
		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('recettes.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('recettes.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}
		if ($state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('', 'recettes.delete', 'JTOOLBAR_EMPTY_TRASH');
		} elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('recettes.trash');
		}
		
		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_emanager');
		}
		
		JHtmlSidebar::setAction('index.php?option=com_emanager');
		
		JHtmlSidebar::addFilter(
		JText::_('JOPTION_SELECT_PUBLISHED'),
		'filter_published',
		JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);

	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.id' => JText::_('JGRID_HEADING_ID'),
			'a.name' => JText::_('COM_EMANAGER_HEADING_NAME'),
			'a.published' => JText::_('JSTATUS'),
			'a.modified' => JText::_('COM_EMANAGER_GLOBAL_MODIFIED'),
			'a.created' => JText::_('COM_EMANAGER_GLOBAL_CREATED')
		);
	}
}
