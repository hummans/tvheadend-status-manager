<?php

namespace Jalle19\StatusManager\Test\Message\Handler;

use Jalle19\StatusManager\Message\Handler\DelegatesMessagesTrait;
use Jalle19\StatusManager\Message\Handler\HandlerInterface;
use Jalle19\StatusManager\Message\Request\InstancesRequest;
use Jalle19\StatusManager\Message\Request\UsersRequest;
use Jalle19\StatusManager\Message\Response\UsersResponse;
use Ratchet\ConnectionInterface;

/**
 * Class HandlerTest
 * @package   Jalle19\StatusManager\Test\Message\Handler
 * @copyright Copyright &copy; Sam Stenvall 2016-
 * @license   https://www.gnu.org/licenses/gpl.html The GNU General Public License v2.0
 */
class HandlerTest extends \PHPUnit_Framework_TestCase
{

	use DelegatesMessagesTrait;

	/**
	 * @var HandlerInterface
	 */
	private $_handler;

	/**
	 * @var ConnectionInterface
	 */
	private $_sender;


	/**
	 * @inheritdoc
	 */
	protected function setUp()
	{
		$this->_handler = new DummyHandler();
		$this->_sender  = new DummySender();

		$this->registerMessageHandler($this->_handler);
	}


	/**
	 * Check that the message is properly handled
	 */
	public function testDelegateMessage()
	{
		$this->assertInstanceOf(UsersResponse::class,
			$this->tryDelegateMessage(new UsersRequest('foo'), $this->_sender));
	}


	/**
	 * @expectedException \Jalle19\StatusManager\Exception\UnhandledMessageException
	 */
	public function testFailedDelegation()
	{
		$this->tryDelegateMessage(new InstancesRequest(), $this->_sender);
	}

}
