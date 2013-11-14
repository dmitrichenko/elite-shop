<div id="menu">
	<ul class="v2-blockcategoriestop">
		<li class="first_item" id="m1">
			<a href="{$base_dir}">{l s='Home' mod='blockcategoriestop'}</a>
		</li>
		<li id="m2" >
			<a href="{$link->getPageLink('new-products.php')}">{l s='New products' mod='blockcategoriestop'}</a>
		</li>
		<li id="m3">
			<a href="{$link->getPageLink('prices-drop.php')}">{l s='Specials' mod='blockcategoriestop'}</a>
		</li>
		<li id="m4">
			<a href="{$link->getPageLink('best-sales.php')}">{l s='Top sellers' mod='blockcategoriestop'}</a>
		</li>
		<li id="m5">
			<a href="{$link->getPageLink('stores.php')}">{l s='Our stores' mod='blockcategoriestop'}</a>
		</li>
		<li id="m6">
			<a href="{$link->getPageLink('contact-form.php', true)}">{l s='Contact us' mod='blockcategoriestop'}</a>
		</li>
	{*foreach from=$blockcategoriestop_categories item=blockcategoriestop_category}
		<li>
			<a href="{$blockcategoriestop_category.link}">
				<span>{$blockcategoriestop_category.name}</span>
			</a>
		</li>
	{/foreach*}
	<ul>
</div>