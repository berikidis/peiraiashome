<?php 
class ControllerExtensionFeedParser extends Controller {
	public function index() {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '4096M');
				
		// header('Content-Type: text/html; charset=utf-8');

		$files[0] = 'xml_feeds/palamaiki.xml';
		$files[1] = 'xml_feeds/palamaikiektos.xml';

		//$feed = file_get_contents($file);

		//$xml = new SimpleXmlElement($feed);

		define(IMAGE_PATH, 'catalog/products/xml/');
		 		
	    foreach ($files as $key => $file) {
	    	
	  		$data_xml = file_get_contents($file);

	  		if (!$data_xml){
				exit("Xml file does not exists!");
			}

			$xml = simplexml_load_string($data_xml , "SimpleXMLElement", LIBXML_NOCDATA );

			foreach ($xml->line as $item) {
				$data = get_object_vars($item);				

				// get the id of the products who are alreay at the db
				$product_id = $this->getXMLproducts($data['BARCODE']);
				
				// $attributes = $data['attributes'];
				$attribute = array();

				$price = round($data['ΤΙΜΗΛΙΑΝΙΚΗΣ'] / 1.24, 4);

				if($data['ΤΙΜΗΛΙΑΝΙΚΗΣΜΕΤΑΤΗΝΕΚΠΤΩΣΗE-SHOP']){
					$special = round($data['ΤΙΜΗΛΙΑΝΙΚΗΣΜΕΤΑΤΗΝΕΚΠΤΩΣΗE-SHOP'] / 1.24, 4);
				}else{
					$special = 0;
				}

				if (!empty($data['ΔΙΑΘΕΣΙΜΟΤΗΤΑ'])){
					$stock_status_id = $this->getStockStatus($data['ΔΙΑΘΕΣΙΜΟΤΗΤΑ']);
					if($stock_status_id == 9){
						$quantity = '10';
					} elseif ($stock_status_id == 12) {
						$quantity = '0';
					} elseif ($stock_status_id == 11) {
						$quantity = '1';
					} elseif ($stock_status_id == 10) {
						$quantity = '0';
					} else {
						$quantity = '10';
					}
				} else {
					$stock_status_id = 7;
					$quantity = '10';
				}
				
				if ($data['ΜΕΓΕΘΟΣ']){
					$attribute[14] = $data['ΜΕΓΕΘΟΣ'];
				} else {
					$attribute[14] = '';
				}

				if ($data['ΠΟΙΟΤΗΤΑ']){
					$attribute[15] = $data['ΠΟΙΟΤΗΤΑ'];
				} else {
					$attribute[15] = '';
				}

				if ($data['ΤΜΧ']){
					$attribute[16] = $data['ΤΜΧ'];
				} else {
					$attribute[16] = '';
				}

				if ($data['ΔΙΑΣΤΑΣΕΙΣ']){
					$attribute[17] = $data['ΔΙΑΣΤΑΣΕΙΣ'];
				} else {
					$attribute[17] = '';
				}

				if ($data['ΜΟΝΑΔΑΜΕΤΡΗΣΗΣ']){
					$attribute[22] = $data['ΜΟΝΑΔΑΜΕΤΡΗΣΗΣ'];
				} else {
					$attribute[22] = '';
				}

				if ($data['ΣΥΛΛΟΓΗ']){
					$attribute[23] = $data['ΣΥΛΛΟΓΗ'];
				} else {
					$attribute[23] = '';
				}

				if ($data['ΜΕΛΑΣΤΙΧΟ']){
					$attribute[24] = $data['ΜΕΛΑΣΤΙΧΟ'];
				} else {
					$attribute[24] = '';
				}

				if ($data['ΒΑΡΟΣ']){
					$attribute[25] = $data['ΒΑΡΟΣ'];
				} else {
					$attribute[25] = '';
				}

				if ($data['ΟΔΗΓΙΕΣΠΛΥΣΙΜΑΤΟΣ']){
					$attribute[26] = $data['ΟΔΗΓΙΕΣΠΛΥΣΙΜΑΤΟΣ'];
				} else {
					$attribute[26] = '';
				}

				if ($data['ΧΡΩΜΑ']){
					$attribute[27] = $data['ΧΡΩΜΑ'];
				} else {
					$attribute[27] = '';
				}

				
				if ($product_id){
					$data_products = array(
						'product_id' => $product_id,						
						'price' => $price,
						'name' => $data['ΠΕΡΙΓΡΑΦΗ'],
						'description' => $data['ΠΕΡΙΓΡΑΦΗ'],
						'stock_status_id' => $stock_status_id,
						'quantity' => $quantity,
						'special' => $special,
						'attributes' => $attribute
					);

					// echo '<pre>';
					echo 'Update product' . "\n";
					print_r($data_products);
					// echo '</pre>';

					$this->updateProduct($data_products);

				} else {
	
					$data_products = array(
						'model' => $data['BARCODE'],
						'mpn' => $data['BARCODE'],
						'name' => $data['ΠΕΡΙΓΡΑΦΗ'],
						'ean' => $data['ΚΩΔΙΚΟΣΛΟΓΙΣΤΗΡΙΟΥ'],
						'description' => $data['ΠΕΡΙΓΡΑΦΗ'],
						'price' => $price,
						'stock_status_id' => $stock_status_id,
						'quantity' => $quantity,
						'special' => $special,
						'image' => IMAGE_PATH . $data['BARCODE'] . '.jpg',
						'attributes' =>	$attribute
					);

					// echo '<pre>';
					// print_r($data_products);
					// echo '</pre>';

					$this->addNewProduct($data_products);		
				}
			}
		}


		$message = "Xml Parser completed successfully at " . date("d/m/Y H:i") . "\n";

		// mail('s.ntaskas@icop.gr',"Xml Parse",$message);

		echo $message;
	
	}	

	private function getXMLproducts($model){
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $model ."' AND xml_flag = '1'");

		if($query->num_rows){
			$product_id = $query->row['product_id'];
		}else{
			$product_id = 0;
		}

		return $product_id;
	}

	private function getStockStatus($name){
		$query = $this->db->query("SELECT stock_status_id FROM " . DB_PREFIX . "stock_status WHERE name = '".$this->db->escape($name)."' AND language_id = '2'");

		if($query->num_rows > 0){
			return $query->row['stock_status_id'];
		}else{
			$this->db->query("INSERT INTO " . DB_PREFIX . "stock_status SET name = '" . $this->db->escape($name) . "', language_id = '2'");

			$stock_status_id = $this->db->getLastId();

			return $stock_status_id;

		}
	}


	private function addNewProduct($data){

		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $data['model'] . "',  ean = '" . $data['ean'] . "',  mpn = '" . $data['mpn'] . "', image = '" . $data['image'] . "', manufacturer_id = '14', price = '" . $data['price'] . "', quantity = '" . $data['quantity'] . "', stock_status_id = '" . $data['stock_status_id'] . "', status = '0', tax_class_id = '9', xml_flag = '1'");

		$product_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', meta_title = '" . $this->db->escape($data['name']) . "', language_id = '2'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '0'");


		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '165'");

		

		if($data['special'] > 0){

			$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$product_id . "', price = '" . $data['special'] . "', customer_group_id = '1'");
		}
		

		foreach ($data['attributes'] as $key => $attribute) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . $product_id . "', attribute_id = '" . $key . "', language_id = '2', text = '" . $this->db->escape($attribute) . "'");
		}

		return $product_id;

	}

	private function updateProduct($data){

		$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET quantity = '" . $data['quantity'] . "', stock_status_id = '".$data['stock_status_id']."', price = '" . (float)$data['price'] . "' WHERE product_id = '" . (int)$data['product_id'] . "' ");

		$this->db->query("UPDATE " . DB_PREFIX . "product_description SET name = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "', meta_title = '" . $this->db->escape($data['name']) . "' WHERE product_id = '" . (int)$data['product_id'] . "' AND language_id = '2'");

		if($data['special'] > 0){
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$data['product_id'] . "'");
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "product_special SET product_id = '" . (int)$data['product_id'] . "', price = '" . $data['special'] . "', customer_group_id = '1'");
		}

		foreach ($data['attributes'] as $key => $attribute) {

			$query = "UPDATE " . DB_PREFIX . "product_attribute SET text = '" . $this->db->escape($attribute) . "' WHERE product_id = '" . $data['product_id'] . "' AND attribute_id = '" . $key . "' AND language_id = '2'";
			$this->db->query($query);
			echo $query . "\n";
		}
		

		return 1;
	}
}
?>