<?php
/*  @author PrestaLive <contact@prestalive.com>
*  @copyright  2011 PrestaLive
*  @version  1.0  
*  Main class,- manage etc�
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/
if (!defined('_CAN_LOAD_FILES_'))
	exit;

class PlNewProducts extends Module
{
	private $_html = '';
    private $_postErrors = array();
    
	public function __construct()
	{
		$this->name = 'plnewproducts';
		$this->tab = 'front_office_features';
		$this->version = 1.0;
		$this->author = 'PrestaLive';

		parent::__construct();
		$this->displayName = $this->l('New products With Ajax slide show');
		$this->description = $this->l('Show a block with ajax slide for new products.');
	}

	public function install()
	{
		Configuration::updateValue('PL_NEW_PRODUCTS_DISPLAY', 1);
		Configuration::updateValue('PL_NEW_PRODUCTS_NBR', 10);
		Configuration::updateValue('PL_NEW_PRODUCTS_INTERVAL', 5000);
		Configuration::updateValue('PL_NEW_PRODUCTS_DURATION', 1000);
		if (parent::install() == false OR $this->registerHook('rightColumn') == false OR $this->registerHook('header') == false OR $this->registerHook('leftColumn') == false OR $this->registerHook('home') == false )
			return false;
		return true;
	}
	
	public function uninstall()
	{
		Configuration::deleteByName('PL_NEW_PRODUCTS_NBR');
		Configuration::deleteByName('PL_NEW_PRODUCTS_DISPLAY');
		Configuration::deleteByName('PL_NEW_PRODUCTS_HOOK');
		Configuration::deleteByName('PL_NEW_PRODUCTS_INTERVAL');
		Configuration::deleteByName('PL_NEW_PRODUCTS_DURATION');
		if (!parent::uninstall())
			return false;
		return true;
	}

	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submitPlNewProducts'))
		{
			$newhook = Tools::getValue('hook');
			if (!$productNbr = Tools::getValue('productNbr') OR empty($productNbr))
				$output .= '<div class="alert error">'.$this->l('Please fill in the "products displayed" field.').'</div>';
			elseif ((int)($productNbr) == 0)
				$output .= '<div class="alert error">'.$this->l('Invalid number.').'</div>';
			elseif ($newhook == '0')
				$output .= '<div class="alert error">'.$this->l('Please select Hook in the "Hook" field.').'</div>';
			else
			{
				Configuration::updateValue('PL_NEW_PRODUCTS_NBR', (int)($productNbr));
				Configuration::updateValue('PL_NEW_PRODUCTS_DISPLAY', (int)(Tools::getValue('always_display')));
				Configuration::updateValue('PL_NEW_PRODUCTS_HOOK', Tools::getValue('hook'));
				Configuration::updateValue('PL_NEW_PRODUCTS_INTERVAL', (int)Tools::getValue('speed'));
				Configuration::updateValue('PL_NEW_PRODUCTS_DURATION', (int)Tools::getValue('duration'));
				$output .= '<div class="conf confirm"><img src="../img/admin/ok.gif" alt="'.$this->l('Confirmation').'" />'.$this->l('Settings updated').'</div>';
			}
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
	   
		$output = '
		<form action="'.$_SERVER['REQUEST_URI'].'" method="post">
		<fieldset><legend><img src="'.$this->_path.'logo.gif" alt="" title="" />'.$this->l('Settings').'</legend>
				<label>'.$this->l('Products displayed').'</label>
					<div class="margin-form">
						<input type="text" name="productNbr" value="'.(int)(Configuration::get('PL_NEW_PRODUCTS_NBR')).'" />
						<p class="clear">'.$this->l('Set the number of products to be displayed in this block').'</p>
					</div>
					<label>'.$this->l('Always display block').'</label>
					<div class="margin-form">
						<input type="radio" name="always_display" id="display_on" value="1" '.(Tools::getValue('always_display', Configuration::get('PL_NEW_PRODUCTS_DISPLAY')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="display_on"> <img src="../img/admin/enabled.gif" alt="'.$this->l('Enabled').'" title="'.$this->l('Enabled').'" /></label>
						<input type="radio" name="always_display" id="display_off" value="0" '.(!Tools::getValue('always_display', Configuration::get('PL_NEW_PRODUCTS_DISPLAY')) ? 'checked="checked" ' : '').'/>
						<label class="t" for="display_off"> <img src="../img/admin/disabled.gif" alt="'.$this->l('Disabled').'" title="'.$this->l('Disabled').'" /></label>
						<p class="clear">'.$this->l('Show the block even if no products are available.').'</p>
					</div>
					
					<label>'.$this->l('Duration').'</label>
					<div class="margin-form">
						<input type="text" name="duration" value="'.(int)(Configuration::get('PL_NEW_PRODUCTS_DURATION')).'" />
						<p class="clear">'.$this->l('How fast must the animation move in milliseconds?').'</p>
					</div>
					
					<label>'.$this->l('Interval Time').'</label>
					<div class="margin-form">
						<input type="text" name="speed" value="'.(int)(Configuration::get('PL_NEW_PRODUCTS_INTERVAL')).'" />
						<p class="clear">'.$this->l('Interval time in milliseconds of slider').'</p>
					</div>
					
					  <label>Hook </label>
			    <div class="margin-form">
					<select name="hook">
						<option value="0">--- Select Hook ---</option>
					 <option value="left" ';
						if(Configuration::get('PL_NEW_PRODUCTS_HOOK')=='left') $output = $output.'selected="selected"';
												
						$output = $output.' >&nbsp;&nbsp;&nbsp;Left</option>
						<option value="right" ';
						if(Configuration::get('PL_NEW_PRODUCTS_HOOK')=='right') $output = $output.'selected="selected"';				
                        $output = $output.' >&nbsp;&nbsp;&nbsp;Right</option> 
                        <option value="home" ';
						if(Configuration::get('PL_NEW_PRODUCTS_HOOK')=='home') $output = $output.'selected="selected"';				
                        $output = $output.' >&nbsp;&nbsp;&nbsp;Home</option> 
						</select>
				</div>
					<center><input type="submit" name="submitPlNewProducts" value="'.$this->l('Save').'" class="button" /></center>
				</fieldset>
			</form>';
		return $output;
	}
    
	public function hookHeader($params)
	{
		global $smarty,$cookie;
        $smarty->assign('this_path', $this->_path);
        return $this->display(__FILE__, 'views/plnewproductsheader.tpl');
	}
	
	public function hookLeftColumn($params)
	{
		global $smarty,$cookie;
	    
		$newProductHook = Configuration::get('PL_NEW_PRODUCTS_HOOK');
		if($newProductHook != 'left'){
			return false;
		}
		$newProducts = Product::getNewProducts((int)($params['cookie']->id_lang), 0, (int)(Configuration::get('PL_NEW_PRODUCTS_NBR')));
		//$newProducts = Product::getNewProducts((int)($cookie->id_lang), 0, Configuration::get('PL_NEW_PRODUCTS_NBR'))
				
		if (!$newProducts AND !Configuration::get('PS_BLOCK_NEWPRODUCTS_DISPLAY'))
			return;
		$smarty->assign(array(
			'new_products' => $newProducts,
			'mediumSize' => Image::getSize('medium'),
			'interval' => Configuration::get('PL_NEW_PRODUCTS_INTERVAL'),
			'duration' => Configuration::get('PL_NEW_PRODUCTS_DURATION'),
			'display' => Configuration::get('PL_NEW_PRODUCTS_DISPLAY')
		));	
		
		return $this->display(__FILE__, 'views/plnewproductsright.tpl');
	}
	
	public function hookHome ($params)
	{
		global $smarty,$cookie;	
			
		$newProductHook = Configuration::get('PL_NEW_PRODUCTS_HOOK');
		if($newProductHook != 'home'){
			return false;
		}
		$newProducts = Product::getNewProducts((int)($params['cookie']->id_lang), 0, (int)(Configuration::get('PL_NEW_PRODUCTS_NBR')), NULL, 'random');
		//$newProducts = Product::getNewProducts((int)($cookie->id_lang), 0, Configuration::get('PL_NEW_PRODUCTS_NBR'));
				
		if (!$newProducts AND !Configuration::get('PS_BLOCK_NEWPRODUCTS_DISPLAY'))
			return;
		$smarty->assign(array(
			'new_products' => $newProducts,
			'mediumSize' => Image::getSize('medium'),
			'interval' => Configuration::get('PL_NEW_PRODUCTS_INTERVAL'),
			'duration' => Configuration::get('PL_NEW_PRODUCTS_DURATION'),
			'display' => Configuration::get('PL_NEW_PRODUCTS_DISPLAY')
		));	
		
		return $this->display(__FILE__, 'views/plnewproductshome.tpl');
	}
	
	public function hookRightColumn($params)
	{
		global $smarty,$cookie;
	    
		$newProductHook = Configuration::get('PL_NEW_PRODUCTS_HOOK');
		if($newProductHook != 'right'){
			return false;
		}
		$newProducts = Product::getNewProducts((int)($params['cookie']->id_lang), 0, (int)(Configuration::get('PL_NEW_PRODUCTS_NBR')));
		//$newProducts = Product::getNewProducts((int)($cookie->id_lang), 0, Configuration::get('PL_NEW_PRODUCTS_NBR'));
				
		if (!$newProducts AND !Configuration::get('PS_BLOCK_NEWPRODUCTS_DISPLAY'))
			return;
		$smarty->assign(array(
			'new_products' => $newProducts,
			'mediumSize' => Image::getSize('medium'),
			'interval' => Configuration::get('PL_NEW_PRODUCTS_INTERVAL'),
			'duration' => Configuration::get('PL_NEW_PRODUCTS_DURATION'),
			'display' => Configuration::get('PL_NEW_PRODUCTS_DISPLAY')
		));	
		
		return $this->display(__FILE__, 'views/plnewproductsright.tpl');
	}

}


