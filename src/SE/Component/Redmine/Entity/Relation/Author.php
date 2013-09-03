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

use \JMS\Serializer\Annotation as Serializer;
use \SE\Component\Redmine\Entity\Relation\RelationInterface;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("author")
 */
class Author implements RelationInterface
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("id")
     * @Serializer\Type("integer")
     * @Serializer\XmlAttribute
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}