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
class ScalarValue
{
    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("value")
     * @Serializer\Type("string")
     * @Serializer\XmlValue
     *
     * @var string
     */

    protected $value;

    /**
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = (string)$value;
    }
}
