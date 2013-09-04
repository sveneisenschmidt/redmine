<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Repository;

use \SE\Component\Redmine\Client\ClientInterface;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
abstract class AbstractRepository
{
    /**
     *
     * @var \SE\Component\Redmine\Client\ClientInterface
     */
    protected $client;

    /**
     *
     * @param \SE\Component\Redmine\Client\ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     *
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }
}