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

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
interface PersistInterface
{
    /**
     *
     * @param mixed $object
     * @return mixed
     */
    public function persist($object);

    /**
     *
     * @param mixed $object
     * @return mixed
     */
    public function isNew($object);
}