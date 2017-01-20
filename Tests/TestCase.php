<?php

namespace JiraApiBundle\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Performs initialisation at the start of each test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Mocks a Guzzle client with specified request.
     *
     * @param mixed $request
     *
     * @return \GuzzleHttp\Client
     */
    private function mockClientWithRequest($request)
    {
        $client = $this
            ->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->any())
            ->method('get')
            ->will(
                $this->returnValue($request)
            );

        return $client;
    }

    /**
     * Get a Guzzle client mock object which returns the specified
     * JSON file as an array.
     *
     * @param string $jsonFile
     *
     * @return \GuzzleHttp\Client
     *
     * @throws \RuntimeException
     */
    protected function getClientMock($jsonFile)
    {
        if (false === file_exists($jsonFile)) {
            throw new \RuntimeException('Unable to find JSON file.');
        }

        $stream = $this->getMock(StreamInterface::class);

        $stream
            ->expects($this->any())
            ->method('getContents')
            ->will(
                $this->returnValue(new JsonResponseMock($jsonFile))
            );

        $request = $this->getMock(ResponseInterface::class);

        $request
            ->expects($this->any())
            ->method('getBody')
            ->will(
                $this->returnValue($stream)
            );

        return $this->mockClientWithRequest($request);
    }

    /**
     * Get a Guzzle client mock object which triggers a BadResponseException.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClientMockException()
    {
        $request = $this
            ->getMockBuilder(ClientInterface::class)
            ->setMethods(array('send'))
            ->getMock();

        $request
            ->expects($this->once())
            ->method('send')
            ->will(
                $this->throwException(new BadResponseException("", $request))
            );

        return $this->mockClientWithRequest($request);
    }

    /**
     * Get a Guzzle client mock object which returns no data.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClientMockNoData()
    {
        $request = $this->getMock(RequestInterface::class);

        $request
            ->expects($this->any())
            ->method('send')
            ->will(
                $this->returnValue(new EmptyResponseMock())
            );

        return $this->mockClientWithRequest($request);
    }

    /**
     * Get a Guzzle client mock object which returns an error.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClientMockErrors()
    {
        $request = $this->getMock(RequestInterface::class);

        $request
            ->expects($this->any())
            ->method('send')
            ->will(
                $this->returnValue(new ErrorResponseMock())
            );

        return $this->mockClientWithRequest($request);
    }

    /**
     * Performs clean-up operations after each test.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}
