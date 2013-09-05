<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Client\Rest;

/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @group client
 * @group rest
 */
class RestClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function Can_Be_Instantiated()
    {
        $stub = $this->getMock('\Guzzle\Http\Client');
        $baseUrl = 'http://localhost/redmine';
        $apiKey = sha1(uniqid(microtime(true), true));

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($stub, $baseUrl, $apiKey);
        $this->assertEquals(\SE\Component\Redmine\Client\Rest\RestClient::CLIENT_NAME, $client->getName());
    }

    /**
     *
     * @test
     */
    public function Set_Get_ApiKey_BaseUrl()
    {
        $stub = $this->getMock('\Guzzle\Http\Client');
        $baseUrl = 'http://localhost/redmine';
        $apiKey = sha1(uniqid(microtime(true), true));

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($stub, $baseUrl, $apiKey);
        $this->assertSame($apiKey, $client->getApiKey());
        $this->assertSame($baseUrl, $client->getBaseUrl());
        $this->assertSame($stub, $client->getHttpClient());
    }

    /**
     *
     * @test
     */
    public function Set_Get_Http_Auth()
    {
        $stub = $this->getMock('\Guzzle\Http\Client');
        $baseUrl = 'http://localhost/redmine';
        $apiKey = sha1(uniqid(microtime(true), true));

        $httpUser = sha1(uniqid(microtime(true), true));
        $httpPass = sha1(uniqid(microtime(true), true));
        $authType = 'Digest';

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($stub, $baseUrl, $apiKey);
        $client->setHttpAuth($httpUser, $httpPass, $authType);

        $this->assertEquals(array($httpUser, $httpPass, $authType), $client->getHttpAuth());
    }

    /**
     *
     * @test
     */
    public function Get_Prepared_Uri()
    {
        $stub = $this->getMock('\Guzzle\Http\Client');
        $baseUrl = 'http://localhost/redmine/';
        $apiKey = sha1(uniqid(microtime(true), true));
        $uri = '/resource/1.xml';

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($stub, $baseUrl, $apiKey);

        $this->assertNotEquals($baseUrl.$uri, $client->prepareUrl($uri));
        $this->assertEquals('http://localhost/redmine/resource/1.xml', $client->prepareUrl($uri));
    }

    /**
     *
     * @test
     */
    public function Get_Prepared_Headers_Api_Key()
    {
        $stub = $this->getMock('\Guzzle\Http\Client');
        $baseUrl = 'http://localhost/redmine/';
        $apiKey = sha1(uniqid(microtime(true), true));

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($stub, $baseUrl, $apiKey);
        $headers = $client->prepareHeaders(array());

        $this->assertNotEmpty($headers);
        $this->assertArrayHasKey('X-Redmine-API-Key', $headers);
        $this->assertContains($client->getApiKey(), $headers);
    }

    /**
     *
     * @test
     */
    public function Create_Request()
    {
        $httpClient = new \Guzzle\Http\Client;
        $baseUrl = 'http://localhost/redmine/';
        $apiKey = sha1(uniqid(microtime(true), true));
        $uri = '/resource/1.xml';
        $hash = sha1(uniqid(microtime(true), true));

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($httpClient, $baseUrl, $apiKey);
        $request = $client->createGetRequest($uri, array(
            $hash => strrev($hash)
        ));

        $this->assertInstanceOf('\Guzzle\Http\Message\RequestInterface', $request);
        $this->assertEquals(strrev($hash), $request->getQuery()->get($hash));
    }

    /**
     *
     * @test
     */
    public function Is_New()
    {
        $hash = sha1(uniqid(microtime(true), true));
        $id = rand(1,999);

        $object = new \SE\Component\Redmine\Entity\Issue;
        $object->setId($id);

        $client = $this->getMock('\SE\Component\Redmine\Client\Rest\RestClient', array('find'), array(), '', false);
        $client->expects($this->once())
            ->method('find')
            ->with($hash, $id, get_class($object))
            ->will($this->returnValue(null));

        $isNew = $client->isNew($hash, $object);
        $this->assertTrue($isNew);
    }

    /**
     *
     * @test
     */
    public function Is_New_With_Valid_Find()
    {
        $hash = sha1(uniqid(microtime(true), true));
        $id = rand(1,999);

        $object = new \SE\Component\Redmine\Entity\Issue;
        $object->setId($id);

        $client = $this->getMock('\SE\Component\Redmine\Client\Rest\RestClient', array('find'), array(), '', false);
        $client->expects($this->once())
            ->method('find')
            ->with($hash, $id, get_class($object))
            ->will($this->returnValue($object));

        $isNew = $client->isNew($hash, $object);
        $this->assertFalse($isNew);
    }

    /**
     *
     * @test
     */
    public function Is_New_Without_Id()
    {
        $hash = sha1(uniqid(microtime(true), true));

        $object = new \SE\Component\Redmine\Entity\Issue;

        $client = $this->getMock('\SE\Component\Redmine\Client\Rest\RestClient', array('find'), array(), '', false);
        $client->expects($this->never())
            ->method('find');

        $isNew = $client->isNew($hash, $object);
        $this->assertTrue($isNew);
    }

    /**
     *
     * @test
     */
    public function Is_New_Without_Invalid_Object()
    {
        $hash = sha1(uniqid(microtime(true), true));

        $object = new \stdClass();

        $client = $this->getMock('\SE\Component\Redmine\Client\Rest\RestClient', array('find'), array(), '', false);
        $client->expects($this->never())
            ->method('find');

        $isNew = $client->isNew($hash, $object);
        $this->assertTrue($isNew);
    }

    /**
     *
     * @test
     */
    public function Is_New_Without_Invalid_Argument()
    {
        $hash = sha1(uniqid(microtime(true), true));

        $object = array();

        $client = $this->getMock('\SE\Component\Redmine\Client\Rest\RestClient', array('find'), array(), '', false);
        $client->expects($this->never())
            ->method('find');

        $isNew = $client->isNew($hash, $object);
        $this->assertTrue($isNew);
    }
}