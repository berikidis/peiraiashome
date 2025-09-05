<?php
class ControllerCheckoutSuccess extends Controller {
	public function index() {

        $data['bp_event'] = '';

        if (isset($this->session->data['order_id'])) {
            $bp = false;

            if ($this->config->get('bestprice_analytics_status')) {
                $bp = true;
            } else if ($this->config->get('config_bestprice_analytics_status')) {
                $bp = true;
            } else if ($this->config->get('config_bestprice_analytics')) {
                $bestprice_analytics = $this->config->get('config_bestprice_analytics');
                if (!empty($bestprice_analytics)) {
                    $bp = true;
                }
            }

            if ($bp) {
                $this->load->model('checkout/order');
                $event_info = $this->model_checkout_order->getBA($this->session->data['order_id']);

                if ($event_info) {
					$data['bp_event'] .= "<!-- BestPrice 360 Analytics Order Products Script Start -->"."\n";
                    $data['bp_event'] .= "<script>" . "\n";
					
					$data['bp_event'] .= "bp('addOrder', {
						'orderId': '" . $event_info['orderId'] . "',         // Transaction ID. Required
						'revenue': '" . $event_info['revenue'] . "',           // Grand Total
						'shipping': '" . $event_info['shipping'] . "', // Shipping
						'tax': '" . $event_info['tax'] . "'           // Tax
					});" . "\n";
					
					if (isset($event_info['items']) && is_array($event_info['items'])) {
						foreach ($event_info['items'] as $item) {
						
							$data['bp_event'] .= "bp('addProduct', {";
							$data['bp_event'] .= "'orderId': '" . $event_info['orderId'] . "',";
							$data['bp_event'] .= "'productId': '" . htmlspecialchars($item['productId'], ENT_QUOTES) . "',";
							$data['bp_event'] .= "'title': '" . htmlspecialchars($item['title'], ENT_QUOTES) . "',";
							$data['bp_event'] .= "'price': '" . $item['price'] . "',";
							$data['bp_event'] .= "'quantity': '" . $item['quantity'] . "'";
							$data['bp_event'] .= "});" ."\n";
						}
		
                    }
					
                    $data['bp_event'] .= "</script>" . "\n";
					$data['bp_event'] .= "<!-- BestPrice 360 Analytics Order Products Script End -->";
                }
            }
        }
      
		$this->load->language('checkout/success');

		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();

			// Add to activity log
			if ($this->config->get('config_customer_activity')) {
				$this->load->model('account/activity');

				if ($this->customer->isLogged()) {
					$activity_data = array(
						'customer_id' => $this->customer->getId(),
						'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName(),
						'order_id'    => $this->session->data['order_id']
					);

					$this->model_account_activity->addActivity('order_account', $activity_data);
				} else {
					$activity_data = array(
						'name'     => $this->session->data['guest']['firstname'] . ' ' . $this->session->data['guest']['lastname'],
						'order_id' => $this->session->data['order_id']
					);

					$this->model_account_activity->addActivity('order_guest', $activity_data);
				}
			}

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
			unset($this->session->data['totals']);
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_basket'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_checkout'),
			'href' => $this->url->link('checkout/checkout', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_success'),
			'href' => $this->url->link('checkout/success')
		);

		$data['heading_title'] = $this->language->get('heading_title');

		if ($this->customer->isLogged()) {
			$data['text_message'] = sprintf($this->language->get('text_customer'), $this->url->link('account/account', '', true), $this->url->link('account/order', '', true), $this->url->link('account/download', '', true), $this->url->link('information/contact'));
		} else {
			$data['text_message'] = sprintf($this->language->get('text_guest'), $this->url->link('information/contact'));
		}

		$data['button_continue'] = $this->language->get('button_continue');

		$data['continue'] = $this->url->link('common/home');

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/success', $data));
	}
}