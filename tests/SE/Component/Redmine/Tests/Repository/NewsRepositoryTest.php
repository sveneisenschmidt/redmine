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
 * @group news
 */
class NewsRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function Find_All()
    {
        $client = $this->getMock('\SE\Component\Redmine\Client\ClientInterface', array('getName', 'find', 'findAll', 'getRepository'));
        $client->expects($this->once())
            ->method('findAll')
            ->with('news', array(), 'SE\Component\Redmine\Entity\Collection\News');

        $repository = new \SE\Component\Redmine\Repository\NewsRepository($client);
        $this->assertSame($client, $repository->getClient());

        $repository->findAll();
    }
}