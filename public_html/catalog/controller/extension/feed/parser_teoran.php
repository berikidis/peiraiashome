<?php 
class ControllerExtensionFeedParserTeoran extends Controller {
	
	public function index() {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '4096M');
				
		header('Content-Type: text/html; charset=utf-8');

					
				
		if (file_exists('teoran.xml')) unlink('teoran.xml');

		// save the xml
		// $xml = file_get_contents("https://teoran.gr/index.php?route=extension/feed/teoran_feed");
		$xml = file_get_contents("https://teoran.gr/index.php?route=extension/feed/teoran_feed_separated");
		
		file_put_contents('teoran.xml', $xml);
			
		if (!file_exists('teoran.xml')) {
			die('file does not exist');
		}

		$folder_to_xml = '';
		$file = $folder_to_xml.'teoran.xml';

		//$feed = file_get_contents($file);

		//$xml = new SimpleXmlElement($feed);
		 		
	    	
	  		$data_xml = file_get_contents($file);

	  		if (!$data_xml){
				exit("Xml file does not exists!");
			}

			$xml = simplexml_load_string($data_xml , "SimpleXMLElement", LIBXML_NOCDATA );
				
			
			foreach ($xml->channel->item as $item) {
				$data = get_object_vars($item);
				
				// $options = get_object_vars($data['option']);

				// $option_values = $options['option_value'];

				// $product_options = array();

				// if(!is_array($option_values)){

				// 	$product_options[] = $option_values;
				// }else{
				// 	$product_options = $option_values;
				// }
				
				if(isset($data['additional_image_link'])){

					if(sizeof($data['additional_image_link']) == 1){
						$extra_images[] = $data['additional_image_link'];
						$copy_image[] = $data['additional_image_link'];
					}elseif(sizeof($data['additional_image_link']) > 1){
						$extra_images = $data['additional_image_link'];
						$copy_image = $data['additional_image_link'];
					}

					$extra_image = '';
					$temp_image = '';

					foreach ($copy_image as $extra_image_link) {
						if(!empty($extra_image_link)){
							$temp_image = explode('/', str_replace('%20','-',$extra_image_link));	
							$extra_image = 'catalog/products/teoran_extra_photos/'.end(rawurlencode($temp_image));
							$extra_image_link =  substr($extra_image_link, 0 , strlen($extra_image_link)-strlen(end($temp_image))) . rawurlencode(end($temp_image));

							if(!file_exists(DIR_IMAGE.$extra_image)) {
								// echo DIR_IMAGE.$extra_image.'<br/>';
								// echo $extra_image_link.'<br/>';
								copy($extra_image_link, DIR_IMAGE.$extra_image);
							}
						}
					}	
				}else{
					$extra_images = '';
				}
				// // get the id of the products who are alreay at the db
				$product_id = $this->getXMLproducts($data['model_number']);

				if(isset($data['image_link'])){
					$temp_main_image = explode('/', $data['image_link']);
					$fullPath = 'catalog/products/teoran/'. end(str_replace('%20','-',$temp_main_image));

					$main_pr_image = explode('/', str_replace('%20','-', $data['image_link']));
					$image = 'catalog/products/teoran/'.end($main_pr_image);
					$temp = explode('/', $data['image_link']);
					$data['image_link'] =  substr($data['image_link'], 0 , strlen($data['image_link'])-strlen(end($main_pr_image))) . rawurlencode(end($main_pr_image));
					if(!file_exists(DIR_IMAGE.$image)) {
						// echo DIR_IMAGE.$image.'<br/>';
						// echo $data['image_link'].'<br/>';
						copy($data['image_link'], DIR_IMAGE.$image);
					}
				}else{
					$fullPath = '';
				}

				if($data['quantity'] > 0){
					$stock_status_id = 7;
				}else{
					$stock_status_id = 5;
				}


				$weight = str_replace('kg', '', $data['weight']);				

				$category = array();

				if(sizeof($data['category']) == 1){
					$category[] = $data['category'];
				}elseif(sizeof($data['category']) > 1){
					$category = $data['category'];
				}else{
					$category = '';
				}
				
				if($product_id){
					$data_products = array(
						'product_id' => $product_id,
						'model' => $data['model_number'],
						'mpn' => $data['mpn'],
						'name' => $data['title'],
						'description' => $data['description'],
						'manufacturer_id' => 20,
						'price' => $data['price'],
						'category' => $data['category'],
						'stock_status_id' => $stock_status_id,
						'image' => urldecode($fullPath),
						'weight' => $weight,
						'quantity' => $data['quantity'],
						'extra_images' => $extra_images
					);

					echo '<pre>';
					print_r($data_products);
					echo '</pre>';				

					$this->updateProduct($data_products);

				}else{					
					$data_products = array(
						'model' => $data['model_number'],
						'mpn' => $data['mpn'],
						'name' => $data['title'],
						'description' => $data['description'],
						'manufacturer_id' => 20,
						'price' => $data['price'],
						'category' => $data['category'],
						'stock_status_id' => $stock_status_id,
						'image' => urldecode($fullPath),
						'weight' => $weight,
						'quantity' => $data['quantity'],
						'extra_images' => $extra_images
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
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '".$model."' AND teoran = '1'");

		if($query->num_rows){
			$product_id = $query->row['product_id'];
		}else{
			$product_id = 0;
		}

		return $product_id;
	}


	private function addNewProduct($data){

		$this->db->query("INSERT INTO " . DB_PREFIX . "product SET model = '" . $data['model'] . "', image = '" . $this->db->escape($data['image']) . "', manufacturer_id = '" . (isset($data['manufacturer_id']) ? $data['manufacturer_id'] : '') . "', price = '" . $data['price'] . "', quantity = '" . $data['quantity'] . "', stock_status_id = '" . $data['stock_status_id'] . "', status = '1', tax_class_id = '0', teoran = '1', weight = '" . $data['weight'] . "', weight_class_id = '1'");

		$product_id = $this->db->getLastId();

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_description SET product_id = '" . (int)$product_id . "', name = '" . $this->db->escape($data['name']) . "', meta_title = '" . $this->db->escape($data['name']) . "', language_id = '2'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_store SET product_id = '" . (int)$product_id . "', store_id = '0'");
		
		if($data['category']){
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
			foreach ($data['category'] as $key => $value) {
				
				$this->saveCategories($value,$product_id);
			}
		}

		if(!empty($data['extra_images'])){			
						
			foreach ($data['extra_images'] as $extra_images) {
				$temp = explode('/', $extra_images);
				$extra_image_path = 'catalog/products/teoran_extra_photos/'.end(str_replace('%20', '-', $temp));

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . $product_id . "', image = '" . urldecode($extra_image_path) . "'");
			}
		}

		// if($data['options']){
			
			
		// 	$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . $product_id . "', option_id = '15', required = '1'");

		// 	$product_option_id = $this->db->getLastId();

		// 	$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . $product_id . "'");

		// 	foreach ($data['options'] as $key => $options) {

		// 		$value = get_object_vars($options);

		// 		$option_value = $this->db->query("SELECT option_value_id FROM " . DB_PREFIX . "option_value_description WHERE option_id = '15' AND language_id = '2' AND name = '" . $this->db->escape($value['option_value_name']) . "'");

		// 		if($option_value->num_rows > 0){
		// 			$option_value_id = $option_value->row['option_value_id'];
		// 		}else{
		// 			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value SET option_id = '15', sort_order = '0'");

		// 			$option_value_id = $this->db->getLastId();

		// 			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET option_value_id = '" . $option_value_id . "', language_id = '2', option_id = '15', name = '" . $this->db->escape($value['option_value_name']) . "'");
		// 		}

		// 		$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_id = '" . $product_id . "', option_id = '15', product_option_id = '" . $product_option_id . "', option_value_id = '" . $option_value_id . "', quantity = '10', subtract = '1', price = '" . $value['option_value_price'] . "', price_prefix = '" . $value['option_value_price_prefix'] . "'");
								
		// 	}
		// }

		return $product_id;

	}

	private function updateProduct($data){
		$query = $this->db->query("UPDATE " . DB_PREFIX . "product SET image = '" . (isset($data['image']) ? $this->db->escape($data['image']) : '') . "', quantity = '".$data['quantity']."', stock_status_id = '".$data['stock_status_id']."', price = '" . (float)$data['price'] . "', weight = '" . $data['weight'] . "', weight_class_id = '1' WHERE product_id = '" . (int)$data['product_id'] . "' ");


		$this->db->query("UPDATE " . DB_PREFIX . "product_description SET name = '" . $this->db->escape($data['name']) . "', meta_title = '" . $this->db->escape($data['name']) . "', description = '" . $this->db->escape($data['description']) . "' WHERE product_id = '" . (int)$data['product_id'] . "' AND language_id = '2'");

		if($data['category']){
			// delete the category
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$data['product_id'] . "'");
			foreach ($data['category'] as $key => $value) {
				$this->saveCategories($value,$data['product_id']);
			}
		}		


		if(!empty($data['extra_images'])){
			$this->db->query("DELETE FROM " . DB_PREFIX . "product_image WHERE product_id = '" . $data['product_id'] . "'");
							
			foreach ($data['extra_images'] as $extra_images) {
				$temp = explode('/', $extra_images);
				$extra_image_path = 'catalog/products/teoran_extra_photos/'.end(str_replace('%20', '-', $temp));

				$this->db->query("INSERT INTO " . DB_PREFIX . "product_image SET product_id = '" . $data['product_id'] . "', image = '" . urldecode($extra_image_path) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . $data['product_id'] . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . $data['product_id'] . "'");

		// if($data['options']){
			
		// 	$query = $this->db->query("SELECT product_option_id FROM " . DB_PREFIX . "product_option WHERE option_id = '15' AND product_id = '" . $data['product_id'] . "'");

		// 	if($query->num_rows > 0){
		// 		$product_option_id = $query->row['product_option_id'];
		// 	}else{
		// 		$this->db->query("INSERT INTO " . DB_PREFIX . "product_option SET product_id = '" . $data['product_id'] . "', option_id = '15', required = '1'");
		// 		$product_option_id = $this->db->getLastId();
		// 	}

		// 	$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . $data['product_id'] . "'");

		// 	foreach ($data['options'] as $key => $options) {

		// 		$value = get_object_vars($options);

		// 		$option_value = $this->db->query("SELECT option_value_id FROM " . DB_PREFIX . "option_value_description WHERE option_id = '15' AND language_id = '2' AND name = '" . $this->db->escape($value['option_value_name']) . "'");

		// 		if($option_value->num_rows > 0){
		// 			$option_value_id = $option_value->row['option_value_id'];
		// 		}else{
		// 			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value SET option_id = '15', sort_order = '0'");

		// 			$option_value_id = $this->db->getLastId();

		// 			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET option_value_id = '" . $option_value_id . "', language_id = '2', option_id = '15', name = '" . $this->db->escape($value['option_value_name']) . "'");
		// 		}

		// 		$this->db->query("INSERT INTO " . DB_PREFIX . "product_option_value SET product_id = '" . $data['product_id'] . "', option_id = '15', product_option_id = '" . $product_option_id . "', option_value_id = '" . $option_value_id . "', quantity = '10', subtract = '1', price = '" . $value['option_value_price'] . "', price_prefix = '" . $value['option_value_price_prefix'] . "'");
								
		// 	}
		// }

		return 1;
	}


	private function saveCategories($category_chain,$product_id) {

		$category_names = explode("&gt;", $category_chain);
		$categories = array();

		$parent_id   = 0;
		$category_id = 0;

		foreach ($category_names as $ck => $cv) {

			$cv = trim($cv);

			
	
			$category_query = $this->db->query("SELECT c.category_id FROM " . DB_PREFIX . "category_description cd INNER JOIN " . DB_PREFIX . "category c ON (cd.category_id=c.category_id) WHERE language_id = '2' AND TRIM(CONVERT(name using utf8)) LIKE '". $this->db->escape(htmlspecialchars($cv)) . "' AND parent_id = '" . $parent_id . "'");			

			
			if(!$category_query->num_rows){

				$this->db->query("INSERT INTO " . DB_PREFIX . "category SET parent_id = '" . (int)$parent_id . "', top = '1', sort_order = '0', status = '1', date_added = NOW(), date_modified = NOW()");

				//GET LAST ID OF INSERTED PRODUCT
				$category_id = $this->db->getLastId();
				
				$this->db->query("INSERT INTO " . DB_PREFIX . "category_description SET category_id = '" . (int)$category_id . "', language_id = '2', name = '" . $this->db->escape(htmlspecialchars($cv)) . "'");


				$this->insertPaths($category_id, $parent_id);

				$this->db->query("INSERT INTO " . DB_PREFIX . "category_to_store SET category_id = '" . (int)$category_id . "', store_id = '0' ");				
			} else {
				 $result = $category_query->row;
				 $category_id = $result['category_id'];	
			}

			$parent_id = $category_id;
		}

		
		// and then insert the new one
		$this->db->query("INSERT INTO " . DB_PREFIX . "product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");	   
	}


	private function insertPaths($category_id, $parent_id){

		$level = 0;
		$category_path_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

		foreach ($category_path_query->rows as $row) {
			$insert_query = $this->db->query("INSERT INTO " . DB_PREFIX . "category_path SET category_id = '" . (int)$category_id . "', path_id = '" . (int)$row['path_id'] . "', level = '" . (int)$level . "'");				
			$level++;
		}		

		$insert_query = $this->db->query("INSERT INTO " . DB_PREFIX . "category_path SET category_id = '" . (int)$category_id . "', path_id = '" . (int)$category_id . "', level = '" . (int)$level . "'");
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

	private function deleteOld($product_id){		

			$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");
	}			
}
?>