<?php 
class ControllerExtensionFeedParseGablias extends Controller {
	public function index() {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '4096M');
				
		// header('Content-Type: text/html; charset=utf-8');

		
		$file = 'xml_feeds/dimcol.xml';

		//$feed = file_get_contents($file);

		//$xml = new SimpleXmlElement($feed);

		define(IMAGE_PATH, 'catalog/products/gb/');
	    	
	  	$data_xml = file_get_contents($file);

	  	if (!$data_xml){
			exit("Xml file does not exists!");
		}

		$xml = simplexml_load_string($data_xml , "SimpleXMLElement", LIBXML_NOCDATA );

		foreach ($xml->ΓΚΑΜΠΛΙΑΣ as $item) {
			$data = get_object_vars($item);				

			// get the id of the products who are already at the db
			$product_id = $this->getXMLproducts($data['ΚΩΔΙΚΟΣ']);

			$price = round($data['ΤΙΜΗ_ΛΙΑΝΙΚΗΣ'] / 1.24, 4);

			if($data['BRAND']){
				$manufacturer_id = $this->getManufacturerId($data['BRAND']);
			}else{
				$manufacturer_id = '';
			}				
			
			if($product_id){
				$data_products = array(
					'product_id' => $product_id,						
					'price' => $price,
					'name' => $data['ΠΕΡΙΓΡΑΦΗ'],
					'description' => $data['ΠΑΡΑΤΗΡΗΣΕΙΣ']
				);

				echo '<pre>';
				print_r($data_products);
				echo '</pre>';

				$this->updateProduct($data_products);

			}else{

				if($data['DESIGN']){
					$attribute[12] = $data['DESIGN'];
				}

				if($data['DESIGN1']){
					$attribute[13] = $data['DESIGN1'];
				}
				
				if($data['ΜΕΓΕΘΟΣ']){
					$attribute[14] = $data['ΜΕΓΕΘΟΣ'];
				}
	
				if($data['ΜΟΝΑΔΑ']){
					$attribute[22] = $data['ΜΟΝΑΔΑ'];
				}

				if($data['ΕΙΔΟΣΑ']){
					$attribute[29] = $data['ΕΙΔΟΣΑ'];
				}

				if($data['ΕΙΔΟΣ1']){
					$attribute[30] = $data['ΕΙΔΟΣ1'];
				}

				$data_products = array(
					'model' => $data['ΚΩΔΙΚΟΣ'],
					'mpn' => $data['ΚΩΔΙΚΟΣ'],
					'name' => $data['ΠΕΡΙΓΡΑΦΗ'],
					'description' => $data['ΠΑΡΑΤΗΡΗΣΕΙΣ'],
					'price' => $price,
					'manufacturer_id' => $manufacturer_id,
					'image' => IMAGE_PATH . $data['ΚΩΔΙΚΟΣ'] . '.jpg',
					'attributes' =>	$attribute
				);

				echo '<pre>';
				print_r($data_products);
				echo '</pre>';

				$this->addNewProduct($data_products);		
			}
		}


		$message = "Xml Parser completed successfully at " . date("d/m/Y H:i") . "\n";

		// mail('s.ntaskas@icop.gr',"Xml Parse",$message);

		echo $message;
	
	}	

	private function getXMLproducts($model){
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $model ."' AND gablias_flag = '1'");

		if($query->num_rows){
			$product_id = $query->row['product_id'];
		}else{
			$product_id = 0;
		}

		return $product_id;
	}


	private function addNewProduct($data){

		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $data['model'] . "',  mpn = '" . $data['mpn'] . "', image = '" . $data['image'] . "', manufacturer_id = '" . $data['manufacturer_id'] . "', price = '" . $data['price'] . "', quantity = '1', stock_status_id = '7', status = '0', tax_class_id = '9', gablias_flag = '1'");

		$product_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($data['name']) . "',  description = '" . $this->db->escape($data['description']) . "', meta_title = '" . $this->db->escape($data['name']) . "', language_id = '2'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '0'");


		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '166'");		

		foreach ($data['attributes'] as $key => $attribute) {

			$this->db->query("INSERT INTO " . DB_PREFIX . "product_attribute SET product_id = '" . $product_id . "', attribute_id = '" . $key . "', language_id = '2', text = '" . $this->db->escape($attribute) . "'");
		}

		return $product_id;

	}

	private function updateProduct($data){
		$this->db->query("UPDATE " . DB_PREFIX . "product SET price = '" . (float)$data['price'] . "' WHERE product_id = '" . (int)$data['product_id'] . "' ");

		$this->db->query("UPDATE " . DB_PREFIX . "product_description SET name = '" . $this->db->escape($data['name']) . "',  description = '" . $this->db->escape($data['description']) . "', meta_title = '" . $this->db->escape($data['name']) . "' WHERE product_id = '" . $data['product_id'] . "' AND language_id = '2'");	

		return 1;
	}

	private function getManufacturerId($name) {

		$query = $this->db->query("SELECT m.manufacturer_id FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND m.name = '" .$this->db->escape($name) . "'");

		if ($query->num_rows) {
			return $query->row['manufacturer_id'];
		} else {
			$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer SET name = '" . $this->db->escape($name) . "', sort_order = '0'");

			$manufacturer_id = $this->db->getLastId();

			$this->db->query("INSERT INTO " . DB_PREFIX . "manufacturer_to_store SET manufacturer_id = '" . (int)$manufacturer_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "'");

			return $manufacturer_id;
		}
	}
}
?>