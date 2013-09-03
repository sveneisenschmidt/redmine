<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Entity\Relation;

interface RelationInterface
{
    /**
     *
     * @return integer
     */
    public function getId();

    /**
     *
     * @return integer
     */
    public function getName();
} 