
		{if !$content_only}
				</div>

<!-- Right -->
				<!--div id="right_column" class="column grid_2 omega">
					{$HOOK_RIGHT_COLUMN}
				</div-->
			</div>

<!-- Footer -->
			<div id="footer" class="grid_9 alpha omega clearfix">
				{$HOOK_FOOTER}
				{if $PS_ALLOW_MOBILE_DEVICE}
					<p class="center clearBoth"><a href="{$link->getPageLink('index', true)}?mobile_theme_ok">{l s='Browse the mobile site'}</a></p>
				{/if}
			</div>
		</div>
	{/if}
	</body>
        {literal}
            <!-- Yandex.Metrika counter -->
            <script type="text/javascript">
                (function (d, w, c) {
                    (w[c] = w[c] || []).push(function() {
                        try {
                            w.yaCounter17065300 = new Ya.Metrika({id:17065300,
                                webvisor:true,
                                clickmap:true,
                                trackLinks:true,
                                accurateTrackBounce:true});
                        } catch(e) { }
                    });

                    var n = d.getElementsByTagName("script")[0],
                            s = d.createElement("script"),
                            f = function () { n.parentNode.insertBefore(s, n); };
                    s.type = "text/javascript";
                    s.async = true;
                    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

                    if (w.opera == "[object Opera]") {
                        d.addEventListener("DOMContentLoaded", f, false);
                    } else { f(); }
                })(document, window, "yandex_metrika_callbacks");
            </script>
            <noscript><div><img src="//mc.yandex.ru/watch/17065300" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
            <!-- /Yandex.Metrika counter -->
        {/literal}
</html>
