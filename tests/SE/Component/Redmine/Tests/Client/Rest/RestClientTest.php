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
 */
class RestClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @test
     */
    public function Can_Be_Instantiated()
    {
        $client = new \SE\Component\Redmine\Client\Rest\RestClient;
        $this->assertEquals(\SE\Component\Redmine\Client\Rest\RestClient::CLIENT_NAME, $client->getName());
    }

} 