<?php
class ControllerExtensionModuleCookie extends Controller {	

	public function index() {

		$this->language->load('extension/module/cookie');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');
		
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
        	
			$this->model_setting_setting->editSetting('cookie', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}


		$data['heading_title'] = $this->language->get('heading_title');

        $data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/cookie', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$results = $this->model_setting_setting->getSetting('cookie');
		
		$data['stats'] = array();
		$data['marketing']  = array();
		
		if (isset($results['cookie_stats'])) {
			$data['stats'] = $results['cookie_stats'];
		}

		if (isset($results['cookie_marketing'])) {
			$data['marketing'] = $results['cookie_marketing'];
		}

		if (isset($results['cookie_small_text'])) {
			$data['small_text'] = $results['cookie_small_text'];
		}

		if (isset($results['cookie_page'])) {
			$data['page'] = $results['cookie_page'];
		}
			

		$this->load->model('catalog/information');

		$data['informations'] = $this->model_catalog_information->getInformations();

		$this->load->model('localisation/language');

        $data['languages'] = $this->model_localisation_language->getLanguages(); 

		$data['action'] = $this->url->link('extension/module/cookie', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL');

       	$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/cookie', $data));
	}

}

?>