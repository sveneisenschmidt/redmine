<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Entity\CustomField;

use \JMS\Serializer\Annotation as Serializer;
use \SE\Component\Redmine\Entity\CustomField;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("custom_field")
 */
class ListField extends CustomField
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("value")
     * @Serializer\Type("SE\Component\Redmine\Entity\CustomField\ValueList")
     *
     * @var \SE\Component\Redmine\Entity\CustomField\ValueList
     */
    protected $value;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("multiple")
     * @Serializer\Type("boolean")
     * @Serializer\XmlAttribute
     *
     * @var boolean
     */
    protected $multiple = true;

    /**
     *
     * @param array $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     *
     * @return array|\SE\Component\Redmine\Entity\CustomField\SimpleValue[]
     */
    public function getValue()
    {
        return $this->value;
    }
}