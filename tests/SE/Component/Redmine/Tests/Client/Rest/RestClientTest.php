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

        $client = new \SE\Component\Redmine\Client\Rest\RestClient($stub, $baseUrl, $apiKey);
        $client->setHttpAuth($httpUser, $httpPass);

        $this->assertEquals(array($httpUser, $httpPass), $client->getHttpAuth());



    }




} 