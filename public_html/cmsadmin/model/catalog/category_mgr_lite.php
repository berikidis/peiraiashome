<?php
class ModelCatalogCategoryMgrLite extends Model {

    public function getChildren($category_id) {
        $query = $this->db->query("SELECT *, (SELECT COUNT(parent_id) FROM " . DB_PREFIX . "category WHERE parent_id = c.category_id) AS children FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) WHERE c.parent_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY c.sort_order, cd.name");
        return $query->rows;
    }
    public function getCategory($category_id) {
        $query = $this->db->query("SELECT * FROM ". DB_PREFIX . "category WHERE category_id = '" . (int)$category_id. "'");
        return $query->row;
    }
}
?>
