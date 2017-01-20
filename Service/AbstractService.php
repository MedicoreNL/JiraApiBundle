<?php

namespace JiraApiBundle\Service;

use GuzzleHttp\Client;

/**
 * Base class that contains common features needed by other services.
 */
abstract class AbstractService
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $result;

    /**
     * Constructor.
     *
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates and returns a compatible URL.
     *
     * @param string $path
     * @param array  $params
     *
     * @return string
     */
    protected function createUrl($path, array $params = array())
    {
        $paramString = http_build_query($params);

        $url = sprintf('%s?%s', $path, $paramString);

        return $url;
    }

    /**
     * Performs the specified query and stores the result.
     *
     * @param string $url
     *
     * @return bool|array
     */
    protected function performQuery($url)
    {
        $this->response = $this->client->get($url);

        return $this->getResponseAsArray();
    }

    /**
     * Get response as an array.
     *
     * @return array|bool
     */
    private function getResponseAsArray()
    {
        $this->result = \GuzzleHttp\json_decode($this->response->getBody()->getContents());

        if ($this->responseHasErrors()) {
            return false;
        }

        return $this->result;
    }

    /**
     * Indicates whether the response contains errors.
     *
     * @return bool
     */
    private function responseHasErrors()
    {
        return (
            array_key_exists('errorMessages', $this->result) ||
            array_key_exists('errors', $this->result)
        );
    }
}
