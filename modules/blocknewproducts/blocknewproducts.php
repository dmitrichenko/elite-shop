<?php

if (!defined('_PS_VERSION_'))
	exit;

class BlockNewProducts extends Module
{
	public function __construct()
	{
		$this->name = 'blocknewproducts';
		$this->tab = 'front_office_features';
		$this->version = 0.9;
		$this->author = 'PrestaShop';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('New products block');
		$this->description = $this->l('Displays a block featuring your store\'s newest products.');
	}

	public function install()
	{
			if (parent::install() == false || $this->registerHook('rightColumn') == false || $this->registerHook('header') == false || Configuration::updateValue('NEW_PRODUCTS_NBR', 5) == false)
					return false;
			return true;
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitBlockNewProducts'))
		{
			if (!($productNbr = Tools::getValue('productNbr')) || empty($productNbr))
				$output .= '<div class="alert error">'.$this->l('Please complete the "products to display" field.').'</div>';
			elseif ((int)($productNbr) == 0)
				$output .= '<div class="alert error">'.$this->l('Invalid number.').'</div>';
			else
			{
				Configuration::updateValue('PS_BLOCK_NEWPRODUCTS_DISPLAY', (int)(Tools::getValue('always_display')));
				Configuration::updateValue('NEW_PRODUCTS_NBR', (int)($productNbr));
				$output .= '<div class="conf confirm">'.$this->l('Settings updated').'</div>';
			}
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		$output = '
		<form action="'.Tools::safeOutput($_SERVER['REQUEST_URI']).'" method="post">
		<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<label>'.$this->l('Products to display.').'</label>
					<div class="margin-form">
						<input type="text" name="productNbr" value="'.(int)(Configuration::get('NEW_PRODUCTS_NBR')).'" />
						<p class="clear">'.$this->l('Define the number of products to be displayed in this block.').'</p>
					</div>
					<label>'.$this->l('Always display this block.').'</label>
					<div class="margin-form">
						<input type="radio" name="always_display" id="display_on" value="1" '.(Tools::getValue('always_display', Configuration::get('PS_BLOCK_NEWPRODUCTS_DISPLAY')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="display_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="always_display" id="display_off" value="0" '.(!Tools::getValue('always_display', Configuration::get('PS_BLOCK_NEWPRODUCTS_DISPLAY')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="display_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('Show the block even if no products are available.').'</p>
					</div>
					<center><input type="submit" name="submitBlockNewProducts" value="'.$this->l('Save').'" class="button" /></center>
				</fieldset>
			</form>';
		return $output;
	}

	public function hookRightColumn($params)
	{
        //getNewProducts($id_lang, $page_number = 0, $nb_products = 10, $count = false, $order_by = null, $order_way = null, Context $context = null)
        $newProducts = Product::getNewProducts((int)($params['cookie']->id_lang), 0, (int)(Configuration::get('NEW_PRODUCTS_NBR')), false, 'random'
        );
		if (!$newProducts && !Configuration::get('PS_BLOCK_NEWPRODUCTS_DISPLAY'))
			return;

		$this->smarty->assign(array(
			'new_products' => $newProducts,
			'mediumSize' => Image::getSize(ImageType::getFormatedName('medium')),
		));

		return $this->display(__FILE__, 'blocknewproducts.tpl');
	}

	public function hookLeftColumn($params)
	{
		return $this->hookRightColumn($params);
	}

	public function hookHeader($params)
	{
		$this->context->controller->addCSS(($this->_path).'blocknewproducts.css', 'all');
	}

}


