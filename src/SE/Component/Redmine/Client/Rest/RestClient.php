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

use \SE\Component\Redmine\EntityManager;
use \SE\Component\Redmine\Client\ClientInterface;

use \Guzzle\Http\Client as HttpClient;
use \Guzzle\Http\Message\RequestInterface;
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

    const API_FORMAT = 'xml';

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
    public function getFormat()
    {
        return self::API_FORMAT;
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
     * @return \Guzzle\Http\Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
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
     * @param array $query
     * @param array $headers
     * @param array $options
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function createRequest($uri, array $query = array(), array $headers = array(), array $options = array())
    {
        $request = $this->httpClient->get(
            $this->prepareUrl($uri),
            $this->prepareHeaders($headers),
            $this->prepareOptions($options)
        );

        foreach($query as $key => $value) {
            $request->getQuery()->add($key, $value);
        }

        return $request;
    }

    /**
     *
     * @param string $project
     * @param integer $limit
     * @throws \Guzzle\Http\Exception\BadResponseException
     * @return \SE\Component\Redmine\Entity\Collection\News
     */
    public function getNews($project = '', $limit = 25)
    {
        $uri = sprintf('%s.%s', 'news', $this->getFormat());
        if(empty($project) === false) {
            $uri = sprintf('%s/%s', trim($project), $uri);
        }

        $request = $this->createRequest($uri, array(
            'limit' => $limit
        ));

        $response = $request->send();
        // @codeCoverageIgnoreStart
        if($response->isSuccessful() === false) {
            throw ServerErrorResponseException::factory($request, $response);
        }
        // @codeCoverageIgnoreEnd

        $collection =  $this->serializer->deserialize(
            (string)$response->getBody(),
            'SE\Component\Redmine\Entity\Collection\News',
            $this->getFormat()
        );

        return $collection;
    }

    /**
     *
     * @param string $project
     * @param integer $limit
     * @throws \Guzzle\Http\Exception\BadResponseException
     * @return \SE\Component\Redmine\Entity\Collection\Issue
     */
    public function getIssues($limit = 25, array $params = array())
    {
        $uri = sprintf('%s.%s', 'issues', $this->getFormat());

        $request = $this->createRequest($uri, array_merge(array(
            'limit' => $limit
        ), $params));

        $response = $request->send();
        // @codeCoverageIgnoreStart
        if($response->isSuccessful() === false) {
            throw ServerErrorResponseException::factory($request, $response);
        }
        // @codeCoverageIgnoreEnd

        $collection =  $this->serializer->deserialize(
            (string)$response->getBody(),
            'SE\Component\Redmine\Entity\Collection\Issue',
            $this->getFormat()
        );

        return $collection;
    }

    /**
     *
     * @param string $project
     * @param integer $limit
     * @throws \Guzzle\Http\Exception\BadResponseException
     * @return \SE\Component\Redmine\Entity\NewsCollection
     */
    public function getIssue($id)
    {
        $uri = sprintf('%s/%s.%s', 'issues', $id, $this->getFormat());

        $request = $this->createRequest($uri);

        $response = $request->send();
        // @codeCoverageIgnoreStart
        if($response->isSuccessful() === false) {
            throw ServerErrorResponseException::factory($request, $response);
        }
        // @codeCoverageIgnoreEnd

        $entity =  $this->serializer->deserialize(
            (string)$response->getBody(),
            'SE\Component\Redmine\Entity\Issue',
            $this->getFormat()
        );

        return $entity;
    }

}