<?php

namespace JiraApiBundle\Tests\Service;

use JiraApiBundle\Tests\TestCase;
use JiraApiBundle\Service\SearchService;

class SearchServiceTest extends TestCase
{
    public function testSearch()
    {        
        $searchJsonFile = __DIR__ . '/../assets/response/search.json';
        $searchService = new SearchService($this->getClientMock($searchJsonFile));
        $params = array(
            'jql' => 'id=TD-945'
        );
        $searchResult = $searchService->search($params);          
        $this->assertEquals('TD-945', $searchResult['issues'][0]['key']);
        $this->assertEquals('Bug', $searchResult['issues'][0]['fields']['issuetype']['name']);
    }
   
}
