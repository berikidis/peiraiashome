<?php
class ControllerExtensionAnalyticsBestPriceAnalytics extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/analytics/bestprice_analytics');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('bestprice_analytics', $this->request->post, $this->request->get['store_id']);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=analytics', true));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data["text_none"] = $this->language->get("text_none");
		$data["text_product_badge_settings"] = $this->language->get("text_product_badge_settings");
		$data["text_update"] = $this->language->get("text_update");
		$data["text_update_error"] = $this->language->get("text_update_error");
		$data["text_update_available"] = $this->language->get("text_update_available");
		$data["text_updated"] = $this->language->get("text_updated");
		$data["text_extension_version"] = $this->language->get("text_extension_version");
		$data["text_download"] = $this->language->get("text_download");
		$data["text_download_now"] = $this->language->get("text_download_now");
		
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_feed_id'] = $this->language->get('entry_feed_id');
		$data["entry_tax_class"] = $this->language->get("entry_tax_class");
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_product_badge_status'] = $this->language->get('entry_product_badge_status');
		$data['entry_product_badge_mid'] = $this->language->get('entry_product_badge_mid');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_product_badge'] = $this->language->get('tab_product_badge');
		$data['tab_update'] = $this->language->get('tab_update');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$this->load->model("localisation/tax_class");
        $data["tax_classes"] = $this->model_localisation_tax_class->getTaxClasses();
		
		$data["curr_version"] = $curr_version = "1.0.7";
		$version = @file_get_contents("https://360-plugins.bestprice.gr/bestprice/opencart/2.3/version.txt");
		$download_link = @file_get_contents("https://360-plugins.bestprice.gr/bestprice/opencart/2.3/link.txt");

		$data["up_to_date"] = FALSE;
		$data["update_error"] = FALSE;

		if($version === FALSE) {
			$data["update_error"] = TRUE;
		} else {
			$version = trim($version);

            if ($version == $curr_version) {
				$data["up_to_date"] = TRUE;
            } else {
				$data["up_to_date"] = FALSE;
				$data["version"] = $version;
			}	
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=analytics', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/analytics/bestprice_analytics', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], true)
		);

		$data['action'] = $this->url->link('extension/analytics/bestprice_analytics', 'token=' . $this->session->data['token'] . '&store_id=' . $this->request->get['store_id'], true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=analytics', true);
		
		$data['token'] = $this->session->data['token'];
				
		if (isset($this->request->post['bestprice_analytics_code'])) {
			$data['bestprice_analytics_code'] = $this->request->post['bestprice_analytics_code'];
		} else {
			$data['bestprice_analytics_code'] = $this->model_setting_setting->getSettingValue('bestprice_analytics_code', $this->request->get['store_id']);
		}
		
		if (isset($this->request->post['bestprice_analytics_feed_id'])) {
			$data['bestprice_analytics_feed_id'] = $this->request->post['bestprice_analytics_feed_id'];
		} else {
			$data['bestprice_analytics_feed_id'] = $this->config->get('bestprice_analytics_feed_id');
		}
		
		if (isset($this->request->post["bestprice_analytics_tax_class_id"])) {
            $data["bestprice_analytics_tax_class_id"] = $this->request->post["bestprice_analytics_tax_class_id"];
        } else {
            $data["bestprice_analytics_tax_class_id"] = $this->config->get("bestprice_analytics_tax_class_id");
        }
		
		if (isset($this->request->post['bestprice_analytics_status'])) {
			$data['bestprice_analytics_status'] = $this->request->post['bestprice_analytics_status'];
		} else {
			$data['bestprice_analytics_status'] = $this->model_setting_setting->getSettingValue('bestprice_analytics_status', $this->request->get['store_id']);
		}
		
		if (isset($this->request->post["bestprice_analytics_product_badge_status"])) {
            $data["bestprice_analytics_product_badge_status"] = $this->request->post["bestprice_analytics_product_badge_status"];
        } else {
            $data["bestprice_analytics_product_badge_status"] = $this->config->get("bestprice_analytics_product_badge_status");
        }
		
		if (isset($this->request->post['bestprice_analytics_product_badge_mid'])) {
			$data['bestprice_analytics_product_badge_mid'] = $this->request->post['bestprice_analytics_product_badge_mid'];
		} else {
			$data['bestprice_analytics_product_badge_mid'] = $this->model_setting_setting->getSettingValue('bestprice_analytics_product_badge_mid', $this->request->get['store_id']);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/analytics/bestprice_analytics', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/analytics/bestprice_analytics')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['bestprice_analytics_code']) {
			$this->error['code'] = $this->language->get('error_code');
		}			

		return !$this->error;
	}
}
