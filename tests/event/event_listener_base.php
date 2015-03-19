<?php
/**
*
* Advanced BBCode Box 3.1
*
* @copyright (c) 2014 Matt Friedman
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vse\abbc3\tests\event;

class event_listener_base extends \phpbb_test_case
{
	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $bbcodes;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $controller_helper;

	/** @var \vse\abbc3\event\listener */
	protected $listener;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $parser;

	/** @var \PHPUnit_Framework_MockObject_MockObject */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $ext_root_path;

	/** @var string */
	protected $bbvideo_width;

	/** @var string */
	protected $bbvideo_height;

	public function setUp()
	{
		parent::setUp();

		global $phpbb_root_path;

		$this->parser = $this->getMockBuilder('\vse\abbc3\core\bbcodes_parser')
			->disableOriginalConstructor()
			->getMock();
		$this->bbcodes = $this->getMockBuilder('\vse\abbc3\core\bbcodes_display')
			->disableOriginalConstructor()
			->getMock();
		$this->config = new \phpbb\config\config(array('enable_mod_rewrite' => '0'));

		$this->template = $this->getMockBuilder('\phpbb\template\template')
			->getMock();
		$this->user = $this->getMock('\phpbb\user', array(), array('\phpbb\datetime'));
		$this->user->data['username'] = 'admin';

		$this->controller_helper = $this->getMockBuilder('\phpbb\controller\helper')
			->disableOriginalConstructor()
			->getMock();
		$this->controller_helper->expects($this->any())
			->method('route')
			->willReturnCallback(function ($route, array $params = array()) {
				return $route . '#' . serialize($params);
			});

		$this->root_path = $phpbb_root_path;
		$this->ext_root_path = 'ext/vse/abbc3/';
		$this->bbvideo_width = 560;
		$this->bbvideo_height = 315;
	}

	/**
	 * Set up an instance of the event listener
	 */
	protected function set_listener()
	{
		$this->listener = new \vse\abbc3\event\listener(
			$this->parser,
			$this->bbcodes,
			$this->controller_helper,
			$this->template,
			$this->user,
			$this->root_path,
			$this->ext_root_path,
			$this->bbvideo_width,
			$this->bbvideo_height
		);
	}
}
