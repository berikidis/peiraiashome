<?php
class ControllerExtensionModuleSeo extends Controller {
	private $error = array(); 

	public function index() {   
		$this->language->load('extension/module/seo');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('seo', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}


		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}


		$data['token'] = $this->session->data['token'];

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_content_top'] = $this->language->get('text_content_top');
		$data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$data['text_column_left'] = $this->language->get('text_column_left');
		$data['text_column_right'] = $this->language->get('text_column_right');

		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_position'] = $this->language->get('entry_position');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_language'] = $this->language->get('entry_language');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_subcategories'] = $this->language->get('entry_subcategories');
		$data['entry_help_subcategories'] = $this->language->get('entry_help_subcategories');
		$data['entry_submit'] = $this->language->get('entry_submit');
		$data['entry_delete'] = $this->language->get('entry_delete');
		$data['text_exclude_products'] = $this->language->get('text_exclude_products');
		
		$data['exclude_categories'] = $this->language->get('exclude_categories');
		$data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$data['button_backup'] = $this->language->get('button_backup');


		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_descripiton'] = $this->language->get('entry_meta_descripiton');
		$data['entry_smp_title'] = $this->language->get('entry_smp_title');
		$data['entry_smp_h1_title'] = $this->language->get('entry_smp_h1_title');
		$data['entry_smp_alt_images'] = $this->language->get('entry_smp_alt_images');
		$data['entry_smp_title_images'] = $this->language->get('entry_smp_title_images');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_fields'] = $this->language->get('entry_fields');
		$data['text_edit'] = $this->language->get('text_edit');

		$data['entry_exclude_products'] = $this->language->get('entry_exclude_products');
		$data['entry_exclude_categories'] = $this->language->get('entry_exclude_categories');


		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_add_module'] = $this->language->get('button_add_module');
		$data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/seo', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$data['action'] = $this->url->link('extension/module/seo', 'token=' . $this->session->data['token'], 'SSL');

		// Filters
		$this->load->model('catalog/product');

		$products = $this->model_catalog_product->getProducts();		

		$data['exclude_products'] = array();

		foreach ($products as $product) {			
				$data['exclude_products'][] = array(
					'product_id' => $product['product_id'],
					'name'      => $product['name']
				);
		}

		if(isset($this->request->post['keyword'])){
			$data['keyword'] = $this->request->post['keyword'];
		}else{
			$data['keyword'] = '';
		}

		if(isset($this->request->post['seo_url'])){
			$data['seo_url'] = $this->request->post['seo_url'];
		}else{
			$data['seo_url'] = '';
		}



		$this->load->model('catalog/category');

		$cfilter_data = array(
			'sort'  => $sort,
			'order' => $order
			
		);

		$data['categories'] = $this->model_catalog_category->getCategories($cfilter_data);


		if (isset($this->request->post['product-exclude'])) {
			$categories = $this->request->post['product-exclude'];
		} elseif (isset($this->request->get['product_id'])) {
			$categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$categories = array();
		}

		$data['product_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}


		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['modules'] = array();

		// $this->template = 'extension/module/seo.tpl';
		// $this->children = array(
		// 	'common/header',
		// 	'common/footer'
		// );

		// $this->response->setOutput($this->render());

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/seo', $data));
	}

	public function update_seo(){

		$this->load->model('catalog/seo');
		$update_info = array();
		$exclude_products = array();
		$seo_data = $this->request->post;
			if (isset($seo_data['products'])) {
				foreach ($seo_data['products'] as $key => $value) {
					$exclude_products[] = $value;
				}
			}

		$update_info = $this->model_catalog_seo->updateSeoData($seo_data,$exclude_products);
		
		if($update_info){			
			$json['success'] = 'Products Has Successfully updated';
		}else{
			$json['error'] = 'Something went wrong. Please check the form.';
		}


		$this->response->setOutput(json_encode($json));

	}


	public function delete_seo(){

		$this->load->model('catalog/seo');
		$update_info = array();
		$exclude_products = array();
		$seo_data = $this->request->post;

		if (isset($seo_data['products'])) {
			foreach ($seo_data['products'] as $key => $value) {
				$exclude_products[] = $value;
			}
		}

		$update_info = $this->model_catalog_seo->deleteSeoData($seo_data,$exclude_products);
		
		if($update_info){			
			$json['success'] = 'Products Has Successfully updated';
		}else{
			$json['error'] = 'Something went wrong. Please check the form.';
		}


		$this->response->setOutput(json_encode($json));

	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
						);
					}
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/seo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}


	public function createBackup() {
		$json = array();
		$this->language->load('extension/module/seo');
		$backupfile = realpath(DIR_CATALOG. '/..') . '/.icop/' .'before_seo_fix_backup.sql';

		if ($this->user->hasPermission('modify', 'tool/backup')) {
			$tables = array(DB_PREFIX.'product_description',DB_PREFIX.'url_alias');
			if (!file_exists($backupfile)) :
				$this->load->model('tool/backup');
				$backup = fopen($backupfile, "w") or die("Unable to open file!");
				fwrite($backup, $this->model_tool_backup->backup($tables));
				fclose($backup);
				$json['success'] = $this->language->get('backup_success');
			else :
				$json['error'] = $this->language->get('error_backup_file');
			endif;
			$this->response->setOutput(json_encode($json));

		} else {
			$json['error'] = $this->language->get('error_permission');

			$this->response->setOutput(json_encode($json));			
		}
	}
}
?>