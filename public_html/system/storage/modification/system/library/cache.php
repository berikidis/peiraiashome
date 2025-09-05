<?php
class Cache {
	private $adaptor;

	public function __construct($adaptor, $expire = 3600) {
		$class = 'Cache\\' . $adaptor;

		if (class_exists($class)) {
			$this->adaptor = new $class($expire);
		} else {
			throw new \Exception('Error: Could not load cache adaptor ' . $adaptor . ' cache!');
		}
	}
	
	public function get($key) {
		return $this->adaptor->get($key);
	}

	public function set($key, $value) {
		return $this->adaptor->set($key, $value);
	}

	public function delete($key) {

            // Journal Theme Modification
            if (is_file(DIR_SYSTEM . 'library/journal3/vendor/SuperCache/SuperCache.php')) {
                require_once DIR_SYSTEM . 'library/journal3/vendor/SuperCache/SuperCache.php';

			    \SuperCache\SuperCache::clearAll();
            }
		    // End Journal Theme Modification
            
		return $this->adaptor->delete($key);
	}
}
