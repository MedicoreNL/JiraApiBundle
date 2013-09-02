<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Base class that contain common features that is needed by other classes.
 */
abstract class AbstractService
{
    /**
     *
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * Constructor.
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
     * Get response as an array, returns false if no result.
     *
     * @param string $url
     *
     * @return array
     */
    protected function getResponseAsArray($url)
    {
        $request = $this->client->get($url);

        try  {
            $response = $request->send();
        } catch (BadResponseException $e) {
            return false;
        }

        $result = $response->json();

        if ($this->resultHasData($result)) {
            return $result;
        }

        return false;
    }

    /**
     * Indicates whether the current result page contains data.
     *
     * @param $result
     *
     * @return bool
     */
    private function resultHasData($result)
    {
        if (array_key_exists('errorMessages', $result) || array_key_exists('errors', $result)) {
            return false;
        }

        if (0 === count($result)) {
            return false;
        }

        return true;
    }
}
