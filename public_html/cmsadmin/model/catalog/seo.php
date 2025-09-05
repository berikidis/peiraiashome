<?php
class ModelCatalogSeo extends Model {
	public function updateSeoData($seo_data,$exclude_products) {
		$products_id = array();		

		if($seo_data['subcategories'] == 1){

			$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$seo_data['category_id'] . "'");

			foreach ($query->rows as $categories) {

				$products = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$categories['category_id'] . "'");
				foreach ($products->rows as $value) {

					if(!in_array($value['product_id'], $exclude_products)){


						$meta_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");



						if($seo_data['meta_description'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['meta_description'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_description` = CONCAT('".$seo_data['keyword']." - ',`meta_description`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}

						if($seo_data['smp_title'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['meta_title'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_title` = CONCAT('".$seo_data['keyword']." - ',`meta_title`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}	
						}

						if($seo_data['smp_h1_title'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['smp_h1_title'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_h1_title` = CONCAT('".$seo_data['keyword']." - ',`smp_h1_title`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}

						if($seo_data['smp_alt_images'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['smp_alt_images'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_alt_images` = CONCAT('".$seo_data['keyword']." - ',`smp_alt_images`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}

						if($seo_data['smp_title_images'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['smp_title_images'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET  `smp_title_images` = CONCAT('".$seo_data['keyword']." - ',`smp_title_images`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}

						if($seo_data['description'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['description'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `description` = CONCAT('&lt;h2&gt;&lt;em&gt;&lt;strong&gt;','".$seo_data['keyword']."', '&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;' ,`description`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}

						if($seo_data['tag'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['tag'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `tag` = CONCAT('".$seo_data['keyword'].",',`tag`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}	
						}


						if($seo_data['seo_url']){
							$url_query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . $value['product_id'] .  "' AND smp_language_id = '" . $seo_data['language_id'] . "'");

							if($url_query->num_rows > 0){
								if(strpos($url_query->row['keyword'],$seo_data['seo_url'].'-') === false){
								
									$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET keyword = CONCAT('".$seo_data['seo_url']."-',`keyword`) WHERE query = 'product_id=" . $value['product_id'] .  "' AND smp_language_id = '" . $seo_data['language_id'] . "'");
								}							
							}
						}
					}
				}
			}
		}else{
			$products = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$seo_data['category_id'] . "'");

			if($products->num_rows > 0){
				foreach ($products->rows as $value) {

					if(!in_array($value['product_id'], $exclude_products)){

						$meta_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
						
						if($seo_data['meta_description'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['meta_description'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_description` = CONCAT('".$seo_data['keyword']." - ',`meta_description`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}

						if($seo_data['smp_title'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['meta_title'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_title` = CONCAT('".$seo_data['keyword']." - ',`meta_title`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}	
						}

						if($seo_data['smp_h1_title'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['smp_h1_title'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_h1_title` = CONCAT('".$seo_data['keyword']." - ',`smp_h1_title`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}	
						}

						if($seo_data['smp_alt_images'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['smp_alt_images'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_alt_images` = CONCAT('".$seo_data['keyword']." - ',`smp_alt_images`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}

						if($seo_data['smp_title_images'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['smp_title_images'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET  `smp_title_images` = CONCAT('".$seo_data['keyword']." - ',`smp_title_images`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}

						if($seo_data['description'] && !empty($seo_data['keyword'])){
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['description'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `description` = CONCAT('&lt;h2&gt;&lt;em&gt;&lt;strong&gt;','".$seo_data['keyword']."', '&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;' ,`description`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}	
						}

						if($seo_data['tag'] && !empty($seo_data['keyword'])){							
							if($meta_query->num_rows > 0){
								if(strpos($meta_query->row['tag'],$seo_data['keyword']) === false){
									$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `tag` = CONCAT('".$seo_data['keyword'].",',`tag`) WHERE product_id = '" . (int)$value['product_id'] . "' AND language_id = '".$seo_data['language_id']."'");
								}
							}
						}


						if($seo_data['seo_url']){
							$url_query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . $value['product_id'] .  "' AND smp_language_id = '" . $seo_data['language_id'] . "'");

						
							if($url_query->num_rows > 0){
								if(strpos($url_query->row['keyword'],$seo_data['seo_url'].'-') === false){
								
									$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET keyword = CONCAT('".$seo_data['seo_url']."-',`keyword`) WHERE query = 'product_id=" . $value['product_id'] .  "' AND smp_language_id = '" . $seo_data['language_id'] . "'");
								}							
							}
						}
					}
				}
			}
		}
		return 1;
	}

	public function deleteSeoData($seo_data,$exclude_products) {
		$products_id = array();
				
		if($seo_data['subcategories'] == 1){

			$query = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "category_path WHERE path_id = '" . (int)$seo_data['category_id'] . "'");

			foreach ($query->rows as $categories) {

				$products = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$categories['category_id'] . "'");
				foreach ($products->rows as $value) {
						
					if(!in_array($value['product_id'], $exclude_products)){	
						if($seo_data['meta_description']){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_description` = REPLACE(`meta_description`, '".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");
						}

						if($seo_data['smp_title'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_title` = REPLACE(`meta_title`,'".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['smp_h1_title'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_h1_title` = REPLACE(`smp_h1_title`, '".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['smp_alt_images'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_alt_images` = REPLACE(`smp_alt_images`, '".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['smp_title_images'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_title_images` = REPLACE(`smp_title_images`, '".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");
						}

						if($seo_data['description'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `description` = REPLACE(`description`, '&lt;h2&gt;&lt;em&gt;&lt;strong&gt;".$seo_data['keyword']."&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;' , '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['tag'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `tag` = REPLACE(`tag`, '".$seo_data['keyword'].",', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['seo_url']){
							$url_query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . $value['product_id'] .  "' AND smp_language_id = '" . $seo_data['language_id'] . "'");

							if($url_query->num_rows > 0){
								if(strpos($url_query->row['keyword'],$seo_data['seo_url'].'-') !== false){
									$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET keyword = REPLACE(`keyword`,'".$seo_data['seo_url']."-', '') WHERE `query` = 'product_id=" . $value['product_id'] .  "' AND `smp_language_id` = '" . $seo_data['language_id'] . "'");
								}							
							}
						}
					}
				}
			}
		}else{


			$products = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$seo_data['category_id'] . "'");

			if($products->num_rows > 0){
				foreach ($products->rows as $value) {

					if(!in_array($value['product_id'], $exclude_products)){		
					
						if($seo_data['meta_description'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_description` = REPLACE(`meta_description`, '".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");
						}

						if($seo_data['smp_title'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `meta_title` = REPLACE(`meta_title`,'".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['smp_h1_title'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_h1_title` = REPLACE(`smp_h1_title`, '".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['smp_alt_images'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_alt_images` = REPLACE(`smp_alt_images`, '".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['smp_title_images'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `smp_title_images` = REPLACE(`smp_title_images`, '".$seo_data['keyword']." - ', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");
						}

						if($seo_data['description'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `description` = REPLACE(`description`, '&lt;h2&gt;&lt;em&gt;&lt;strong&gt;".$seo_data['keyword']."&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;' , '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}

						if($seo_data['tag'] && !empty($seo_data['keyword'])){
							$this->db->query("UPDATE `" . DB_PREFIX . "product_description` SET `tag` = REPLACE(`tag`, '".$seo_data['keyword'].",', '') WHERE `product_id` = '" . (int)$value['product_id'] . "' AND `language_id` = '" . $seo_data['language_id'] . "'");	
						}
					
						if($seo_data['seo_url']){
							$url_query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'product_id=" . $value['product_id'] .  "' AND smp_language_id = '" . $seo_data['language_id'] . "'");						

							if($url_query->num_rows > 0){
							
								if(strpos($url_query->row['keyword'],$seo_data['seo_url'].'-') !== false){
									$this->db->query("UPDATE " . DB_PREFIX . "url_alias SET keyword = REPLACE(`keyword`,'".$seo_data['seo_url']."-', '') WHERE `query` = 'product_id=" . $value['product_id'] .  "' AND `smp_language_id` = '" . $seo_data['language_id'] . "'");
								}							
							}
						}
					}
				}
			}
		}
		return 1;
	}
}

?>