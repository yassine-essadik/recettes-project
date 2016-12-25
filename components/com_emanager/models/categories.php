<?php
defined('_JEXEC') or die;

class EmanagerModelCategories extends JModelList
{
	
	protected function getListQuery()
	{
		$user = JFactory::getUser();
		$doc = JFactory::getDocument();
		$language_filter = $this->setState('filter.language', $doc->language);

		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$query->select($this->getState('list.select', 'c.*'))
		->from($db->quoteName('#__ecategorie') . ' AS c');		
		
		//$query->join('LEFT', $db->quoteName('#__swcountry').' AS co ON co.id = a.pays');	

		$default_language = JComponentHelper::getParams('com_languages')->get('site');
		
		/*if(!empty($language_filter) && $language_filter != $default_language)
		{
			//$query->select("IFNULL(htr.name,a.name) as name, IFNULL(htr.alias,a.alias) as alias,IFNULL(htr.desc_long,a.desc_long) as desc_long");
			$query->join('INNER', $db->quoteName('#__swhotel_hotels_translations') . " AS htr ON htr.hotel_id = a.id AND htr.language = " .$db->quote($language_filter));
		}*/
		
		
		
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$search = $db->quote('%' . $db->escape($search, true) . '%');
			$query->where('(c.name LIKE ' . $search . ')');
		}
		
		$query->order($db->escape($this->getState('list.ordering', 'r.name')) . ' ' . $db->escape($this->getState('list.direction', 'ASC')));
		return $query;
		
		
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		$params = JComponentHelper::getParams('com_emanager');
		
		// Get list ordering default from the parameters
		$menuParams = new JRegistry;
		if ($menu = $app->getMenu()->getActive())
		{
			$menuParams->loadString($menu->params);
		}
		$mergedParams = clone $params;
		$mergedParams->merge($menuParams);
		
		// List state information
		$limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'uint');
		$this->setState('list.limit', $limit);
		
		$limitstart = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $limitstart);
				
		$search = $app->getUserStateFromRequest('filter.search','filter-search',"","string");		
		$this->setState('filter.search', $search);
		
		$this->setState('filter.language', JLanguageMultilang::isEnabled());
		
		// Load the parameters.
		$this->setState('params', $params);
	}	
	
	
	public function getItems()
	{
		$items = parent::getItems();
		
		if(!empty($items))
		{
			foreach ($items as $item)
			{
				$item->subcategories = $this->getSubcategories($categorie);
			}
			
		}
		return $items;
	}

	
	protected function getSubcategories($categorie)
	{
		
		
	}
}