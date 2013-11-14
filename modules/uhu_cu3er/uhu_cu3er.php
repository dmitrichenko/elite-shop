<?php

class uhu_cu3er extends Module
{
	function __construct()
	{
		$this->name = 'uhu_cu3er';
		$this->tab = 'front_office_features';
		$this->version = 0.9;

		parent::__construct(); // The parent construct is required for translations

		$this->page = basename(__FILE__, '.php');
		$this->displayName = $this->l('Block Flash Advertising cu3er by uhupage');
		$this->description = $this->l('Adds a block to display an flash advertising pictures with small picture');
	}

	function install()
	{
		if (!parent::install())
			return false;
		return $this->registerHook('top');
	}

	/**
	* Returns module content
	*
	* @param array $params Parameters
	* @return string Content
	*/
	function hookTop($params)
	{
		global $smarty;
		//$smarty->assign('page_name', $this->page_name);
		return $this->display(__FILE__, 'uhu_cu3er.tpl');
	}

}

?>