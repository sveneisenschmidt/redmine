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

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("value")
 */
class Value
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("type")
     * @Serializer\Type("string")
     * @Serializer\XmlAttribute
     */
    protected $type = 'string';

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("value")
     * @Serializer\Type("string")
     */
    protected $value;
}