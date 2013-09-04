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
use \SE\Component\Redmine\Client\Rest\EntityNormalizer;

use \Guzzle\Http\Client as HttpClient;
use \Guzzle\Http\Message\RequestInterface;
use \Guzzle\Http\Exception\ServerErrorResponseException;

use \JMS\Serializer\Serializer;
use \JMS\Serializer\SerializerBuilder;

use \Symfony\Component\Serializer\Encoder\XmlEncoder;

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
     * @var \SE\Component\Redmine\Client\Rest\EntityNormalizer
     */
    protected $normalizer;

    /**
     *
     * @var \Symfony\Component\Serializer\Encoder\XmlEncoder
     */
    protected $encoder;

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
        $this->normalizer = new EntityNormalizer($serializer);
        $this->encoder = new XmlEncoder;

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
    public function createGetRequest($uri, array $query = array(), array $headers = array(), array $options = array())
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
     * @param string $uri
     * @param string $postBody
     * @param array $headers
     * @param array $options
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function createPostRequest($uri, $postBody = null, $headers = array(), array $options = array())
    {
        $request = $this->httpClient->post(
            $this->prepareUrl($uri),
            $this->prepareHeaders($headers),
            $postBody,
            $this->prepareOptions($options)
        );

        return $request;
    }

    /**
     * @param string $resource
     * @param integer $id
     * @param string $entityClass
     * @return $$entityClass
     */
    public function find($resource, $id, $entityClass)
    {
        $uri = sprintf('%s/%s.%s', $resource, $id, $this->getFormat());

        $request = $this->createGetRequest($uri);
        $response = $request->send();

        // @codeCoverageIgnoreStart
        if($response->isSuccessful() === false) {
            throw ServerErrorResponseException::factory($request, $response);
        }
        // @codeCoverageIgnoreEnd

        $entity =  $this->serializer->deserialize(
            (string)$response->getBody(),
            $entityClass,
            $this->getFormat()
        );

        return $entity;


    }

    /**
     * @param string $resource
     * @param array $criteria
     * @param string $entityClass
     * @return $$entityClass
     */
    public function findAll($resource, array $criteria = array(), $entityClass)
    {
        $uri = sprintf('%s.%s', $resource, $this->getFormat());

        $request = $this->createGetRequest($uri, $criteria);
        $response = $request->send();

        // @codeCoverageIgnoreStart
        if($response->isSuccessful() === false) {
            throw ServerErrorResponseException::factory($request, $response);
        }
        // @codeCoverageIgnoreEnd

        $collection =  $this->serializer->deserialize(
            (string)$response->getBody(),
            $entityClass,
            $this->getFormat()
        );

        return $collection;
    }

    /**
     *
     * @param string $resource
     * @param mixed $object
     * @return mixed
     */
    public function persist($resource, $object)
    {
        $uri = sprintf('%s.%s', $resource, $this->getFormat());
        $data = $this->normalizer->toData($object);
        $root = $this->normalizer->getRootKey($object);

        $body = $this->encoder->encode($data, $this->getFormat(), array(
            'xml_root_node_name' => $root
        ));

        $request = $this->createPostRequest($uri, $body);
    }


    /**
     * @param $resource
     * @return \SE\Component\Redmine\Repository\AbstractRepository
     */
    public function getRepository($resource)
    {
        $class = sprintf('\\SE\\Component\\Redmine\\Repository\\%sRepository', ucfirst($resource));
        return new $class($this);
    }
}