<?php

defined('_JEXEC') or die;

class EmanagerHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string	$vName	The name of the active view.
	 *
	 * @return  void
	 * @since   1.6
	 */
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_EMANAGER_SUBMENU_RECETTES'),
			'index.php?option=com_emanager&view=recettes',
			$vName == 'recettes'
		);
	}

	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;
		$assetName = 'com_emanager';
		$level = 'component';
		$actions = JAccess::getActions($assetName, $level);
		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}

	public static function getTranslations($reference, $referenceId, $lang, $select = 'valeur')
	{
		$db = JFactory::getDBO();
		$db->setQuery("SELECT `language` FROM #__".$reference." WHERE `id`='".(int) $referenceId."'");
		$current_lang = $db->loadResult();
		if ($current_lang == $lang)
			return false;
	
			switch ($reference)
			{
				case 'swhotel':
					$db->setQuery("SELECT id as translation_id, name, alias, desc_proximite, desc_short, desc_long, acces, desc_long_chaine, acces_chaine,
						 desc_short_chaine, restaurant_name_chaine, restaurant_desc_chaine, metadesc_chaine, tripadvisor, restaurant_name, restaurant_desc, metadesc, metakey, metadata FROM #__swhotel_hotels_translations WHERE `hotel_id`='".(int) $referenceId."' AND `language`='".$db->escape($lang)."'");
					$results = $db->loadObject();
					$return = array();
					if(!empty($results))
					{
						foreach ($results as $key=>$result)
						{
							if ($key == "metadata" && !empty($result))
							{
								$result = json_decode($result);
									
							}
							if ($key == "desc_long" && empty($result))
								$result = $results->desc_long_chaine;
	
								if ($key == "acces" && empty($result))
									$result = $results->acces_chaine;
	
									if ($key == "desc_short" && empty($result))
										$result = $results->desc_short_chaine;
	
										if ($key == "restaurant_name" && empty($result))
											$result = $results->restaurant_name_chaine;
	
											if ($key == "restaurant_desc" && empty($result))
												$result = $results->restaurant_desc_chaine;
	
												if ($key == "metadesc" && empty($result))
													$result = $results->metadesc_chaine;
	
													$return[$key] = isset($result) ? $result : false;
						}
							
						if(empty($return["metadata"]->metadesc) && !empty($return["metadesc"])) :
						$return["metadata"]->metadesc = $return["metadesc"];
						endif;
	
						if(empty($return["metadata"]->metakey) && !empty($return["metakey"])) :
						$return["metadata"]->metakey = $return["metakey"];
						endif;
					}
					return $return;
					break;
				case 'swservice':
					$db->setQuery("SELECT id as translation_id, name, alias FROM #__swhotel_services_translations WHERE `service_id`='".(int) $referenceId."' AND `language`='".$db->escape($lang)."'");
					$results = $db->loadObject();
	
					$return = array();
					if(!empty($results))
					{
						foreach ($results as $key=>$result)
						{
							$return[$key] = isset($result) ? $result : false;
						}
					}
					return $return;
					break;
	
				case 'swamenitie':
					$db->setQuery("SELECT id as translation_id, name, alias FROM #__swhotel_amenities_translations WHERE `amenitie_id`='".(int) $referenceId."' AND `language`='".$db->escape($lang)."'");
					$results = $db->loadObject();
	
					$return = array();
					if(!empty($results))
					{
						foreach ($results as $key=>$result)
						{
							$return[$key] = isset($result) ? $result : false;
						}
					}
					return $return;
					break;
	
				case 'swlocalisation':
					$db->setQuery("SELECT id as translation_id, name, alias FROM #__swhotel_localisations_translations WHERE `localisation_id`='".(int) $referenceId."' AND `language`='".$db->escape($lang)."'");
					$results = $db->loadObject();
	
					$return = array();
					if(!empty($results))
					{
						foreach ($results as $key=>$result)
						{
							$return[$key] = isset($result) ? $result : false;
						}
					}
					return $return;
					break;
				case 'swactivite':
					$db->setQuery("SELECT id as translation_id, name, alias, articletext FROM #__swhotel_activites_translations WHERE `activite_id`='".(int) $referenceId."' AND `language`='".$db->escape($lang)."'");
					$results = $db->loadObject();
						
					$return = array();
					if(!empty($results))
					{
						foreach ($results as $key=>$result)
						{
							$return[$key] = isset($result) ? $result : false;
						}
					}
					return $return;
					break;
			}
	
			return false;
	}
	
	public static function getLanguages()
	{
		$lang 	   = JFactory::getLanguage();
		$languages = $lang->getKnownLanguages(JPATH_SITE);
	
		$return = array();
		$return[] = JHTML::_('select.option', "", JText::_("JOPTION_SELECT_LANGUAGE"));
		foreach ($languages as $tag => $properties)
			$return[] = JHTML::_('select.option', $tag, $properties['name']);
	
			return $return;
	}
	
	
}
