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

class BlockCategoriesTop extends Module
{
	public function __construct()
	{
		$this->name = 'blockcategoriestop';
		$this->tab = 'front_office_features';
		$this->version = '1.0';

		parent::__construct();

		$this->displayName = $this->l('Categories block (top)');
		$this->description = '';
	}

	public function install()
	{
		return (parent::install() AND $this->registerHook('top'));
	}
	
	public function hookTop($params)
	{
		global $smarty, $cookie, $link;

		$id_customer = (int)$params['cookie']->id_customer;
		$id_group = $id_customer ? Customer::getDefaultGroupId($id_customer) : _PS_DEFAULT_CUSTOMER_GROUP_;
		$id_lang = (int)$params['cookie']->id_lang;

		$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->ExecuteS('
		SELECT c.*, cl.*
		FROM `'._DB_PREFIX_.'category` c 
		LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (c.`id_category` = cl.`id_category` AND `id_lang` = '.$id_lang.')
		LEFT JOIN `'._DB_PREFIX_.'category_group` cg ON (cg.`id_category` = c.`id_category`)
		WHERE level_depth = 1
		AND c.`active` = 1
		AND cg.`id_group` = '.$id_group.'
		ORDER BY c.`position` ASC');
	
		foreach ($result as &$row)
			$row['link'] = $link->getCategoryLink($row['id_category'], $row['link_rewrite'], $cookie->id_lang);
		
		$smarty->assign('blockcategoriestop_categories', $result);
		return $this->display(__FILE__, 'blockcategoriestop.tpl');
	}
}