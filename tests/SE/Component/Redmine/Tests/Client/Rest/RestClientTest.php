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
    public function Get_Prepared_Headers_Content_Type_Xml()
    {
        $client = $this->getMock('\SE\Component\Redmine\Client\Rest\RestClient', array('getFormat'), array(), '', false);
        $client->expects($this->once())
            ->method('getFormat')
            ->will($this->returnValue('xml'));

        $headers = $client->prepareHeaders(array());
        $this->assertNotEmpty($headers);
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertContains('text/xml', $headers);
    }

    /**
     *
     * @test
     */
    public function Get_Prepared_Headers_Content_Type_Json()
    {
        $client = $this->getMock('\SE\Component\Redmine\Client\Rest\RestClient', array('getFormat'), array(), '', false);
        $client->expects($this->once())
            ->method('getFormat')
            ->will($this->returnValue('json'));

        $headers = $client->prepareHeaders(array());
        $this->assertNotEmpty($headers);
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertContains('application/json', $headers);
    }

    /**
     *
     * @test
     * @expectedException \SE\Component\Redmine\Client\Rest\Exception\UnknownFormatException
     */
    public function Get_Prepared_Headers_Content_Type_Unknown_Format()
    {
        $hash = sha1(uniqid(microtime(true), true));

        $client = $this->getMock('\SE\Component\Redmine\Client\Rest\RestClient', array('getFormat'), array(), '', false);
        $client->expects($this->exactly(2))
            ->method('getFormat')
            ->will($this->returnValue($hash));

        $headers = $client->prepareHeaders(array());
    }

    /**
     *
     * @test
     */
    public function Create_Get_Request()
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

        $this->assertEquals('GET', $request->getMethod());
    }

    /**
     *
     * @test
     */
    public function Create_Put_Request()
    {
        $httpClient = new \Guzzle\Http\Client;
        $baseUrl = 'http://localhost/redmine/';
        $apiKey = sha1(uniqid(microtime(true), true));
        $uri = '/resource/1.xml';
        $hash = sha1(uniqid(microtime(true), true));

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($httpClient, $baseUrl, $apiKey);
        $request = $client->createPutRequest($uri, null, array(
            $hash => strrev($hash)
        ));

        $this->assertInstanceOf('\Guzzle\Http\Message\RequestInterface', $request);
        $this->assertEquals(strrev($hash), $request->getHeaders()->get($hash));

        $this->assertEquals('PUT', $request->getMethod());
    }

    /**
     *
     * @test
     */
    public function Create_Post_Request()
    {
        $httpClient = new \Guzzle\Http\Client;
        $baseUrl = 'http://localhost/redmine/';
        $apiKey = sha1(uniqid(microtime(true), true));
        $uri = '/resource/1.xml';
        $hash = sha1(uniqid(microtime(true), true));

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($httpClient, $baseUrl, $apiKey);
        $request = $client->createPostRequest($uri, null, array(
            $hash => strrev($hash)
        ));

        $this->assertInstanceOf('\Guzzle\Http\Message\RequestInterface', $request);
        $this->assertEquals(strrev($hash), $request->getHeaders()->get($hash));

        $this->assertEquals('POST', $request->getMethod());
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