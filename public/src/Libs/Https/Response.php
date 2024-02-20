<?php
namespace public\src\Libs\Https;

class Response
{
    private array $http_headers;

    public function __construct(
        private string $content = "",
        private int $status_code = Status::HTTP_200_OK,
        private string $status_text = '')
    {
        $this->status_text = empty($this->status_text) ? Status::text($this->status_code) : $this->status_text;
        $this->http_headers = array();
    }

    public function send()
    {
        header('HTTP/1.1 ' . $this->status_code . ' ' . $this->status_text);

        foreach ($this->http_headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo $this->content;
    }

    public function setHttpHeaders($name, $value)
    {
        $this->http_headers[$name] = $value;
    }

    public function statusCode()
    {
        return $this->status_code;
    }

    public function statusText()
    {
        return $this->status_text;
    }

    public static function redirect($location){
        $response = new self(content: "", status_code: Status::HTTP_301_MOVED_PERMANENTLY);
        $response->setHttpHeaders('Location', $location);
        return $response;
    }
}