<?php
class ModelExtensionFeedSkroutz extends Model {

public function getProducts() {

		$sql = "SELECT p.product_id, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

		$sql .= ", p.price, p.tax_class_id, p.quantity, p.weight, p.mpn, p.ean, p.stock_status_id, p.manufacturer_id, pd.name, MAX(pc.category_id) as category_id, p.image, pd.description";

		$sql .= " FROM " . DB_PREFIX . "product p";
		
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON p.product_id=pd.product_id AND pd.language_id=" . (int)$this->config->get('config_language_id');
		$sql .= " LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON p.product_id=p2s.product_id AND p2s.store_id=" . (int)$this->config->get('config_store_id');
		$sql .= " INNER JOIN " . DB_PREFIX . "product_to_category pc ON p.product_id=pc.product_id";	
		$sql .= " INNER JOIN " . DB_PREFIX . "category c ON c.category_id=pc.category_id AND c.status=1";

		$sql .= " WHERE p.status=1 AND p.date_available <= NOW()";
		$sql .= " AND p.stock_status_id IN (6, 7, 9)";
		
		// exclude certain suppliers
		$sql .= " AND p.supplier_id NOT IN (15,16,17)";

		$sql .= " GROUP BY p.product_id";
		$sql .= " ORDER BY p.product_id";
		
		$query = $this->db->query($sql);

		return $query->rows;
	}
   
	public function getCategories() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE language_id=" . (int)$this->config->get('config_language_id'));

		return $query->rows;
    }

	public function getCategoriesPath() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_path ORDER BY category_id, level");

		return $query->rows;
    }

	public function getManufacturers() {
		$query = $this->db->query("SELECT manufacturer_id, name FROM " . DB_PREFIX . "manufacturer");

		return $query->rows;
    }

	public function getStockStatuses() {
		$query = $this->db->query("SELECT stock_status_id, name FROM " . DB_PREFIX . "stock_status WHERE language_id=" . (int)$this->config->get('config_language_id'));

		return $query->rows;
    }

	public function getProductOptions($option_id) {
		$query = $this->db->query("SELECT pov.product_id, GROUP_CONCAT(ovd.name) options FROM " . DB_PREFIX . "product_option_value pov INNER JOIN " . DB_PREFIX . "option_value_description ovd ON ovd.option_value_id=pov.option_value_id INNER JOIN " . DB_PREFIX . "product p ON p.product_id=pov.product_id AND p.status=1 WHERE pov.option_id=" . $option_id . " AND pov.quantity > 0 AND ovd.language_id=" . (int)$this->config->get('config_language_id') . " GROUP BY pov.product_id");

		return $query->rows;
	}

	public function getProductAttributes($attribute_id) {
		$query = $this->db->query("SELECT product_id, `text` AS attributes FROM " . DB_PREFIX . "product_attribute WHERE attribute_id=" . $attribute_id . " AND `text`<>'' AND language_id=" . (int)$this->config->get('config_language_id'));

		return $query->rows;
	}

}
