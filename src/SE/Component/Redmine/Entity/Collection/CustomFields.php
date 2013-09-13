<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Entity\Collection;

use \JMS\Serializer\Annotation as Serializer;
use \SE\Component\Redmine\Entity\CustomField;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("custom_fields")
 */
class CustomFields
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("custom_fields")
     * @Serializer\Type("array<SE\Component\Redmine\Entity\CustomField>")
     * @Serializer\XmlList(inline=true,entry="custom_field")
     *
     * @Serializer\Groups({"default", "persist"})
     *
     * @var \SE\Component\Redmine\Entity\CustomField[]
     */
    protected $customFields = array();
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("type")
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute
     * @Serializer\ReadOnly
     *
     * @Serializer\Groups({"persist"})
     *
     * @var string
     */
    protected $type = 'array';

    /**
     *
     * @param array|\SE\Component\Redmine\Entity\CustomField[] $fields
     */
    public function __construct(array $fields = array())
    {
        foreach($fields as $field) {
            $this->addCustomField($field);
        }
    }

    /**
     *
     * @param \SE\Component\Redmine\Entity\CustomField $field
     */
    public function addCustomField(CustomField $field)
    {
        $this->customFields []= $field;
    }

    /**
     *
     * @param array|\SE\Component\Redmine\Entity\CustomField[]
     */
    public function all()
    {
        return $this->customFields;
    }
}