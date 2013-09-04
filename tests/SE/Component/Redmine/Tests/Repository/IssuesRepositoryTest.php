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
 * @group issues
 */
class IssuesRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function Find_All()
    {
        $client = $this->getMock('\SE\Component\Redmine\Client\ClientInterface', array('persist', 'getName', 'find', 'findAll', 'getRepository'));
        $client->expects($this->once())
            ->method('findAll')
            ->with('issues', array(), 'SE\Component\Redmine\Entity\Collection\Issues');

        $repository = new \SE\Component\Redmine\Repository\IssuesRepository($client);
        $this->assertSame($client, $repository->getClient());

        $repository->findAll();
    }

    /**
     *
     * @test
     */
    public function Find_One()
    {
        $id = rand(1,999);

        $client = $this->getMock('\SE\Component\Redmine\Client\ClientInterface', array('persist', 'getName', 'find', 'findAll', 'getRepository'));
        $client->expects($this->once())
            ->method('find')
            ->with('issues', $id, 'SE\Component\Redmine\Entity\Issue');

        $repository = new \SE\Component\Redmine\Repository\IssuesRepository($client);
        $this->assertSame($client, $repository->getClient());

        $repository->find($id);
    }
}