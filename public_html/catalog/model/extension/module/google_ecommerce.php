<?php
class ModelExtensionModuleGoogleEcommerce extends Model {
	public function getOrderTax($order_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE code = 'tax' AND order_id = '" . (int)$order_id . "' LIMIT 1");
		if ($query->row) {
			return $query->row['value'];	
		}else{
			return '0';
		}
	}
	
	public function getOrderShipping($order_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE code = 'shipping' AND order_id = '" . (int)$order_id . "' LIMIT 1");
		if ($query->row) {
			return $query->row['value'];	
		}else{
			return '0';
		}	
	}
	
	public function getOrderCoupon($order_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE code = 'coupon' AND order_id = '" . (int)$order_id . "' LIMIT 1");
		if ($query->row) {
			return $query->row['title'];	
		}else{
			return '';
		}	
	}
	
	public function getOrderProducts($order_id){
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
	
		if($query->rows){
			return $query->rows;
		} else {
			return false;	
		}
	}
	
	public function getProductSku($product_id){
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product` WHERE product_id = '".(int)$product_id."' LIMIT 1");
		if ($query->row){
			if ($query->row['sku'] == '') {
				return 'Product ID: '.$product_id. ' - Model: '.$query->row['model'];
			}else {
				return $query->row['sku'];
			}
		} else {
			return $product_id;	
		}
	}
	
	public function getProductBrand($product_id){
		$query = $this->db->query("SELECT b.name FROM `" . DB_PREFIX . "product` a, `" . DB_PREFIX . "manufacturer` b WHERE a.manufacturer_id = b.manufacturer_id AND a.product_id = '".(int)$product_id."' LIMIT 1");
		if ($query->row){
			return $query->row['name'];
		} else {
			return '';	
		}
	}
	
	public function getProductCategory($product_id, $language_id){
		$query = $this->db->query("SELECT a.name FROM `" . DB_PREFIX . "category_description` a, `" . DB_PREFIX . "product_to_category` b where a.category_id = b.category_id AND b.product_id = '".(int)$product_id."' AND a.language_id = '".(int)$language_id."' ORDER BY b.category_id DESC LIMIT 1");
		if ($query->row){
			return $query->row['name'];
		} else {
			return 'Category Not Assigned';	
		}
	}
	
	public function build_ecommerce($order_id) {
		$item_data = array();
		$ecommerce = array();
		
		$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($order_id);
		
		$this->load->model('setting/setting');
		$extn_info = $this->model_setting_setting->getSetting('ga_ecom', $order_info['store_id']);
		
		$ga_ecom_id = (isset($extn_info['ga_ecom_id']))? $extn_info['ga_ecom_id'] : 'product_id';
		$ga_ecom_currency = (isset($extn_info['ga_ecom_currency']))? $extn_info['ga_ecom_currency'] : $this->config->get('config_currency');
		
		$products = $this->getOrderProducts($order_id);
		if ($products) {
			foreach ($products as $product) {
				$item_data[] = array(
						'name'			=> $product['name'],
						'sku'			=> ($ga_ecom_id == 'sku')? $this->getProductSku($product['product_id']) : $product['product_id'],
						'brand'			=> $this->getProductBrand($product['product_id']),
						'category'		=> $this->getProductCategory($product['product_id'], $order_info['language_id']),
						'price'			=> number_format($product['price'], 2, '.', ''),
						'quantity'		=> $product['quantity']
					);
			}
		}
		
		$ecommerce = array(
			'transaction_id'	=> $order_id,
			'affiliation'		=> $order_info['store_name'],
			'customer_id'   	=> $order_info['customer_id'],
			//'email'         	=> $order_info['email'],
			'value'				=> number_format($order_info['total'], 2, '.', ''),
			'shipping'			=> $this->getOrderShipping($order_id),
			'tax'				=> $this->getOrderTax($order_id),
			'currency'			=> $ga_ecom_currency,//$order_info['currency_code'],
			'payment_method'	=> $order_info['payment_method'],
			'shipping_method'	=> $order_info['shipping_method'],
			'items'				=> $item_data,
			'coupon'			=> $this->getOrderCoupon($order_id)
		);
		
		$tracking_code = '';
		$tracking_code .= '<script type="text/javascript">';
		$tracking_code .= "gtag('event', 'purchase', ".json_encode($ecommerce).");";
		$tracking_code .= "</script>";
		
		return $tracking_code;
	}	
}