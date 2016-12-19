<?php

defined('_JEXEC') or die;

class EmanagerControllerSubcategories extends JControllerAdmin
{
	public function __construct($config = array())
	{
		parent::__construct($config);

	}
	public function getModel($name = 'subcategorie', $prefix = 'EmanagerModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}
