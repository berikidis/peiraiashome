<?php  
class ControllerExtensionModuleCookie extends Controller {
	
	public function index() {
		if (!isset($this->request->cookie['accept_cookies'])) {

			$this->document->addStyle('catalog/view/javascript/bootstrap-modal/bootstrap.min.css');
			$this->document->addStyle('catalog/view/theme/default/stylesheet/cookie.css');
			// $this->document->addScript('catalog/view/javascript/bootstrap-modal/bootstrap.min.js');
			
			$this->language->load('extension/module/cookie');
			if (!isset($this->request->cookie['message'])) {
				setcookie('message_cookie', true , time() + 60 * 60 * 24 * 365, '/', $this->request->server['HTTP_HOST']);
				$data['message_cookie'] = true;
			}
			
			$data['heading_title'] = $this->language->get('heading_title');
			$data['text_cookie'] = $this->language->get('text_cookie');
			$data['text_about_cookies'] = $this->language->get('text_about_cookies');
			$data['text_our_cookies'] = $this->language->get('text_our_cookies');
			$data['text_stats_cookies'] = $this->language->get('text_stats_cookies');
			$data['text_marketing_cookies'] = $this->language->get('text_marketing_cookies');
			$data['text_disable_cookies'] = $this->language->get('text_disable_cookies');
			$data['text_disable'] = $this->language->get('text_disable');
			
			$data['cd']['PHPSESSID'] = $this->language->get('text_session');
			$data['cd']['language'] = $this->language->get('text_language');
			$data['cd']['currency'] = $this->language->get('text_currency');
			$data['cd']['jrv'] = $this->language->get('text_jrv');
			$data['cd']['message_cookie'] = $this->language->get('text_message_cookie');

			$data['cookies'] = array('PHPSESSID'=>'','language'=>'','currency'=>'','jrv'=>'','message_cookie'=>'');

			$data['stats'] =  $this->config->get('cookie_stats');
			$data['marketing'] =  $this->config->get('cookie_marketing');

			$data['cd']['ga'] =  $this->language->get('text_ga');
			$data['cd']['fp'] =  $this->language->get('text_fp');
			$data['cd']['st'] =  $this->language->get('text_st');

			$data['cd']['gm'] =  $this->language->get('text_gm');
			$data['cd']['sa'] =  $this->language->get('text_sa');
			$data['cd']['fm'] =  $this->language->get('text_fm');


			$data['text_type_one'] = $this->language->get('text_type_one');
			$data['text_type_three'] = $this->language->get('text_type_three');
			$data['text_admin_we'] = $this->language->get('text_admin_we');
			$data['text_admin_google'] = $this->language->get('text_admin_google');
			$data['text_admin_facebook'] = $this->language->get('text_admin_facebook');

			$data['column_name'] = $this->language->get('column_name');
			$data['column_description'] = $this->language->get('column_description');
			$data['column_type'] = $this->language->get('column_type');
			$data['column_admin'] = $this->language->get('column_admin');

			$data['button_close'] = $this->language->get('button_close');
			$data['button_settings'] = $this->language->get('button_settings');
			$data['button_accept'] = $this->language->get('button_accept');

			$this->load->model('catalog/information'); // load information model
			$information_info = $this->model_catalog_information->getInformation($this->config->get('cookie_small_text'));
			
			if ($information_info) {
				$data['description'] = html_entity_decode($information_info['description']);
			} else {
				$data['text_cookie'] = sprintf($this->language->get('text_cookie'), $this->url->link('error/not_found'));
				$data['description'] = '';
			}

			return $this->load->view('extension/module/cookie', $data);
		}
	}

	public function acceptCookie() {
		setcookie('accept_cookies', true , time() + 60 * 60 * 24 * 365, '/', $this->request->server['HTTP_HOST']);
	}
}