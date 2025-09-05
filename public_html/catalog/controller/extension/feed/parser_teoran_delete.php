<?php 
class ControllerExtensionFeedParserTeoranDelete extends Controller {
	
	public function index() {

		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
		ini_set('max_execution_time', 0);
		ini_set('memory_limit', '4096M');
				
		header('Content-Type: text/html; charset=utf-8');
		 		
	    	
	  	$data_xml = file_get_contents("https://teoran.gr/index.php?route=extension/feed/teoran_feed_separated");

	  	if (!$data_xml){
			exit("Xml file does not exists!");
		}

		$xml = simplexml_load_string($data_xml , "SimpleXMLElement", LIBXML_NOCDATA );

		foreach ($xml->channel->item as $item) {
			$data = get_object_vars($item);

			// get the id of the products who are alreay at the db
			$product_id = $this->getXMLproducts($data['model_number']);			

			// fill an array with the id of the products who are in xml 				
			$xml_ids[] = $product_id;	
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
		$query = $this->db->query("SELECT product_id FROM " .  DB_PREFIX . "product WHERE teoran = '1'");

		foreach ($query->rows as $row) {
			$db_ids[] = $row['product_id'];
		}

		return $db_ids;
	}


	private function getXMLproducts($model){
		$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE model = '" . $model . "' AND teoran = '1'");

		if($query->num_rows){
			$product_id = $query->row['product_id'];
		}else{
			$product_id = 0;
		}

		return $product_id;
	}

	private function deleteOld($product_id){		

		$this->db->query("DELETE FROM " .  DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("DELETE FROM " .  DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("DELETE FROM " .  DB_PREFIX . "product_to_store WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("DELETE FROM " .  DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("DELETE FROM " .  DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("DELETE FROM " .  DB_PREFIX . "product_option WHERE product_id = '" . (int)$product_id . "'");

		$this->db->query("DELETE FROM " .  DB_PREFIX . "product_option_value WHERE product_id = '" . (int)$product_id . "'");

	}			
}
?>