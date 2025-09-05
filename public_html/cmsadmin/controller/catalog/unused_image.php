<?php 
class ControllerCatalogUnusedImage extends Controller {
	private $error = array(); 
	private $ssl = 'SSL';

	public function __construct( $registry ) {
		parent::__construct( $registry );
		$this->ssl = (defined('VERSION') && version_compare(VERSION,'2.2.0.0','>=')) ? true : 'SSL';
	}

     
	public function index() {
		$this->load->language('catalog/unused_image');

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->load->model('catalog/unused_image');

		$this->getList();
	}


	public function delete() {
		$this->load->language('catalog/unused_image');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/unused_image');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $image_name) {
				$this->model_catalog_unused_image->deleteUnusedImage($image_name);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('catalog/unused_image', 'token=' . $this->session->data['token'] . $url, $this->ssl));
		}

		$this->getList();
	}


	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
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

		$url = '';
		
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], $this->ssl)
		);

		$data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/unused_image', 'token=' . $this->session->data['token'] . $url, $this->ssl)
		);

		$data['delete'] = $this->url->link('catalog/unused_image/delete', 'token=' . $this->session->data['token'] . $url, $this->ssl);
		$data['scan'] = $this->url->link('catalog/unused_image/scanImages', 'token=' . $this->session->data['token'] . $url, $this->ssl);
		$data['clear_cache'] = $this->url->link('catalog/unused_image/clearCache', 'token=' . $this->session->data['token'] . $url, $this->ssl);

		$data['images'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name, 
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);
		$image_total = $this->model_catalog_unused_image->getTotalImages($filter_data);
		$results = $this->model_catalog_unused_image->getImages($filter_data);

		foreach ($results as $result) {
			$data['images'][] = array(
				'name'       => $result['name'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['name'], $this->request->post['selected']),
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_list'] = $this->language->get('text_list');

		$data['entry_name'] = $this->language->get('entry_name');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_scan'] = $this->language->get('button_scan');
		$data['button_clear_cache'] = $this->language->get('button_clear_cache');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		if (isset($this->session->data['unused_image_error'])) {
			$data['error_warning'] = $this->session->data['unused_image_error'];
			unset( $this->session->data['unused_image_error'] );
		} else if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/unused_image', 'token=' . $this->session->data['token'] . '&sort=name' . $url, $this->ssl);
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $image_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/unused_image', 'token=' . $this->session->data['token'] . $url . '&page={page}', $this->ssl);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($image_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($image_total - $this->config->get('config_limit_admin'))) ? $image_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $image_total, ceil($image_total / $this->config->get('config_limit_admin')));
	
		$data['filter_name'] = $filter_name;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		if (defined('VERSION') && version_compare(VERSION,'2.2.0.0','>=')) {
			$this->response->setOutput($this->load->view('catalog/unused_image_list', $data));
		} else {
			$this->response->setOutput($this->load->view('catalog/unused_image_list.tpl', $data));
		}
	}


	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/unused_image')) {
			$this->error['warning'] = $this->language->get('error_permission');  
		}

		return !$this->error;
	}


	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/unused_image');
			
			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 20;
			}

			$filter_data = array(
				'filter_name'         => $filter_name,
				'start'               => 0,
				'limit'               => $limit
			);

			$results = $this->model_catalog_unused_image->getImages($filter_data);
			
			foreach ($results as $result) {
				$json[] = array(
					'name'       => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),	
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}


	public function clearCache() {
		$this->load->model( 'catalog/unused_image' );
		$this->model_catalog_unused_image->clearCache( DIR_IMAGE . 'cache' );
		$this->load->language( 'catalog/unused_image' );
		$this->session->data['success'] = $this->language->get('text_success2');
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$this->response->redirect( $this->url->link( 'catalog/unused_image', 'token=' . $this->session->data['token'] . $url, $this->ssl) );
	}


	public function scanImages() {
		$this->load->model( 'catalog/unused_image' );
		$this->model_catalog_unused_image->scanImages();
		$this->load->language( 'catalog/unused_image' );
		$this->session->data['success'] = $this->language->get('text_success3');
		$url = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$this->response->redirect( $this->url->link( 'catalog/unused_image', 'token=' . $this->session->data['token'] . $url, $this->ssl) );
	}
}
?>