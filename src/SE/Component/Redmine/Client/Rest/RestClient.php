<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Client\Rest;

use \SE\Component\Redmine\Client\ClientInterface;

use \Guzzle\Http\Client as HttpClient;
use \Guzzle\Http\Exception\ServerErrorResponseException;

use \JMS\Serializer\Serializer;
use \JMS\Serializer\SerializerBuilder;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class RestClient implements ClientInterface
{
    const CLIENT_NAME = 'redmine.client.rest';

    /**
     *
     * @var \Guzzle\Http\Client
     */
    protected $httpClient;

    /**
     *
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

    /**
     *
     * @var string
     */
    protected $baseUrl;

    /**
     *
     * @var string
     */
    protected $apiKey;

    /**
     *
     * @var array
     */
    protected $httpAuth = array('', '', 'Basic');

    /**
     *
     * @param $httpClient
     * @param string $baseUrl
     * @param string $apiKey
     * @param \JMS\Serializer\Serializer $serializer
     */
    public function __construct(HttpClient $httpClient, $baseUrl, $apiKey, $serializer = null)
    {
        if($serializer === null) {
            $serializer = SerializerBuilder::create()->build();
        }

        $this->httpClient = $httpClient;
        $this->serializer = $serializer;

        $this->setApiKey($apiKey);
        $this->setBaseUrl($baseUrl);
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return self::CLIENT_NAME;
    }

    /**
     *
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     *
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     *
     * @param string $httpUser
     * @param string $httpPass
     * @param string $authType
     */
    public function setHttpAuth($httpUser, $httpPass, $authType = 'Basic')
    {
        $this->httpAuth = array(
            (string)$httpUser,
            (string)$httpPass,
            (string)$authType
        );
    }

    /**
     *
     * @return array
     */
    public function getHttpAuth()
    {
        return $this->httpAuth;
    }

    /**
     *
     * @param string $uri
     * @return string
     */
    public function prepareUrl($uri)
    {
        return sprintf(
            '%s/%s',
            rtrim($this->getBaseUrl(), '/'),
            ltrim($uri, '/')
        );
    }

    /**
     *
     * @param array $headers
     * @return array
     */
    public function prepareHeaders(array $headers)
    {
        return array_merge(array(
            'X-Redmine-API-Key' => $this->getApiKey()
        ), $headers);
    }

    /**
     *
     * @param array $options
     * @return array
     */
    public function prepareOptions(array $options)
    {
        return array_merge(array(
            'auth' => $this->getHttpAuth()
        ), $options);
    }

    /**
     * @param string $uri
     * @param array $headers
     * @param array $options
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function createRequest($uri, array $headers = array(), array $options = array())
    {
        return $this->httpClient->get(
            $this->prepareUrl($uri),
            $this->prepareHeaders($headers),
            $this->prepareOptions($options)
        );
    }

    /**
     *
     * @param string $project
     * @param integer $limit
     * @throws \Guzzle\Http\Exception\BadResponseException
     * @return \SE\Component\Redmine\Entity\NewsCollection
     */
    public function getNews($project = '', $limit = 25)
    {
        $request = $this->createRequest('news.xml');
        $response = $request->send();

        if($response->isSuccessful() === false) {
            throw ServerErrorResponseException::factory($request, $response);
        }

        $contents = (string)$response->getBody();
        $collection =  $this->serializer->deserialize(
            $contents,
            'SE\Component\Redmine\Entity\NewsCollection',
            'xml'
        );

        return $collection;
    }





} 