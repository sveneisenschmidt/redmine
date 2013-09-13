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
use \SE\Component\Redmine\Client\Rest\EventSubscriber;
use \SE\Component\Redmine\Client\ClientInterface;
use \SE\Component\Redmine\Client\Rest\Exception\UnknownFormatException;

use \Guzzle\Http\Client as HttpClient;
use \Guzzle\Http\Message\RequestInterface;
use \Guzzle\Http\Exception\ServerErrorResponseException;

use \JMS\Serializer\Serializer;
use \JMS\Serializer\SerializerBuilder;
use \JMS\Serializer\EventDispatcher\EventDispatcher;
use \JMS\Serializer\SerializationContext;
use \JMS\Serializer\DeserializationContext;

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
    public function __construct($baseUrl, $apiKey, HttpClient $httpClient = null, Serializer $serializer = null)
    {
        if($serializer === null) {
            $builder = SerializerBuilder::create()->configureListeners(function(EventDispatcher $dispatcher) {
                $dispatcher->addSubscriber(new EventSubscriber());
            });
            $serializer = $builder->build();
        }

        if($httpClient === null) {
            $httpClient = new \Guzzle\Http\Client();
        }

        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
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
        switch($this->getFormat()) {
            case 'xml':
                $type = 'text/xml';
                break;
            case 'json':
                $type = 'application/json';
                break;
            default:
                throw new UnknownFormatException(sprintf('Invalid format %s to use', $this->getFormat()));
        }

        return array_merge(array(
            'X-Redmine-API-Key' => $this->getApiKey(),
            'Content-Type' => $type
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
     * @param string $uri
     * @param string $postBody
     * @param array $headers
     * @param array $options
     * @return \Guzzle\Http\Message\RequestInterface
     */
    public function createPutRequest($uri, $postBody = null, $headers = array(), array $options = array())
    {
        $request = $this->httpClient->put(
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
            $this->getFormat(),
            DeserializationContext::create()->setGroups(array('default'))
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
            $this->getFormat(),
            DeserializationContext::create()->setGroups(array('default'))
        );

        return $collection;
    }

    /**
     *
     * @param string $resource
     * @param mixed $object
     */
    public function persist($resource, &$object)
    {
        $body = $this->serializer->serialize(
            clone $object,
            $this->getFormat(),
            SerializationContext::create()->setGroups(array('persist'))
        );

        if(($isNew = $this->isNew($resource, $object)) === false) {
            $uri = sprintf('%s/%s.%s', $resource, $object->getId(), $this->getFormat());
            $request = $this->createPutRequest($uri, $body);
        } else {
            $uri = sprintf('%s.%s', $resource, $this->getFormat());
            $request = $this->createPostRequest($uri, $body);
        }

        $response = $request->send();

        // @codeCoverageIgnoreStart
        if($response->isSuccessful() === false) {
            throw ServerErrorResponseException::factory($request, $response);
        }
        // @codeCoverageIgnoreEnd

        if($isNew === true) {
            $object = $this->serializer->deserialize(
                (string)$response->getBody(),
                get_class($object),
                $this->getFormat(),
                DeserializationContext::create()->setGroups(array('default'))
            );
        } else {
            $object = $this->find(
                $resource,
                $object->getId(),
                get_class($object)
            );
        }
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

    /**
     *
     * @param string $resource
     * @param mixed $object
     * @return boolean
     */
    public function isNew($resource, $object)
    {
        if(is_object($object) === false) {
            return true;
        }

        if(method_exists($object, 'getId') === false) {
            return true;
        }

        $id = $object->getId();
        if($id === null) {
            return true;
        }

        if($this->find($resource, $id, get_class($object)) === null) {
            return true;
        }

        return false;
    }
}