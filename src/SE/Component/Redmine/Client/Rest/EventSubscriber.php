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

use \JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use \JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use \JMS\Serializer\XmlDeserializationVisitor;

/**
 *
 * @package SE\Component\Redmine
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 */
class EventSubscriber implements EventSubscriberInterface
{
    /**
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.pre_deserialize', 'method' => 'onPreDeserialize'),
        );
    }

    /**
     * @param \JMS\Serializer\EventDispatcher\PreDeserializeEvent $event
     */
    public function onPreDeserialize(PreDeserializeEvent $event)
    {
        if($event->getVisitor() instanceof XmlDeserializationVisitor) {
            $type = $event->getType();
            if($type['name'] == 'SE\Component\Redmine\Entity\CustomField') {
                if(isset($event->getData()->value) && count($event->getData()->value->children()) > 0) {
                    $event->getData()->addChild('__type', 'array');
                } else {
                    $event->getData()->addChild('__type', 'scalar');
                }
            }
        }
    }
}

