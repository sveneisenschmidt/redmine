<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Client\Rest;

/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @group client
 * @group rest
 * @group events
 */
class EventSubscriberTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function Default_Events_Are_Registered()
    {
        $subscriber = new \SE\Component\Redmine\Client\Rest\EventSubscriber();

        $this->assertEquals(array(
            array('event' => 'serializer.pre_deserialize', 'method' => 'onPreDeserialize'),
        ), $subscriber->getSubscribedEvents());
    }
}
