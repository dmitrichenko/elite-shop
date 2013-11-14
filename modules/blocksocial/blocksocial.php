<?php

if (!defined('_CAN_LOAD_FILES_'))
	exit;
	
class blocksocial extends Module
{
	public function __construct()
	{
		$this->name = 'blocksocial';
		$this->tab = 'front_office_features';
		$this->version = '1.0';

		parent::__construct();

		$this->displayName = $this->l('Social networking block');
		$this->description = $this->l('Allows you to add information about your brand\'s social networking sites.');
	}
	
	public function install()
	{
		return (
            parent::install() AND
            Configuration::updateValue('blocksocial_vkontakte', '') &&
            Configuration::updateValue('blocksocial_facebook', '') &&
            Configuration::updateValue('blocksocial_twitter', '') &&
            Configuration::updateValue('blocksocial_rss', '') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayFooter')
        );
	}
	
	public function uninstall()
	{
		//Delete configuration			
		return (
            Configuration::deleteByName('blocksocial_vkontakte') AND
            Configuration::deleteByName('blocksocial_facebook') AND
            Configuration::deleteByName('blocksocial_twitter') AND
            Configuration::deleteByName('blocksocial_rss') AND
            parent::uninstall()
        );
	}
	
	public function getContent()
	{
		// If we try to update the settings
		$output = '';
		if (isset($_POST['submitModule']))
		{	
			Configuration::updateValue('blocksocial_vkontakte', (($_POST['vkontakte_url'] != '') ? $_POST['vkontakte_url']: ''));
			Configuration::updateValue('blocksocial_facebook', (($_POST['facebook_url'] != '') ? $_POST['facebook_url']: ''));
			Configuration::updateValue('blocksocial_twitter', (($_POST['twitter_url'] != '') ? $_POST['twitter_url']: ''));		
			Configuration::updateValue('blocksocial_rss', (($_POST['rss_url'] != '') ? $_POST['rss_url']: ''));				
			$this->_clearCache('blocksocial.tpl');
			$output = '<div class="conf confirm">'.$this->l('Configuration updated').'</div>';
		}
		
		return '
		<h2>'.$this->displayName.'</h2>
		'.$output.'
		<form action="'.Tools::htmlentitiesutf8($_SERVER['REQUEST_URI']).'" method="post">
			<fieldset class="width2">				
				<label for="vkontakte_url">'.$this->l('Vkontakte URL: ').'</label>
				<input type="text" id="vkontakte_url" name="vkontakte_url" value="'.Tools::safeOutput((Configuration::get('blocksocial_vkontakte') != "") ? Configuration::get('blocksocial_vkontakte') : "").'" />
				<div class="clear">&nbsp;</div>		

				<label for="facebook_url">'.$this->l('Facebook URL: ').'</label>
				<input type="text" id="facebook_url" name="facebook_url" value="'.Tools::safeOutput((Configuration::get('blocksocial_facebook') != "") ? Configuration::get('blocksocial_facebook') : "").'" />
				<div class="clear">&nbsp;</div>		

				<label for="twitter_url">'.$this->l('Twitter URL: ').'</label>
				<input type="text" id="twitter_url" name="twitter_url" value="'.Tools::safeOutput((Configuration::get('blocksocial_twitter') != "") ? Configuration::get('blocksocial_twitter') : "").'" />
				<div class="clear">&nbsp;</div>		

				<label for="rss_url">'.$this->l('RSS URL: ').'</label>
				<input type="text" id="rss_url" name="rss_url" value="'.Tools::safeOutput((Configuration::get('blocksocial_rss') != "") ? Configuration::get('blocksocial_rss') : "").'" />
				<div class="clear">&nbsp;</div>						

				<br /><center><input type="submit" name="submitModule" value="'.$this->l('Update settings').'" class="button" /></center>
			</fieldset>
		</form>';
	}
	
	public function hookDisplayHeader()
	{
		$this->context->controller->addCSS(($this->_path).'blocksocial.css', 'all');
	}
		
	public function hookDisplayFooter()
	{
		if (!$this->isCached('blocksocial.tpl', $this->getCacheId()))
			$this->smarty->assign(array(
				'vkontakte_url' => Configuration::get('blocksocial_vkontakte'),
				'facebook_url' => Configuration::get('blocksocial_facebook'),
				'twitter_url' => Configuration::get('blocksocial_twitter'),
				'rss_url' => Configuration::get('blocksocial_rss')
			));

		return $this->display(__FILE__, 'blocksocial.tpl', $this->getCacheId());
	}
}
?>
