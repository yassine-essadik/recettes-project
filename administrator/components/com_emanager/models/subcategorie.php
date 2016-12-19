<?php

defined('_JEXEC') or die;
JLoader::register('EmanagerHelper', JPATH_ADMINISTRATOR . '/components/com_emanager/helpers/emanager.php');

class EmanagerModelSubcategorie extends JModelAdmin
{
	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    3.2
	 */
	public $typeAlias = 'com_emanager.subcategorie';
	
	/**
	 * @var        string    The prefix to use with controller messages.
	 * @since   1.6
	 */
	protected $text_prefix = 'COM_EMANAGER';
	
	/**
	 * Returns a Table object, always creating it.
	 *
	 * @param   type      The table type to instantiate
	 * @param   string    A prefix for the table class name. Optional.
	 * @param   array     Configuration array for model. Optional.
	 * @return  JTable    A database object
	 */
	public function getTable($type = 'Subcategorie', $prefix = 'EmanagerTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param   array      $data        Data for the form.
	 * @param   boolean    $loadData    True if the form is to load its own data (default case), false if not.
	 * @return  JForm    A JForm object on success, false on failure
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_emanager.subcategorie', 'subcategorie', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		
		$form_lang = $form->getData()->get('language');
		if (empty($form_lang))
		{
			$language = JFactory::getLanguage();
			$form->setValue('language','',$language->getTag());
		}
		
		$lang = $this->getLang();
		$form_lang = $form->getData()->get('language');
		$form_id = $form->getData()->get('id');
		
		if ($lang != $form_lang)
		{
		
			$translations = EmanagerHelper::getTranslations('esubcategorie', $form_id, $lang);
		
			if ($translations)
			foreach ($translations as $field => $value)
			{
				if ($form->getData()->get($field))
					$form->setValue($field,'',$value);
			}
		}
		
		// Modify the form based on access controls.
		if (!$this->canEditState((object) $data))
		{
			// Disable fields for display.
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('published', 'disabled', 'true');
	
			// Disable fields while saving.
			// The controller has already verified this is a record you can edit.
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('published', 'filter', 'unset');
		}
	
		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_emanager.edit.subcategorie.data', array());
		
		if (empty($data))
		{
			$data = $this->getItem();
		}
		
		$this->preprocessData('com_emanager.subcategorie', $data);

		return $data;
	}	
	
	/**
	 * Method to save the form data.
	 *
	 * @param   array  The form data.
	 *
	 * @return  boolean  True on success.
	 * @since    3.0
	 */
	public function save($data)
	{
		$this->saveTranslation($data, $this->getLang());
		if (parent::save($data))
		{
			return true;
		}
	
		return false;
	}	
	/**
	 * Method to get a single record.
	 *
	 * @param   integer    The id of the primary key.
	 *
	 * @return  mixed  Object on success, false on failure.
	 * @since   1.6
	 */
	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);
		return $item;
	}

	protected function preprocessForm(JForm $form, $data, $group = 'content')
	{
		parent::preprocessForm($form, $data, $group);
	}	
	
	function saveTranslation(&$context, $lang)
	{
		$default_language = JComponentHelper::getParams('com_languages')->get('administrator');
		if ($default_language == $lang) return true;
	
		$fields 	  = array('name');
		$translations = EmanagerHelper::getTranslations('esubcategorie', $context['id'], $lang, 'id');
		$query   = array();
		$query[] = "subcategorie_id = ".$context['id'];
		$query[] = "language = '".$lang."'";
		foreach ($fields as $field)
		{
			$field_query = $context[$field];
			$query[] = $field."='".$this->_db->escape($field_query)."'";
	
			unset($context[$field]);
		}
		if (!isset($translations[$field]))
		{
			$this->_db->setQuery("INSERT INTO #__swhotel_subcategories_translations SET ".implode(", ", $query));
			$this->_db->execute();
		}
		else
		{
			$this->_db->setQuery("UPDATE #__swhotel_subcategories_translations SET ".implode(", ", $query)." WHERE id='".(int) $translations["translation_id"]."'");
			$this->_db->execute();
		}
		unset($context[$field]);
	}
	function getAsset()
	{
		$formId = JRequest::getInt('id');
	
		if (empty($this->_form))
		{
			$this->_form = JTable::getInstance('Subcategorie', 'EmanagerTable');
	
			$this->_form->load($formId);
	
			if (empty($this->_form->language))
			{
				$language = JFactory::getLanguage();
				$this->_form->language = $language->getTag();
			}
	
			$lang = $this->getLang();
	
			if ($lang != $this->_form->language)
			{
	
				$translations = EmanagerHelper::getTranslations('esubcategorie', $this->_form->id, $lang);
	
				if ($translations)
				foreach ($translations as $field => $value)
				{
					if (isset($this->_form->$field))
						$this->_form->$field = $value;
				}
			}
		}
		return $this->_form;
	}
	
	function getLang()
	{
		$session = JFactory::getSession();
		$lang 	 = JFactory::getLanguage();
		$default_language = JComponentHelper::getParams('com_languages')->get('administrator');
		if (empty($this->_form))
			$this->getAsset();
	
		return $session->get('com_emanager.subcategorie.'.$this->_form->id.'.lang', $default_language);
	
	}	
}
