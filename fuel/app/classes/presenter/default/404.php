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
 * The welcome 404 presenter.
 *
 * @package  app
 * @extends  Presenter
 */
class Presenter_Default_404 extends Presenter
{
	/**
	 * Prepare the view data, keeping this in here helps clean up
	 * the controller.
	 *
	 * @return void
	 */
	public function view()
	{
		$messages = array('Aw, crap!', 'Bloody Hell!', 'Uh Oh!', 'Nope, not here.', 'Huh?');
		$this->title = $messages[array_rand($messages)];
	}
}
