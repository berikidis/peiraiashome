<?php
class ControllerExtensionAnalyticsBestpriceAnalytics extends Controller {
    public function index() {
		return "<!-- BestPrice 360 Analytics Start -->
		<script type='text/javascript'>
			(function (a, b, c, d, s) {a.__bp360 = c;a[c] = a[c] || function (){(a[c].q = a[c].q || []).push(arguments);};
			s = b.createElement('script'); s.async = true; s.src = d; (b.body || b.head).appendChild(s);})
			(window, document, 'bp', 'https://360.bestprice.gr/360.js');

			bp('connect', '" . $this->config->get('bestprice_analytics_code') . "');
			bp('native', true);
		</script>
		<!-- BestPrice 360 Analytics End -->
		";
	}
}
