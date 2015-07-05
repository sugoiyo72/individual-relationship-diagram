<?php
/**
 * Individual Relationship Diagram has been created for the workshops that get to introduce yourself from others.
 *
 * @package    Individual Relationship Diagram
 * @version    0.1
 * @author     Fuel Development Team
 * @author     Shinobu Komakine
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @copyright  Shinobu Komakine
 * @link       http://fuelphp.com
 */

/**
 * The Default Controller.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Default extends Controller
{
	/**
	 * Top page
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
		$me = Session::get('user');
		$users = Model_User::find('all', array('related' => array('introductions')));

		return Response::forge(View::forge('default/index', array('users' => $users, 'me' => $me)));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('default/404'), 404);
	}
}
