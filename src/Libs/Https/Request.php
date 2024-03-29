<?php
namespace Libs\Https;

class Request
{
    private static Request $instance;
    private array $headers;

    public function __construct()
    {
        $this->headers = getallheaders();
    }

    public static function instance(): Request
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function methodType(): string
    {
        return $this->post('_method', default: $_SERVER['REQUEST_METHOD']);
    }

    public function get(string $name, $default = null)
    {
        return $_GET[$name] ?? $default;
    }

    public function post($name, $default = null)
    {
        return $_POST[$name] ?? $default;
    }

    public function header($name = null)
    {
        if (empty($name))
            return getallheaders();
        return $this->headers[$name] ?? '';
    }

    public function host(): string
    {
        return $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];
    }

    public function requestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function baseUrl(): string
    {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $request_uri = $this->requestUri();

        if (0 === strpos($request_uri, $script_name))
            return $script_name;
        else if (0 === strpos($request_uri, dirname($script_name)))
            return rtrim(dirname($script_name));

        return '';
    }

    public function pathInfo(): string
    {
        $base_url = $this->baseUrl();
        $request_uri = $this->requestUri();

        $pos = strpos($request_uri, '?');
        if (false !== $pos)
            $request_uri = substr($request_uri, 0, $pos);

        $path_info = (string)substr($request_uri, strlen($base_url));

        return $path_info;
    }
}