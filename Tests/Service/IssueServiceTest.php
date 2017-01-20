<?php

namespace JiraApiBundle\Tests\Service;

use JiraApiBundle\Tests\TestCase;
use JiraApiBundle\Service\IssueService;

class IssueServiceTest extends TestCase
{
    public function testIssueServiceGet()
    {        
        $jsonFile = __DIR__ . '/../assets/response/issue.json';

        $service = new IssueService(
            $this->getClientMock($jsonFile)
        );

        $result = $service->get('AA-999');

        $this->assertEquals('AA-999', $result['key']);
        $this->assertEquals('Bug', $result['fields']['issuetype']['name']);
    }

    /**
     * @expectedException \GuzzleHttp\Exception\BadResponseException
     */
    public function testIssueServiceGetException()
    {
        $service = new IssueService($this->getClientMockException());

        $service->get('PROJECT');
        $service->get('repository');
        $service->get('branch');
    }

    public function testIssueServiceGetNoData()
    {
        $service = new IssueService($this->getClientMockNoData());

        $result = $service->get('PROJECT');
        $this->assertEquals(array(), $result);

        $result = $service->get('repository');
        $this->assertEquals(array(), $result);

        $result = $service->get('branch');
        $this->assertEquals(array(), $result);
    }

    public function testIssueServiceGetErrors()
    {
        $service = new IssueService($this->getClientMockErrors());

        $result = $service->get('PROJECT');
        $this->assertEquals(false, $result);

        $result = $service->get('repository');
        $this->assertEquals(false, $result);

        $result = $service->get('branch');
        $this->assertEquals(false, $result);
    }
}
