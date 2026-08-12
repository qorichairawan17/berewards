<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Loader
 * Core Loader Extension for CodeIgniter 3.
 * Enables loading service files exclusively from application/services/ via $this->load->library() or $this->load->service().
 */
class MY_Loader extends CI_Loader {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Override library loader method to seamlessly check application/services/ first.
     * Allows autoloading or manual loading of service classes from application/services/.
     *
     * @param string|array $library Library or Service class name(s)
     * @param array|null   $params  Optional constructor parameters
     * @param string|null   $object_name Optional property name on CI Controller
     * @return MY_Loader
     */
    public function library($library, $params = NULL, $object_name = NULL)
    {
        if (is_array($library)) {
            foreach ($library as $key => $value) {
                if (is_int($key)) {
                    $this->library($value, $params);
                } else {
                    $this->library($key, $params, $value);
                }
            }
            return $this;
        }

        if (empty($library)) {
            return $this;
        }

        if ($params !== NULL && !is_array($params)) {
            $params = NULL;
        }

        $service_name = strtolower(basename($library));
        $file_name    = ucfirst($service_name);
        $service_file = APPPATH . 'services/' . $file_name . '.php';

        // Check if class file exists in application/services/
        if (file_exists($service_file)) {
            if (!class_exists($file_name, FALSE)) {
                require_once($service_file);
            }

            $CI =& get_instance();
            $property_name = !empty($object_name) ? $object_name : $service_name;

            if (!isset($CI->$property_name)) {
                $CI->$property_name = new $file_name($params);
            }

            // Register in CI loaded classes
            $this->_ci_classes[$property_name] = $file_name;
            return $this;
        }

        // Standard library fallback (system/libraries or application/libraries)
        parent::library($library, $params, $object_name);
        return $this;
    }

    /**
     * Explicit Service Loader Method.
     * Example: $this->load->service('auth_service');
     *
     * @param string|array $service Service name or array of service names
     * @param array|null   $params  Optional constructor parameters
     * @param string|null   $object_name Optional property alias on CI controller
     * @return MY_Loader
     */
    public function service($service, $params = NULL, $object_name = NULL)
    {
        return $this->library($service, $params, $object_name);
    }
}
