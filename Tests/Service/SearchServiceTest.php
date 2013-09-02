<?php

namespace JiraApiBundle\Tests\Service;

use JiraApiBundle\Tests\TestCase;
use JiraApiBundle\Service\SearchService;

class SearchServiceTest extends TestCase
{
    public function testSearchServiceGetAll()
    {        
        $jsonFile = __DIR__ . '/../assets/response/search.json';

        $service = new SearchService(
            $this->getClientMock($jsonFile)
        );

        $params = array(
            'jql' => 'id=TD-945'
        );

        $service->setLimit(10);

        $result = $service->getAll($params);

        $this->assertEquals(5, count($result));
        $this->assertEquals($service->getSize(), 1);
        $this->assertEquals($service->getStart(), 0);

    }

    public function testSearchServiceGetAllException()
    {
        $service = new SearchService($this->getClientMockException());

        $result = $service->getAll(array());

        $this->assertEquals(false, $result);
    }

    public function testSearchServiceGetAllNoData()
    {
        $service = new SearchService($this->getClientMockNoData());

        $result = $service->getAll(array());

        $this->assertEquals(false, $result);
    }

    public function testSearchServiceGetAllErrors()
    {
        $service = new SearchService($this->getClientMockErrors());

        $result = $service->getAll(array());

        $this->assertEquals(false, $result);
    }
}
