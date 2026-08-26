<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Loader
 * Core Loader Extension for CodeIgniter 3.
 * Enables loading services from application/services/ and middlewares from application/middleware/
 * via $this->load->library(), $this->load->service(), and $this->load->middleware().
 */
class MY_Loader extends CI_Loader {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Override library loader method to seamlessly check application/services/ and application/middleware/ first.
     *
     * @param string|array $library Library, Service, or Middleware class name(s)
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

        $clean_name = strtolower(basename($library));
        $file_name  = ucfirst($clean_name);

        // 1. Check if class file exists in application/middleware/
        $middleware_file = APPPATH . 'middleware/' . $file_name . '.php';
        if (file_exists($middleware_file)) {
            if (!class_exists($file_name, FALSE)) {
                require_once($middleware_file);
            }

            $CI =& get_instance();
            $property_name = !empty($object_name) ? $object_name : $clean_name;

            if (!isset($CI->$property_name)) {
                $CI->$property_name = new $file_name($params);
            }

            $this->_ci_classes[$property_name] = $file_name;
            return $this;
        }

        // 2. Check if class file exists in application/services/
        $service_file = APPPATH . 'services/' . $file_name . '.php';
        if (file_exists($service_file)) {
            if (!class_exists($file_name, FALSE)) {
                require_once($service_file);
            }

            $CI =& get_instance();
            $property_name = !empty($object_name) ? $object_name : $clean_name;

            if (!isset($CI->$property_name)) {
                $CI->$property_name = new $file_name($params);
            }

            // Register in CI loaded classes
            $this->_ci_classes[$property_name] = $file_name;
            return $this;
        }

        // 3. Standard library fallback (system/libraries or application/libraries)
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

    /**
     * Explicit Middleware Loader Method.
     * Example: $this->load->middleware('auth_middleware');
     *
     * @param string|array $middleware Middleware name or array of middleware names
     * @param array|null   $params     Optional constructor parameters
     * @param string|null   $object_name Optional property alias on CI controller
     * @return MY_Loader
     */
    public function middleware($middleware, $params = NULL, $object_name = NULL)
    {
        return $this->library($middleware, $params, $object_name);
    }
}
