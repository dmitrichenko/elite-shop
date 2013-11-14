{*
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
*}

<!-- zzs Block user information module HEADER -->

{if $logged}
	<div class="v2-header_links floatr">
	<a id ="your_account" href="{$link->getPageLink('my-account.php', true)}" title="{l s='Your Account' mod='blockuserinfo'}">{l s='Your Account' mod='blockuserinfo'}</a>
		<a href="{$link->getPageLink('index.php')}?mylogout" title="{l s='Log me out' mod='blockuserinfo'}">({l s='Log out' mod='blockuserinfo'})</a>
	</div>
{else}
	<div class="floatr">
		<a id ="your_account" href="{$link->getPageLink('my-account.php', true)}" title="{l s='Your Account' mod='blockuserinfo'}">{l s='Your Account' mod='blockuserinfo'}</a>
		<a href="{$link->getPageLink('my-account.php', true)}" class="v2-signin">
			({l s='Sign in' mod='blockuserinfo'})
		</a>
	</div>
{/if}
<div class="flatclear">&nbsp;</div>
<!-- /Block user information module HEADER -->
