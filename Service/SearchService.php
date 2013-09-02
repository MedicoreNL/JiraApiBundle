<?php

namespace JiraApiBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Service class that handles searches.
 */
class SearchService extends AbstractService
{
    /**
     * @var int
     */
    private $start = 0;

    /**
     * @var int
     */
    private $limit = 50;

    /**
     * @var int
     */
    private $size = 0;

    /**
     * Search for issues.
     * 
     * @param array $params
     * 
     * @return boolean|array
     */
    public function getAll($params)
    {
        $url = $this->createUrl('search', $params);

        return $this->getResponseAsArray($url);
    }

    /**
     * Creates and returns a compatible URL.
     *
     * @param string $path
     * @param array  $params
     *
     * @return string
     */
    public function createUrl($path, $params)
    {
        $params = array_merge(
            $params,
            array(
                'startAt'    => $this->start,
                'maxResults' => $this->limit
            )
        );

        $url = parent::createUrl($path, $params);

        $this->start = 0;
        $this->limit = 0;

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
            $this->limit = $result['maxResults'];
            $this->size  = $result['total'];
            $this->start = $result['startAt'];

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

        if (array_key_exists('issues', $result) && count($result['issues']) > 0) {
            return true;
        }

        return false;
    }

    /**
     * Set the result limit.
     *
     * @param integer $limit
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Returns the size of the current result page.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Returns the start of the current result page.
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }
}
