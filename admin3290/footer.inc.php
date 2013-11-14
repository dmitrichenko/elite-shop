<?php
/*
* 2007-2013 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

echo '			</div>
			</div>
			'.Hook::exec('displayBackOfficeFooter').'
			<div id="footer">
				<div style="float:left;margin-left:10px;padding-top:6px">
					<span style="font-size:10px">'.translate('Load time:').' '.number_format(microtime(true) - $timerStart, 3, '.', '').'s</span>
				</div>
				<div style="float:right;height:40px;margin-right:10px;line-height:38px;vertical-align:middle">';
if (strtoupper(Context::getContext()->language->iso_code) == 'FR') echo '<span style="color: #812143; font-weight: bold;">Questions / Renseignements / Formations :</span> <strong>+33 (0)1.40.18.30.04</strong> de 09h &agrave; 18h ';

echo '
				</div>
			</div>
		</div>
	</div>';

// FrontController::disableParentCalls();
// $fc = new FrontController();
// $fc->displayFooter();

echo '
	</body>
</html>';

