<?php
	/**
	 * Created by PhpStorm.
	 * User: francospringveldt
	 * Date: 2016/09/01
	 * Time: 12:58 PM
	 */

	/**
	 * Class DBOverride
	 * @package SilverStripe\mysite\code\classes
	 */
	class DBOverride extends DB
	{
		public static function set_conn( $connection, $name = 'default')
		{
			parent::set_conn($connection, $name);
		}


	}