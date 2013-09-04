<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Client;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
interface ClientInterface
{
    public function getName();

    /**
     *
     * @param string $resource
     * @param integer $id
     * @param string $entityClass
     * @return $$entityClass
     */
    public function find($resource, $id, $entityClass);

    /**
     *
     * @param string $resource
     * @param array $criteria
     * @param string $entityClass
     * @return $$entityClass
     */
    public function findAll($resource, array $criteria = array(), $entityClass);

    /**
     *
     * @param string $resource
     * @return \SE\Component\Redmine\Repository\AbstractRepository
     */
    public function getRepository($resource);
}