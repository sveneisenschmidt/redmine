<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine;

use \SE\Component\Redmine\Client\ClientInterface;
use \SE\Component\Redmine\Exception\DuplicateClientNameException;
use \SE\Component\Redmine\Exception\UnkownClientException;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class ClientManager
{
    /**
     *
     * @var \SE\Component\Redmine\Client\ClientInterface[]
     */
    protected $clients = array();

    /**
     *
     * @var string
     */
    protected $defaultClient = null;

    /**
     *
     * @param string $defaultClient
     */
    public function setDefaultClientName($defaultClient)
    {
        $this->defaultClient = $defaultClient;
    }

    /**
     *
     * @return string
     */
    public function getDefaultClientName()
    {
        return $this->defaultClient;
    }

    /**
     *
     * @param \SE\Component\Redmine\Client\ClientInterface $client
     * @throws \SE\Component\Redmine\Exception\DuplicateClientNameException
     * @return void
     */
    public function addClient(ClientInterface $client)
    {
        $name = $client->getName();

        if(isset($this->clients[$name]) === true) {
            throw new DuplicateClientNameException(sprintf('Client with name %s is already registered.', $name));
        }

        $this->clients[$name] = $client;

        if($this->getDefaultClientName() === null) {
            $this->setDefaultClientName($name);
        }
    }

    /**
     *
     * @param string $name
     * @throws \SE\Component\Redmine\Exception\UnkownClientException
     * @return \SE\Component\Redmine\Client\ClientInterface
     */
    public function getClient($name)
    {
        if($this->hasClient($name) === false) {
            throw new UnkownClientException(sprintf('Unknown Client with name %s.', $name));
        }

        return $this->clients[$name];
    }

    /**
     *
     * @param string $name
     * @return boolean
     */
    public function hasClient($name)
    {
        return isset($this->clients[$name]);
    }

    /**
     *
     * @param string $resource
     * @param string $clientName
     * @throws \SE\Component\Redmine\Exception\UnkownClientException
     * @return \SE\Component\Redmine\Repository\AbstractRepository
     */
    public function getRepository($resource, $clientName = null)
    {
        if($clientName == null) {
            $clientName = $this->getDefaultClientName();
        }

        return $this->getClient($clientName)->getRepository($resource);
    }
}