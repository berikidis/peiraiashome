<?php
final class Front {
	protected $registry;
	protected $pre_action = array();
	protected $error;

	/* Journal2 Theme modification */
	public static $IS_INSTALLER = false;
	public static $IS_JOURNAL   = false;
	public static $IS_OC2       = false;
	public static $IS_ADMIN     = false;
	/* End of Journal2 Theme modification */

	public function __construct($registry) {
		$this->registry = $registry;
	}

	public function addPreAction($pre_action) {
		$this->pre_action[] = $pre_action;
	}

	public function dispatch($action, $error) {
		$this->error = $error;

		foreach ($this->pre_action as $pre_action) {
			$result = $this->execute($pre_action);

			if ($result) {
				$action = $result;

				break;
			}
		}

		/* Journal2 Theme modification */
		if (defined('HTTP_OPENCART')) {
			self::$IS_INSTALLER = true;
		} else if (defined('VERSION')) {
			global $config;
			self::$IS_OC2 = version_compare(VERSION, '2', '>=');
			if (file_exists(DIR_APPLICATION . 'model/journal2/journal2.php')) {
				require_once DIR_APPLICATION . 'model/journal2/journal2.php';
			}
			self::$IS_ADMIN = defined('JOURNAL_IS_ADMIN');
			
            self::$IS_JOURNAL = ($config->get('config_theme') === 'theme_default' || $config->get('config_theme') === 'default') && ($config->get('config_template') === 'journal2' || $config->get('theme_default_directory') === 'journal2');
            
		}

		require_once(DIR_SYSTEM . 'journal2/startup.php');
		/* End of Journal2 Theme modification */


            // Journal Theme Modification
            define('JOURNAL3_INSTALLED', true);

            if (is_file(DIR_SYSTEM . 'library/journal3/build.php')) {
                require_once DIR_SYSTEM . 'library/journal3/build.php';
            }

            if (is_file(DIR_SYSTEM . 'library/journal3/vendor/__autoload.php')) {
                require_once DIR_SYSTEM . 'library/journal3/vendor/__autoload.php';
            }

            if (version_compare(phpversion(), '7.1', '>=') && is_file(DIR_SYSTEM . 'library/journal3/vendor-composer/autoload.php')) {
                require_once DIR_SYSTEM . 'library/journal3/vendor-composer/autoload.php';
            }

            $env = DIR_SYSTEM . '../.env';

			if (is_file($env)) {
				$lines = file($env);

				foreach ($lines as $line) {
					$line = trim($line);

					if ($line[0] === '#') {
						continue;
					}

					$line = explode('=', $line);

					if (count($line) === 2) {
					    $value = trim($line[1]);

					    if ($value === 'true') {
                            $value = true;
					    }

					    if ($value === 'false') {
                            $value = false;
					    }

						define(trim($line[0]), $value);
					}
				}
			}

			if (!defined('JOURNAL3_ENV')) {
			    define('JOURNAL3_ENV', 'production');
			}

			if (!defined('JOURNAL3_CACHE')) {
			    define('JOURNAL3_CACHE', true);
			}

			if (defined('SENTRY_DSN') && SENTRY_DSN && function_exists('Sentry\init')) {
			    Sentry\init(array(
                    'dsn' => SENTRY_DSN
                ));
			}

            $this->execute(new Action('journal3/startup'));
		    // End Journal Theme Modification
            
		while ($action) {
			$action = $this->execute($action);
		}
	}

	private function execute($action) {
	    // oc22 fix
        if (defined('VERSION') && version_compare(VERSION, '2.2', '>=')) {
            $result = $action->execute($this->registry);

            if ($result instanceof Action) {
                return $result;
            }

            if ($result instanceof Exception) {
                $action = $this->error;

                $this->error = null;

                return $action;
            }

            return;
        }

		if (method_exists($action, 'getFile')) {
			if (file_exists($action->getFile())) {
				require_once($action->getFile());

				$class = $action->getClass();

				$controller = new $class($this->registry);

				if (is_callable(array($controller, $action->getMethod()))) {
					$action = call_user_func_array(array($controller, $action->getMethod()), $action->getArgs());
				} else {
					$action = $this->error;

					$this->error = '';
				}
			} else {
				$action = $this->error;

				$this->error = '';
			}
		} else {
			$result = $action->execute($this->registry);

			if (is_object($result)) {
				$action = $result;
			} elseif ($result === false) {
				$action = $this->error;

				$this->error = '';
			} else {
				$action = false;
			}
		}

		return $action;
	}
}
?>