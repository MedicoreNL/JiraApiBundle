<?php
namespace JiraApiBundle\Tests;

class JsonResponseMock
{
    protected $response;

    public function __construct($jsonFile)
    {
        $file = file_get_contents($jsonFile);
        $this->response = $file;
    }

    public function json()
    {
        $data = json_decode((string) $this->response, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }

        return $data === null ? array() : $data;
    }
}
