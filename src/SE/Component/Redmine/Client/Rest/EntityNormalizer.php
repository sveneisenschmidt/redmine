<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Client\Rest;

use \JMS\Serializer\Serializer;
use \Doctrine\Common\Annotations\AnnotationReader;

use \SE\Component\Redmine\Client\Rest\Exception\MissingAnnotationException;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class EntityNormalizer
{
    /**
     *
     * @var \JMS\Serializer\Serializer
     */
    protected $serializer;

    /**
     *
     * @var \Doctrine\Common\Annotations\AnnotationReader
     */
    protected $reader;

    /**
     *
     * @param \JMS\Serializer\Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
        $this->reader = new AnnotationReader;
    }

    /**
     *
     * @return \JMS\Serializer\Serializer
     */
    public function getSerializer()
    {
        return $this->serializer;
    }


    /**
     *
     * @param mixed $object
     * @return array
     */
    public function toData($object)
    {
        $data = $this->toArray($object);

        foreach($data as $key => $value) {
            if(is_array($value) === true) {
                if(isset($value['id']) === true && empty($value['id']) === false) {
                    unset($data[$key]);
                    $data[$key.'_id'] = $value['id'];
                }
            }
        }

        return $data;
    }

    /**
     *
     * @param mixed $object
     * @return array
     */
    public function toArray($object)
    {
        $json = $this->serializer->serialize($object, 'json');
        $data = json_decode($json, true);

        return $data;
    }

    /**
     *
     * @param mixed $object
     * @return string
     */
    public function getRootKey($object)
    {
        $class = get_class($object);
        $reflection = new \ReflectionClass($class);
        $annotation = $this->reader->getClassAnnotation($reflection, 'JMS\Serializer\Annotation\XmlRoot');

        if($annotation === null) {
            throw new MissingAnnotationException('The class annotation XmlRoot is missing');
        }

        return $annotation->name;
    }
}
