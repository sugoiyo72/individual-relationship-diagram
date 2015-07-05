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
 * The User Model.
 *
 * @package  app
 * @extends  Orm\Model
 */
class Model_User extends Orm\Model
{
	protected static $_table_name = 'users';
	protected static $_primary_key = array('id');
	protected static $_has_many = array('introductions');
}
