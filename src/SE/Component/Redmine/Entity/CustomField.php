<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Entity;

use \JMS\Serializer\Annotation as Serializer;
use \SE\Component\Redmine\Entity\CustomField\ScalarValue;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("custom_field")
 * @Serializer\Discriminator(
 *      field = "__type",
 *      map = {
 *          "scalar": "SE\Component\Redmine\Entity\CustomField\ScalarValue",
 *          "array": "SE\Component\Redmine\Entity\CustomField\ArrayValue"
 *      }
 * )
 */
abstract class CustomField
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
     * @Serializer\Expose
     * @Serializer\SerializedName("multiple")
     * @Serializer\Type("boolean")
     * @Serializer\XmlAttribute
     *
     * @var boolean
     */
    protected $multiple = false;

    /**
     *
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->multiple;
    }

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

    /**
     *
     * @param boolean $multiple
     */
    public function setMultiple($multiple)
    {
        $this->multiple = (bool)$multiple;
    }

    /**
     *
     * @return boolean
     */
    public function getMultiple()
    {
        return $this->multiple;
    }



    /**
     *
     * @return mixed
     */
    abstract function setValue($value);

    /**
     *
     * @return mixed
     */
    abstract function getValue();


}