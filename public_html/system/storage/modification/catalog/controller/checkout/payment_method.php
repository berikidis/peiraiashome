<?php
class ControllerCheckoutPaymentMethod extends Controller {

       public function validateCoupon() {
    
    $this->language->load('checkout/cart'); 
    $this->language->load('extension/module/couponcheckout'); 
    $json = array();    
    if (!$this->cart->hasProducts()) {
      $json['redirect'] = $this->url->link('checkout/cart');        
    } 
        
    if (isset($this->request->post['coupon'])) {
      $this->load->model('extension/total/coupon');  
      $coupon_info = $this->model_extension_total_coupon->getCoupon($this->request->post['coupon']); 
      
      if ($coupon_info) {     
        $this->session->data['coupon'] = $this->request->post['coupon'];        
        $json['success'] = $this->language->get('text_couponsuccess');   

        // Totals
        $this->load->model('extension/extension');

        $totals = array();
        $taxes = $this->cart->getTaxes();
        $total = 0;
    
        // Because __call can not keep var references so we put them into an array.       
        $total_data = array(
          'totals' => &$totals,
          'taxes'  => &$taxes,
          'total'  => &$total
        );

        // Display prices
        if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {

          $sort_order = array();

          $results = $this->model_extension_extension->getExtensions('total');

          foreach ($results as $key => $value) {
            $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
          }

          array_multisort($sort_order, SORT_ASC, $results);

          foreach ($results as $result) {
            if ($this->config->get($result['code'] . '_status')) {
              $this->load->model('extension/total/' . $result['code']);

              // We have to put the totals in an array so that they pass by reference.
              $this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
            }
          }

          $sort_order = array();

          foreach ($totals as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
          }

          array_multisort($sort_order, SORT_ASC, $totals);
        }

        $json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
      } else {
        $json['error'] = $this->language->get('error_coupon_expired');
      }
    }
    
    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }
      
	public function index() {
		$this->load->language('checkout/checkout');

		if (isset($this->session->data['payment_address'])) {
			// Totals
			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array.
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
			
			$this->load->model('extension/extension');

			$sort_order = array();

			$results = $this->model_extension_extension->getExtensions('total');

			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}

			array_multisort($sort_order, SORT_ASC, $results);

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('extension/total/' . $result['code']);
					
					// We have to put the totals in an array so that they pass by reference.
					$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
				}
			}

			// Payment Methods
			$method_data = array();

			$this->load->model('extension/extension');

			$results = $this->model_extension_extension->getExtensions('payment');

			$recurring = $this->cart->hasRecurringProducts();

			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('extension/payment/' . $result['code']);

					$method = $this->{'model_extension_payment_' . $result['code']}->getMethod($this->session->data['payment_address'], $total);

					if ($method) {

						/** EET Module */
						if ($this->config->get('ee_tracking_status') && $this->config->get('ee_tracking_checkout_status') && $this->config->get('ee_tracking_advanced_settings') && $this->config->get('ee_tracking_language_id') && isset($this->session->data['language']) && $this->session->data['language'] != $this->config->get('ee_tracking_language_id')) {
							$this->load->model('localisation/language');
							$ee_languages = $this->model_localisation_language->getLanguages();
							foreach ($ee_languages as $ee_item) {
								if ($ee_item['language_id'] == $this->config->get('ee_tracking_language_id')) {
									$language = new Language($ee_item['code']);
									$language->load($ee_item['code']);
									$language->load('extension/payment/' . $result['code']);
									$method['ee_title'] = $language->get('text_title');
								}
							}
						}
						/** EET Module */
            
						if ($recurring) {
							if (property_exists($this->{'model_extension_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_extension_payment_' . $result['code']}->recurringPayments()) {
								$method_data[$result['code']] = $method;
							}
						} else {
							$method_data[$result['code']] = $method;
						}
					}
				}
			}

			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $method_data);

			$this->session->data['payment_methods'] = $method_data;
		}

		$data['text_payment_method'] = $this->language->get('text_payment_method');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['button_continue'] = $this->language->get('button_continue');


        $this->load->language('extension/module/couponcheckout');
       $data['coupon_heading_title'] =  $this->language->get('coupon_title');
      $data['entry_coupon'] = $this->language->get('text_coupon_entry');

      if (isset($this->request->post['coupon'])) {
        $data['coupon'] = $this->request->post['coupon'];     
      } elseif (isset($this->session->data['coupon'])) {
        $data['coupon'] = $this->session->data['coupon'];
      } else {
        $data['coupon'] = '';
      }
    $data['button_coupon'] = $this->language->get('text_coupon_apply');
      
		if (empty($this->session->data['payment_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['payment_methods'])) {
			$data['payment_methods'] = $this->session->data['payment_methods'];
		} else {
			$data['payment_methods'] = array();
		}

		if (isset($this->session->data['payment_method']['code'])) {
			$data['code'] = $this->session->data['payment_method']['code'];
		} else {
			$data['code'] = '';
		}

		if (isset($this->session->data['comment'])) {
			$data['comment'] = $this->session->data['comment'];
		} else {
			$data['comment'] = '';
		}

		$data['scripts'] = $this->document->getScripts();

		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info) {
				$data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/agree', 'information_id=' . $this->config->get('config_checkout_id'), true), $information_info['title'], $information_info['title']);
			} else {
				$data['text_agree'] = '';
			}
		} else {
			$data['text_agree'] = '';
		}

		if (isset($this->session->data['agree'])) {
			$data['agree'] = $this->session->data['agree'];
		} else {
			$data['agree'] = '';
		}


		/** EET Module */
		$data['ee_tracking'] = $this->config->get('ee_tracking_status');
		if ($data['ee_tracking']) {
			$data['ee_checkout'] = $this->config->get('ee_tracking_checkout_status');
			$data['ee_checkout_log'] = $this->config->get('ee_tracking_log') ? $this->config->get('ee_tracking_checkout_log') : false;
			$ee_data = array('step_option' => 'No payment methods available');
			if (isset($this->session->data['payment_method']['code'])) {
				$ee_code = $this->session->data['payment_method']['code'];
			} else {
				$ee_code = '';
			}
			if (isset($this->session->data['payment_methods'])) {
				foreach ($this->session->data['payment_methods'] as $payment_method) {
					if ($payment_method['code'] == $ee_code || !$ee_code) {
						$ee_code = $payment_method['code'];
						if (isset($payment_method['ee_title'])) {
							$ee_data['step_option'] = htmlspecialchars($payment_method['ee_title'], ENT_QUOTES, 'UTF-8');
						} else {
							$ee_data['step_option'] = htmlspecialchars($payment_method['title'], ENT_QUOTES, 'UTF-8');
						}
					}
				}
			}
			$ee_data['step'] = 5;
			$data['ee_data'] = json_encode($ee_data);
		}
		/** EET Module */
            
		$this->response->setOutput($this->load->view('checkout/payment_method', $data));
	}

	public function save() {
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate if payment address has been set.
		if (!isset($this->session->data['payment_address'])) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', true);
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!isset($this->request->post['payment_method'])) {
			$json['error']['warning'] = $this->language->get('error_payment');
		} elseif (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
			$json['error']['warning'] = $this->language->get('error_payment');
		}

		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info && !isset($this->request->post['agree'])) {
				$json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}

		if (!$json) {
			$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];

			$this->session->data['comment'] = strip_tags($this->request->post['comment']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
