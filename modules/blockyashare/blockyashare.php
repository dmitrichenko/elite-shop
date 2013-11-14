<?php

if (!defined('_CAN_LOAD_FILES_'))
	exit;
	
class blockyashare extends Module
{
	public function __construct()
	{
		$this->name = 'blockyashare';
		$this->tab = 'front_office_features';
		$this->version = '1.0';

		parent::__construct();

		$this->displayName = $this->l('Yandex share block');
		$this->description = $this->l('Allows you to add information about your brand\'s social networking sites.');
	}
	
	public function install()
	{
		return (
            parent::install() AND $this->registerHook('extraLeft')
            AND $this->registerHook('displayHeader')
            //AND $this->registerHook('displayFooter')
        );
	}
	
	public function uninstall()
	{
		//Delete configuration			
		return (parent::uninstall());
	}
	
	public function getContent()
	{
		// If we try to update the settings
		$output = '';
		if (isset($_POST['submitModule']))
		{	
			$this->_clearCache('blockyashare.tpl');
			$output = '<div class="conf confirm">'.$this->l('Configuration updated').'</div>';
		}
		return $output;
	}

    public function hookExtraLeft($params)
    {
        if (!$this->isCached('blockyashare.tpl', $this->getCacheId()))
            return $this->display(__FILE__, 'blockyashare.tpl', $this->getCacheId());
    }
	public function hookDisplayHeader()
	{
		//$this->context->controller->addCSS(($this->_path).'blockyashare.css', 'all');
		$this->context->controller->addJS('http://yandex.st/share/share.js');
	}
		
	public function hookDisplayFooter()
	{
		if (!$this->isCached('blockyashare.tpl', $this->getCacheId()))
		return $this->display(__FILE__, 'blockyashare.tpl', $this->getCacheId());
	}
}
?>
