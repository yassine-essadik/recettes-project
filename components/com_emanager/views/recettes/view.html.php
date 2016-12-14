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
 * HTML View class for the Newsfeeds component
 *
 * @package     Joomla.Site
 * @subpackage  com_emanager
 * @since       1.0
 */
class EmanagerViewRecettes extends JViewLegacy
{
	protected $state;

	protected $items;

	protected $pagination;


	public function display($tpl = null)
	{

		$app		= JFactory::getApplication();
		$state		= $this->get('State');
		$items		= $this->get('Items');
		
		$params		= $app->getParams();
		$pagination = $this->get('Pagination');
		//var_dump($state);die;
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseWarning(500, implode("\n", $errors));
			return false;
		}

		if ($items === false)
		{
			JError::raiseError(404, JText::_('COM_EMANAGER_ERROR_LIST_NOT_FOUND'));
			return false;
		}

		//Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));
		$this->state = &$state;
		$this->items  = &$items;
		
		$this->pagination = &$pagination;
		
		$this->params = $this->state->get('params');
		
		$document = JFactory::getDocument();
		JHtml::_('bootstrap.tooltip');
		$document->addScript("media/com_emanager/js/emanager.js");
		
		//$document->addStylesheet("media/com_emanager/pricesWidget/prism.css");

		$this->_prepareDocument();
		
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;
		
		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();
		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('COM_EMANAGER_LIST_RECETTES'));
		}
		$title = $this->params->get('page_title', '');
		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
