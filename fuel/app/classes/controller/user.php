<?php
// TODO FOUND 153 ERRORS AFFECTING 80 LINES
// fuelphpcs says 'PHPCBF CAN FIX THE 40 MARKED SNIFF VIOLATIONS AUTOMATICALLY'. Is this really?
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
 * The User Controller.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_User extends Controller
{
	/**
	 * Out put relation json
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_relationjson($introduced_user_id)
	{

		$me = Session::get('user', null);
		$introduced_user = Model_User::find($introduced_user_id);
		$query = \DB::query(
			'SELECT `users`.`id` as `post_user_id`, `users`.`url`, `users`.`name`, `introductions`.*,
			(`introductions`.`distance` + `introductions`.`humanity`+ `introductions`.`ability`) as goodpoint
			FROM `users`
				LEFT JOIN
					`introductions`
					ON
					`users`.`id` = `introductions`.`user_id`
					AND
					`introductions`.`introduced_user_id` = :introduced_user_id
			WHERE `users`.`id` != :introduced_user_id
			ORDER BY goodpoint desc',
			\DB::SELECT
		);
		$users = $query->bind('introduced_user_id', $introduced_user_id)->execute();

		unset($query);

		$query = \DB::query(
			"SELECT `introductions`.*
			FROM `users`
				LEFT JOIN
					`introductions`
					ON
					`users`.`id` = `introductions`.`user_id`
					AND
					`introductions`.`user_id` = ". $introduced_user_id . "
					AND
					`introductions`.`introduced_user_id` != ". $introduced_user_id .
					" WHERE `users`.`id` = ". $introduced_user_id
				,
					\DB::SELECT
		);
		$my_relations = $query->execute();
		$bond = array();
		foreach ($my_relations as $key => $intro) {
			$bond[$intro['introduced_user_id']] = (int)$intro['distance'];
		}
		$data = array();
		$data['default']['nodes'] = array();
		$data['default']['links'] = array();
		$data['default']['introductions'] = array();

		$nodes_i = 1;
		$data['default']['nodes'][] = array(
			'name' => $introduced_user['name'],
			'size' => 80,
			'id' => (int)$introduced_user['id'],
			'url' => $introduced_user['url'],
			'nodetype' => 'person',
			'fixed' => true,
			'x' => 600,
			'y' => 350
		);

		$links = array();

		foreach ($users as $key => $user) {
			if (empty($user['id'])) {
				continue;
			}
			$nodes_i++;
			$links[(int)$user['user_id']] = $nodes_i;
			$data['default']['nodes'][] = array(
				'name' => $user['name'],
				'size' => 80,
				'id' => (int)$user['user_id'],
				'url' => $user['url'],
				'nodetype' => 'person'
			);


			$bondStrength = (!empty($bond[(int)$user['user_id']])) ? $bond[(int)$user['user_id']] : 0;
			$bondStrength = $bondStrength + (int)$user['distance'];
			if ($bondStrength >= 10) {
				$bondType = 3;
			}elseif($bondStrength >= 7) {
				$bondType = 2;
			} else {
				$bondType = 1;
			}
			$data['default']['links'][] = array(
				'source' => $nodes_i - 1,
				'target' => 0,
				'bondType' => $bondType,
				'text' => $user['feature'],
				'id' => 1000 + $user['id']
			);


		}

		foreach ($users as $key => $user) {
			if (empty($user['id'])) {
				continue;
			}
			$nodes_i++;
			$bondType = (!empty($bond[(int)$user['introduced_user_id']])) ? (int)$user['introduced_user_id'] : 0;
			$bondType = $bondType + (int)$user['distance'];
			$data['default']['nodes'][] = array(
				'name' => '紹介',
				'size' => 150,
				'id' => (int)$user['user_id'] + 1000,
				'introduced' => array(
					'feature' => $user['feature'],
                    'charm' => $user['charm'],
                    'skilfull' => $user['skillfull'],

				),
				'nodetype' => 'introduced'
			);

			$data['default']['introductions'][] = array(
				'id' => (int)$user['user_id'] + 1000,
				'div' => $this->intro_dl($user),
				'bondType' => $bondType

			);

			$data['default']['links'][] = array(
				'source' => $nodes_i - 1,
				'target' => $links[(int)$user['user_id']] - 1,
				'bondType' => 0,
				'text' => '',
				'id' => 10000 + $user['id']
			);

		}


		$response = new Response();
		$response->set_header('Content-type', 'application/json');
		$response->send_headers();

		return Response::forge(View::forge('user/relationjson', array('data' => $data)));
	}

	public function intro_dl($user)
	{
		$distance = array(6=>'とても親しい', 5=>'親しい', 4=>'おつきあいがある', 3=>'何度かお話したことがある', 2=>'挨拶程度', 1=>'まだ挨拶した事が無い', 0=>'知らない');

		$ret =<<<EOD
					<dl>
  						<dt>どんな人？</dt>
  						<dd>{$user['feature']}</dd>
  						<dt>関係性は？</dt>
  						<dd>{$distance[$user['distance']]}</dd>
 						<dt>魅力は？</dt>
  						<dd>{$user['charm']}</dd>
 						<dt>どうして？</dt>
  						<dd>{$user['charm_why']}</dd>
 						<dt>何が得意？</dt>
  						<dd>{$user['skillfull']}</dd>
 						<dt>どうして？</dt>
  						<dd>{$user['skillfull_why']}</dd>
 						<dt>期待していること</dt>
  						<dd>{$user['expectation']}</dd>
					</dl>

EOD;
return $ret;
	}

	/**
	 * View relation diagram.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_relationdiagram($introduced_user_id)
	{

		$me = Session::get('user', null);
		$introduced_user = Model_User::find($introduced_user_id);
		return Response::forge(View::forge('user/relationdiagram', array('me' => $me, 'introduced_user' => $introduced_user, 'introduced_user_id' => $introduced_user_id)));
	}

	/**
	 * Eash login
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_set($id)
	{
		$user = Model_User::find($id);
		if (!empty($user)) {
			Session::set('user', $user);
			Response::redirect('/');
		} else {
			return Response::forge(Presenter::forge('/defult/default/404'), 404);
		}

	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_logout()
	{
		Session::set('user', null);

		Response::redirect('/');
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_contribute()
	{
		$me = Session::get('user', null);


		$query = \DB::query(
			"SELECT `users`.`id` as `post_user_id`, `users`.`url`, `users`.`name`, `introductions`.*,
			(`introductions`.`distance` + `introductions`.`humanity`+ `introductions`.`ability`) as goodpoint
			 FROM `users`
				LEFT JOIN
					`introductions`
					ON
					`users`.`id` = `introductions`.`introduced_user_id`
					AND
					`introductions`.`user_id` = ". $me['id'] 
				 ." ORDER BY goodpoint desc"
				,
					\DB::SELECT
		);
		$users = $query->execute();

		return Response::forge(View::forge('user/contribute', array('users' => $users, 'me' => $me)));

		$view = View::forge('user/contribute');
		$view->users = $users;
		$view->me = $user;
		return $view;

	}


	public function action_introduction($user_id, $introduced_user_id)
	{
		$user = Session::get('user', null);
		$intro = Input::post();
		unset($intro['submit']);
		$result = Model_Introduction::find( 'first',
			array(
					'where' => array(
					array('user_id' => $user_id, 'introduced_user_id' => $introduced_user_id)
					)
					)
				);
		$intro['id'] = $result['id'];
		unset($result);
		if (empty($intro['id'])) {
			unset($intro['id']);
			$new = Model_Introduction::forge($intro);
			$new->save();
			//var_dump("1", DB::last_query());exit;

		} else {
			unset($result);
			$entry = Model_Introduction::find($intro['id']);
			//var_dump($entry, $intro);exit;
			$entry->set($intro);
			$entry->save();
		}
			//var_dump("2", DB::last_query());exit;
		Response::redirect('user/contribute#introduction_'. $introduced_user_id);
	}

	public function action_profile($introduced_user_id)
	{
		$me = Session::get('user', null);

		$query = \DB::query(
			"SELECT `users`.`id` as `post_user_id`, `users`.`url`, `users`.`name`, `introductions`.* FROM `users`
				LEFT JOIN
					`introductions`
					ON
					`users`.`id` = `introductions`.`introduced_user_id`
					AND
					`introductions`.`user_id` = ". $introduced_user_id .
					" WHERE `users`.`id` = ". $introduced_user_id 
				,
					\DB::SELECT
		);
		$introduced_user = $query->execute();

		return Response::forge(View::forge('user/profile', array('introduced_user' => $introduced_user[0], 'me' => $me, 'introduced_user_id' => $introduced_user_id)));

	}

	public function action_sharedprofile($introduced_user_id)
	{
		$me = Session::get('user', null);
		$introduced_user = Model_User::find($introduced_user_id);
		$query = \DB::query(
			"SELECT `users`.`id` as `post_user_id`, `users`.`url`, `users`.`name`, `introductions`.*,
			(`introductions`.`distance` + `introductions`.`humanity`+ `introductions`.`ability`) as goodpoint
			FROM `users`
				LEFT JOIN
					`introductions`
					ON
					`users`.`id` = `introductions`.`user_id`
					AND
					`introductions`.`introduced_user_id` = ". $introduced_user_id .
					" WHERE `users`.`id` != ". $introduced_user_id.
					" ORDER BY goodpoint desc"
				,
					\DB::SELECT
		);
		$users = $query->execute();

		return Response::forge(View::forge('user/sharedprofile', array('users' => $users, 'me' => $me, 'introduced_user' => $introduced_user, 'introduced_user_id' => $introduced_user_id)));

	}

}
