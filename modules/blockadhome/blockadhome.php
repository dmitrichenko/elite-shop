<?php
/*
* 2007-2010 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author Prestashop SA <contact@prestashop.com>
*  @copyright  2007-2010 Prestashop SA
*  @version  Release: $Revision: 1.4 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registred Trademark & Property of PrestaShop SA
*/

if (!defined('_CAN_LOAD_FILES_'))
	exit;

class BlockAdHome extends Module
{
	protected $maxImageSize = 307200;
	
	public function __construct()
	{
		$this->name = 'blockadhome';
		$this->tab = 'front_office_features';
		$this->version = 1.0;

		parent::__construct();
		
		$this->displayName = $this->l('Home advertising');
		$this->description = '';
	}
	
	public function install()
	{
		if (!Configuration::get('BAH_AD_HEIGHT'))
			Configuration::updateValue('BAH_AD_HEIGHT', 116);
		if (!Configuration::get('BAH_AD_WIDTH'))
			Configuration::updateValue('BAH_AD_WIDTH', 924);
		if (!Configuration::get('BAH_AD'))
			Configuration::updateValue('BAH_AD', 'v2-defaultad.jpg');
		return (parent::install() AND $this->registerHook('top'));
	}

	public function getContent()
	{
		if (Tools::isSubmit('submitUpdate'))
		{
			if (isset($_FILES['BAH_AD']) AND isset($_FILES['BAH_AD']['tmp_name']) AND !empty($_FILES['BAH_AD']['tmp_name']))
				if (checkImage($_FILES['BAH_AD'], $this->maxImageSize) == false)
					if (move_uploaded_file($_FILES['BAH_AD']['tmp_name'], dirname(__FILE__).'/'.$_FILES['BAH_AD']['name']))
						Configuration::updateValue('BAH_AD', $_FILES['BAH_AD']['name']);
			if (Configuration::get('BAH_AD') AND file_exists(dirname(__FILE__).'/'.Configuration::get('BAH_AD')))
			{
				list($width, $height, $type, $attr) = getimagesize(dirname(__FILE__).'/'.Configuration::get('BAH_AD'));
				Configuration::updateValue('BAH_AD_WIDTH', (int)round($width));
				Configuration::updateValue('BAH_AD_HEIGHT', (int)round($height));
			}
			echo $this->displayConfirmation($this->l('Images updated successfully'));
		}
	
		$html = '
		<form method="post" action="'.htmlentities($_SERVER['REQUEST_URI']).'" enctype="multipart/form-data">
		<fieldset><legend>'.$this->displayName.'</legend>
			<label>'.$this->l('Homepage logo').'</label>
			<div class="margin-form">';
			if (Configuration::get('BAH_AD') AND file_exists(dirname(__FILE__).'/'.Configuration::get('BAH_AD')))
				$html .= '<div id="image" >
					<img src="'.$this->_path.Configuration::get('BAH_AD').'?t='.time().'" />
					<p align="center">'.$this->l('Filesize').' '.(filesize(dirname(__FILE__).'/'.Configuration::get('BAH_AD')) / 1000).'kb</p>
					<a href="'.htmlentities($_SERVER['REQUEST_URI']).'&deleteHomepageLogo">
						<img src="../img/admin/delete.gif" alt="'.$this->l('Delete').'" /> '.$this->l('Delete').'
					</a>
				</div>';
			$html .= '<input type="file" name="BAH_AD" />
				<p style="clear: both">'.$this->l('Will appear on the top left of your shop').'</p>
			</div>
			<div class="clear"></div>
			<div class="margin-form clear"><input type="submit" name="submitUpdate" value="'.$this->l('Update images').'" class="button" /></div>
		</fieldset>
		</form>';
		
		return $html;
	}
	
	public function hooktop($params)
	{
		global $smarty;
		
		$smarty->assign(array(
			'BAH_AD' => __PS_BASE_URI__.'modules/'.$this->name.'/'.Configuration::get('BAH_AD'),
			'BAH_AD_WIDTH' => (int)Configuration::get('BAH_AD_WIDTH'),
			'BAH_AD_HEIGHT' => (int)Configuration::get('BAH_AD_HEIGHT')
		));
		return $this->display(__FILE__, 'blockadhome.tpl');
	}
}