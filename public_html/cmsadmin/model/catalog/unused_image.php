<?php
class ModelCatalogUnusedImage extends Model {

	private $debug_log = false;

	public function __construct($registry) {
		parent::__construct($registry);

		$sql = "SHOW TABLES LIKE '".DB_PREFIX."unused_image'";
		$query = $this->db->query( $sql );
		if ($query->rows) {
			return;
		}

		$sql  = "CREATE TABLE `".DB_PREFIX."unused_image` (";
		$sql .= "  `unused_image_id` int(11) NOT NULL,";
		$sql .= "  `file` varchar(512) NOT NULL";
		$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$this->db->query( $sql );

		$sql  = "ALTER TABLE `".DB_PREFIX."unused_image`";
		$sql .= "  ADD PRIMARY KEY (`unused_image_id`);";
		$this->db->query( $sql );

		$sql  = "ALTER TABLE `".DB_PREFIX."unused_image`";
		$sql .= "  MODIFY `unused_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
		$this->db->query( $sql );
	}


	public function getImages($data = array()) {
		if (empty($this->session->data['unused_image_scanned'])) {
			return array();
		}

		// extract filter data
		$filter_name = (isset($data['filter_name'])) ? $data['filter_name'] : '';
		$sort = (isset($data['sort'])) ? $data['sort'] : 'name';
		$order = (isset($data['order'])) ? $data['order'] : 'ASC';
		$start = (isset($data['start'])) ? $data['start'] : 0;
		$limit = (isset($data['limit'])) ? $data['limit'] : PHP_INT_MAX;

		// get orphaned images from a DB table which was created with refreshed data from a previous scan
		$sql = "SELECT `file` AS `name`, 0 AS selected FROM `".DB_PREFIX."unused_image` ";
		if ($filter_name != '') {
			$sql .= "WHERE `file` LIKE '%".$this->db->escape($filter_name)."%' ";
		}
		if (($sort != 'name') || ($order != 'ASC')) {
			$sql .= "ORDER BY `$sort` $order ";
		}
		$sql .= "LIMIT $limit OFFSET $start";
		$query = $this->db->query( $sql );

		return $query->rows;
	}
	
	
	public function scanImages() {
		$this->debugLog( "ModelCatalogUnusedImage::scanImages: entered" );
		
		// get DB table names
		$tables_query = $this->db->query( "SHOW TABLES" );
		$tables = array();
		foreach ($tables_query->rows as $row) {
			$values = array_values($row);
			$tables[] = $values[0];
		}
		
		// get all image names from tables which have the 'image' field
		$images_in_database = array();
		$sql  = "";
		$first = TRUE;
		$table_querys = array();
		foreach ($tables as $table) {
			$table_query = $this->db->query( "DESCRIBE `$table`" );
			foreach ($table_query->rows as $row) {
				if ($row['Field']=='image') {
					if (!$first) {
						$sql .= "  UNION ";
					}
					$first = FALSE;
					$sql .= "  SELECT image FROM `$table` ";
					break;
				}
			}
			$table_querys[$table] = $table_query;
		}
		if (!$first) {
			$sql = "SELECT DISTINCT(i.image) FROM ( " . $sql . ") AS i WHERE image != ''";
			$image_query = $this->db->query( $sql );
			foreach ($image_query->rows as $row) {
				$images_in_database[] = $row['image'];
			}
		}
		$this->debugLog( "ModelCatalogUnusedImage::scanImages: count(images_in_database)='".count($images_in_database)."'");
		
		// get more images from tables which have the 'description' field
		foreach ($table_querys as $table=>$table_query) {
			foreach ($table_query->rows as $row) {
				if ($row['Field']=='description') {
					$description_query = $this->db->query( "SELECT description FROM `$table` WHERE description LIKE '%image/catalog%';" );
					foreach ($description_query->rows as $description_row) {
						$this->addImagesFromDescription( $images_in_database, $description_row['description'] );
					}
				}
			}
		}
		$this->debugLog( "ModelCatalogUnusedImage::scanImages: added more images from tables which have the 'description' field, count(images_in_database)='".count($images_in_database)."'");
		
		// get more images from the 'setting' table
		$sql = "SELECT value AS image FROM `".DB_PREFIX."setting` WHERE value LIKE 'catalog/%' AND (value LIKE '%.png' OR value LIKE '%.jpg' OR value LIKE '%.gif' OR value LIKE '%.svg' OR value LIKE '%.ico')";
		$setting_query = $this->db->query( $sql );
		foreach ($setting_query->rows as $row) {
			if (!in_array( $row['image'], $images_in_database )) {
				$images_in_database[] = $row['image'];
			}
		}
		$this->debugLog( "ModelCatalogUnusedImage::scanImages: added more images from the 'setting' table, count(images_in_database)='".count($images_in_database)."'");

		// get more images from the 'module' table
		$sql = "SELECT setting FROM `".DB_PREFIX."module`";
		$module_query = $this->db->query( $sql );
		foreach ($module_query->rows as $row) {
			if (version_compare(VERSION,'2.1.','>=')) {
				$array = json_decode( $row['setting'], true );
			} else {
				$array = unserialize( $row['setting'] );
			}
			if (is_array($array)) {
				$this->scanArrays( $images_in_database, $array );
			}
		}
		$this->debugLog( "ModelCatalogUnusedImage::scanImages: added more images from the 'module' table, count(images_in_database)='".count($images_in_database)."'");

		$this->debugLog("ModelCatalogUnusedImage::scanImages: Found ".count($images_in_database)." images in database" );
		$this->debugLog("ModelCatalogUnusedImage::scanImages: Sorting images from database" );

		// remove leading forward slashes from DB image entries (a bug in OpenCart or in some 3rd party extensions)
		foreach ($images_in_database as $key=>$val) {
			if ($this->startsWith($val,'//catalog')) {
				$images_in_database[$key] = substr($val,2);
			} else if ($this->startsWith($val,'/catalog')) {
				$images_in_database[$key] = substr($val,1);
			}
		}

		sort($images_in_database,SORT_STRING);
		$this->debugLog("ModelCatalogUnusedImage::scanImages: Done sorting images from database" );
		
		// get image names from the 'image/catalog' folder
		$images_on_disk =& $this->scanImageFolders();

		// stay away from anything to do with Journal3
		$adjusted_list = array();
		foreach ($images_on_disk as $val) {
			if ($this->startsWith($val,'catalog/journal3')) {
				continue;
			}
			$adjusted_list[] = $val;
		}
		$images_on_disk = $adjusted_list;

		// identify orphaned images
		$this->debugLog("ModelCatalogUnusedImage::scanImages: begin finding orphaned images" );
		$orphans = array_diff($images_on_disk,$images_in_database);
		$this->debugLog("ModelCatalogUnusedImage::scanImages: done finding orphaned images" );

		// store list of orphaned images names into a DB table
		$sql = "TRUNCATE TABLE `".DB_PREFIX."unused_image`";
		$this->db->query( $sql );
		$sql = '';
		$i = 0;
		foreach ($orphans as $orphan) {
			if (($i % 100) == 0) {
				if ($i > 0) {
					$sql = "INSERT INTO `".DB_PREFIX."unused_image` (`file`) VALUES " . $sql . ';';
					$this->db->query( $sql );
					$sql = '';
				}
				$sql .= "('".$this->db->escape($orphan)."')";
			} else {
				$sql .= ",('".$this->db->escape($orphan)."')";
			}
			$i += 1;
		}
		if ($sql != '') {
			$sql = "INSERT INTO `".DB_PREFIX."unused_image` (`file`) VALUES " . $sql . ';';
			$this->db->query( $sql );
		}

		$this->session->data['unused_image_scanned'] = 1;
	}


	protected function scanArrays( &$images, $elems ) {
		if (is_array($elems)) {
			foreach ($elems as $elem) {
				$this->scanArrays( $images, $elem );
			}
		} else {
			$this->addImagesFromDescription( $images, $elems );
		}
	}


	protected function addImagesFromDescription( &$images, $description ) {
		$description = html_entity_decode( $description );
		$k = strlen( $description );
		$i = 0;
		while ($i < $k) {
			$j = strpos( $description, 'src="', $i );
			if ($j===FALSE) {
				break;
			}
			$j += strlen( 'src="' );
			$i = $j;
			while (($i < $k) && ($description[$i] != '"')) {
				$i += 1;
			}
			$image = substr( $description, $j, $i-$j );
			$https_image = HTTPS_CATALOG.'image/';
			$http_image = HTTP_CATALOG.'image/';
			if ($this->startsWith( $image, $https_image )) {
				$image = substr( $image, strlen($https_image) );
			} else if ($this->startsWith( $image, $http_image )) {
				$image = substr( $image, strlen($http_image) );
			} else if ($this->startsWith($image,'image/')) {
				$image = substr( $image, strlen('image/') );
			} else if ($this->startsWith($image,'/image/')) {
				$image = substr( $image, strlen('/image/'));
			}
			if ($this->startsWith( $image, 'catalog/' )) {
				if (!in_array( $image, $images )) {
					$images[] = $image;
				}
			}
		}
	}


	protected function startsWith( $haystack, $needle ) {
		if (strlen( $haystack ) < strlen( $needle )) {
			return FALSE;
		}
		return (substr( $haystack, 0, strlen($needle) ) == $needle);
	}


	protected function endsWith( $haystack, $needle ) {
		if (strlen( $haystack ) < strlen( $needle )) {
			return FALSE;
		}
		return (substr( $haystack, strlen($haystack)-strlen($needle), strlen($needle) ) == $needle);
	}


	public function getTotalImages($data = array()) {
		if (empty($this->session->data['unused_image_scanned'])) {
			return 0;
		}
		$filter_name = (isset($data['filter_name'])) ? $data['filter_name'] : '';
		$sql = "SELECT count(*) AS total FROM `".DB_PREFIX."unused_image` ";
		if ($filter_name != '') {
			$sql .= "WHERE `file` LIKE '%".$this->db->escape($filter_name)."%' ";
		}
		$query = $this->db->query( $sql );
		return isset($query->row['total']) ? $query->row['total'] : 0;
	}


	protected function &scanImageFolders() {
		$this->debugLog("ModelCatalogUnusedImage::scanImageFolders: calling get_dir_iterative");
		$images =& $this->get_dir_iterative( 'catalog' );
		$this->debugLog("ModelCatalogUnusedImage::scanImageFolders: done get_dir_iterative");
		$this->debugLog("ModelCatalogUnusedImage::scanImageFolders: sorting images");
		sort($images,SORT_STRING);
		$this->debugLog("ModelCatalogUnusedImage::scanImageFolders: done sorting images");
		$k = count($images);
		$this->debugLog("ModelCatalogUnusedImage::scanImageFolders: found $k images from image folders");
		return $images;
	}


	protected function &get_dir_iterative($dir = '.', $exclude = array( 'cgi-bin', '.', '..' ))
	{
		$images = array();
		$exclude = array_flip($exclude);
		if(!is_dir(DIR_IMAGE.$dir))
		{
			return;
		}
		
		$dh = opendir(DIR_IMAGE.$dir);
		
		if(!$dh)
		{
			return;
		}

		$stack = array($dh);
		$level = 0;

		while(count($stack))
		{
			if(false !== ( $file = readdir( $stack[0] ) ) )
			{
				if(!isset($exclude[$file]))
				{
					$prefix = str_repeat(' ', $level * 4);
//					$this->debugLog("ModelCatalogUnusedImage::get_dir_iterative: $dir/$file");
					if(is_dir(DIR_IMAGE.$dir . '/' . $file))
					{
						$this->debugLog("ModelCatalogUnusedImage::get_dir_iterative: $dir/$file");
						$dh = opendir(DIR_IMAGE.$dir . '/' . $file);
						if($dh)
						{
							array_unshift($stack, $dh);
							++$level;
							$dir .= '/'.$file;
						}
					}
					else 
					{
						if ($this->endsWith(strtolower($file),'.png') || $this->endsWith(strtolower($file),'.jpg') || $this->endsWith(strtolower($file),'.gif') || $this->endsWith(strtolower($file),'.svg') || $this->endsWith(strtolower($file),'.ico')) {
							$images[] = $dir.'/'.$file;
						}
//						$this->debugLog("ModelCatalogUnusedImage::get_dir_iterative: $dir/$file");
					}
				}
			}
			else 
			{
				closedir(array_shift($stack));
				$dirs = explode('/',$dir);
				array_pop($dirs);
				$dir = implode('/',$dirs);
				--$level;
			}
		}
		return $images;
	}  


	public function deleteUnusedImage($image) {
		if (is_file( DIR_IMAGE . $image )) {
			unlink( DIR_IMAGE . $image );
			$sql = "DELETE FROM `".DB_PREFIX."unused_image` WHERE `file`='".$this->db->escape($image)."'";
			$this->db->query( $sql );
		}
	}


	public function clearCache($dir, $level=0 ) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != ".." && (!($object=="index.html" && $level==0))) {
					if (filetype($dir . "/" . $object) == "dir") {
						$this->clearCache($dir . "/" . $object,$level+1); 
					} else {
						unlink($dir . "/" . $object);
					}
				}
			}
			reset($objects);
			if ($level>0) {
				rmdir($dir);
			}
		}
	}


	protected function debugLog($msg) {
		if ($this->debug_log) {
			$this->log->write($msg);
		}
	}
}
?>
