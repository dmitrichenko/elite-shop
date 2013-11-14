{*  @author PrestaLive <contact@prestalive.com>
*  @copyright  2011 PrestaLive
*  @version  1.0  
*  Main class,- manage etc…
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*}

{$products=$new_products}
{if isset($products)}
	<div id="slider1">
		<a class="buttons prev" href="#">left</a>
		<div class="viewport">
			<ul class="overview">
				{foreach from=$products item=product name=products}
					<li>
							<a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|escape:'htmlall':'UTF-8'}"><img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home')}" alt="{$product.legend|escape:'htmlall':'UTF-8'}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} /></a>
							<h3><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a></h3>
							{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}<span class="price" style="display: inline;">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span><br />{/if}
						
					</li>
				{/foreach}
			</ul>
		</div>
		<a class="buttons next" href="#">right</a>
	</div>
<script type="text/javascript">
		$(document).ready(function(){
			$('#slider1').tinycarousel({ pager: false, interval: true ,duration: {$duration}, axis: 'y',intervaltime: {$interval} });	
		});
</script>
{else}
	{if $display==0}
		<p>{l s='No new products at this time' mod='blocknewproducts'}</p>
	{/if}
{/if}