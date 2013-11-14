
<div id="social_block">
	<h4 class="title_block">{l s='Follow us' mod='blocksocial'}</h4>
	<ul>
		{if $vkontakte_url != ''}<li class="vkontakte"><a href="{$vkontakte_url|escape:html:'UTF-8'}" target="_blank">{l s='vKontakte' mod='blocksocial'}</a></li>{/if}
		{if $facebook_url != ''}<li class="facebook"><a href="{$facebook_url|escape:html:'UTF-8'}" target="_blank">{l s='Facebook' mod='blocksocial'}</a></li>{/if}
		{if $twitter_url != ''}<li class="twitter"><a href="{$twitter_url|escape:html:'UTF-8'}" target="_blank">{l s='Twitter' mod='blocksocial'}</a></li>{/if}
		{if $rss_url != ''}<li class="rss"><a href="{$rss_url|escape:html:'UTF-8'}" target="_blank">{l s='RSS' mod='blocksocial'}</a></li>{/if}
	</ul>
</div>
