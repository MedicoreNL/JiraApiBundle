<?php

namespace JiraApiBundle\Service;

/**
 * Base class that contains common features needed by services with paged results.
 */
abstract class AbstractPagedService extends AbstractService
{
    /**
     * @var int
     */
    protected $start = 0;

    /**
     * @var int
     */
    protected $limit = 50;

    /**
     * Adds the start and limit parameters to each request.
     *
     * {@inheritDoc}
     */
    protected function createUrl($path, array $params = array())
    {
        $params = array_merge(
            array(
                'startAt'    => $this->start,
                'maxResults' => $this->limit
            ),
            $params
        );

        $url = parent::createUrl($path, $params);

        return $url;
    }

    /**
     * Set the start of the current result start.
     *
     * @param $start
     *
     * @return \JiraApiBundle\Service\AbstractPagedService
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Returns the start of the current result page.
     *
     * @return bool|int
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set the result limit.
     *
     * @param integer $limit
     *
     * @return \JiraApiBundle\Service\AbstractPagedService
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Returns the result limit.
     *
     * @return bool|int
     */
    public function getLimit()
    {
        return $this->limit;
    }
}