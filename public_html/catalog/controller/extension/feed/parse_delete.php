<?php 
class ControllerExtensionFeedParseDelete extends Controller {
	
	public function index() {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '4096M');
				
		header('Content-Type: text/html; charset=utf-8');

		$files[0] = 'xml_feeds/SUMMER_2020.xml';
		$files[1] = 'xml_feeds/ΕΚΤΟΣ_ΚΑΤΑΛΟΓΟΥ.xml';
		
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


				// fill an array with the id of the products who are in xml 				
				$xml_ids[] = $product_id;
			}
		}
		
		$db_ids = $this->getAllXMLproducts();

		$unique_ids = array_diff($db_ids, $xml_ids);

		foreach ($unique_ids as $unique) {
			$this->deleteOld($unique);			
		}

		$message = "Xml Parser completed successfully at " . date("d/m/Y H:i") . "\n";

		// mail('s.ntaskas@icop.gr',"Xml Delete Parse",$message);

		echo $message;
	
	}

	private function getAllXMLproducts(){
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE xml_flag = '1'");

		foreach ($query->rows as $row) {
			$db_ids[] = $row['product_id'];
		}

		return $db_ids;
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

	private function deleteOld($product_id){		

			$this->db->query("DELETE FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

			$this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "'");

	}			
}
?>