<?php
/**
 * This file is part of the Redmine php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SE\Component\Redmine\Tests\Repository;

/**
 *
 * @package SE\Component\Redmine\Tests
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @group repository
 */
class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function Set_Get_Client()
    {
        $client = $this->getMock('\SE\Component\Redmine\Client\ClientInterface', array('persist', 'getName', 'find', 'findAll', 'getRepository'));
        $repository = $this->getMockForAbstractClass('\SE\Component\Redmine\Repository\AbstractRepository', array($client));

        $this->assertSame($client, $repository->getClient());
    }
}