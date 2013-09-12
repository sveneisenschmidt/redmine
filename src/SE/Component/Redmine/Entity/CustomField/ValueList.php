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
 * @Serializer\XmlRoot("value")
 */
class ValueList
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("value")
     * @Serializer\Type("array<SE\Component\Redmine\Entity\CustomField\ScalarValue>")
     * @Serializer\XmlList(inline=true, entry="value")
     * @Serializer\Accessor(setter="setValues")
     *
     * @var string
     */
    protected $values;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("type")
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute
     *
     * @var string
     */
    protected $type = 'array';

    /**
     *
     * @param array|\SE\Component\Redmine\Entity\CustomField\SimpleValue[] $values
     */
    public function __construct(array $values = array())
    {
        $this->setValues($values);
    }

    /**
     *
     * @param array $values
     */
    public function setValues(array $values)
    {
        foreach($values as $index => $value) {
            if(is_object($value) === false || !$value instanceof \SE\Component\Redmine\Entity\CustomField\ScalarValue) {
                $values[$index] = new \SE\Component\Redmine\Entity\CustomField\ScalarValue($value);
            }
        }

        $this->values = $values;
    }
}
