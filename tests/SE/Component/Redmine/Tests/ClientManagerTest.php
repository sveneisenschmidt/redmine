<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests;

/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @group client
 */
class ClientManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function Can_Be_Instantiated()
    {
        $manager = new \SE\Component\Redmine\ClientManager;
        $this->assertNull($manager->getDefaultClientName());
    }

    /**
     *
     * @test
     */
    public function Set_Get_Default_Client_Name()
    {
        $manager = new \SE\Component\Redmine\ClientManager;
        $this->assertNull($manager->getDefaultClientName());

        $name = sha1(uniqid(microtime(true), true));
        $manager->setDefaultClientName($name);

        $this->assertEquals($name, $manager->getDefaultClientName());
    }

    /**
     *
     * @test
     */
    public function Add_Client()
    {
        $manager = new \SE\Component\Redmine\ClientManager;
        $client = $this->getMockForAbstractClass('\SE\Component\Redmine\Client\ClientInterface');

        $name = sha1(uniqid(microtime(true), true));
        $client->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name));

        $manager->addClient($client);
    }

    /**
     *
     * @test
     */
    public function Add_Client_Gets_Default_Client_If_Not_Set()
    {
        $manager = new \SE\Component\Redmine\ClientManager;
        $client = $this->getMockForAbstractClass('\SE\Component\Redmine\Client\ClientInterface');

        $name = sha1(uniqid(microtime(true), true));
        $client->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name));

        $manager->addClient($client);
        $this->assertEquals($name, $manager->getDefaultClientName());
        $this->assertSame($client, $manager->getClient($name));
    }

    /**
     *
     * @test
     */
    public function Add_Second_Client_Does_Not_Become_Default_Client()
    {
        $manager = new \SE\Component\Redmine\ClientManager;

        $name1 = sha1(uniqid(microtime(true), true));
        $client1 = $this->getMockForAbstractClass('\SE\Component\Redmine\Client\ClientInterface');
        $client1->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name1));

        $manager->addClient($client1);
        $this->assertSame($client1, $manager->getClient($name1));
        $this->assertEquals($name1, $manager->getDefaultClientName());

        $name2 = sha1(uniqid(microtime(true), true));
        $client2 = $this->getMockForAbstractClass('\SE\Component\Redmine\Client\ClientInterface');
        $client2->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name2));

        $manager->addClient($client2);
        $this->assertSame($client2, $manager->getClient($name2));
        $this->assertNotEquals($name2, $manager->getDefaultClientName());

    }

    /**
     *
     * @test
     * @expectedException \SE\Component\Redmine\Exception\DuplicateClientNameException
     */
    public function Add_Clients_With_Same_Name_Throws_Exception()
    {
        $manager = new \SE\Component\Redmine\ClientManager;
        $name = sha1(uniqid(microtime(true), true));

        $client1 = $this->getMockForAbstractClass('\SE\Component\Redmine\Client\ClientInterface');
        $client1->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name));
        $manager->addClient($client1);
        $this->assertSame($client1, $manager->getClient($name));
        $this->assertEquals($name, $manager->getDefaultClientName());

        $client2 = $this->getMockForAbstractClass('\SE\Component\Redmine\Client\ClientInterface');
        $client2->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name));
        $manager->addClient($client2);
    }

    /**
     *
     * @test
     * @expectedException \SE\Component\Redmine\Exception\UnkownClientException
     */
    public function Has_Get_Unknown_Client()
    {
        $manager = new \SE\Component\Redmine\ClientManager;
        $name = sha1(uniqid(microtime(true), true));

        $this->assertFalse($manager->hasClient($name));
        $manager->getClient($name);
    }

    /**
     *
     * @test
     * @expectedException \SE\Component\Redmine\Exception\UnkownClientException
     */
    public function Get_Repository_From_Unkown_Client()
    {
        $manager = new \SE\Component\Redmine\ClientManager;
        $name = sha1(uniqid(microtime(true), true));

        $manager->getRepository($name);
    }

    /**
     *
     * @test
     * @expectedException \SE\Component\Redmine\Exception\UnkownClientException
     */
    public function Get_Repository_From_Unkown_Client_By_Name()
    {
        $manager = new \SE\Component\Redmine\ClientManager;
        $name = sha1(uniqid(microtime(true), true));

        $manager->getRepository($name, md5($name));
    }

}