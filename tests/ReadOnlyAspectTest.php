<?php
	/**
	 * Created by PhpStorm.
	 * User: franco
	 * Date: 2015/04/17
	 * Time: 7:58 AM
	 */

	/**
	 * Class AccountBalanceSaleFormTest
	 * @package
	 */
	class ReadOnlyAspectTest extends SapphireTest
	{

		protected $extraDataObjects = array(
			'UserLoginTest',
		);


		public function testBeforeMethodsCalled()
		{
			// Test preparation of equivalent statements
			$rowCount = UserLoginTest::get()
									 ->count();
			$this->assertEquals(0, $rowCount);

		}

		public function testBeforeMethodBlocks()
		{
			$injector = Injector::inst();
			//First testWrites are blocked
			UserLoginTest::create()
						 ->write();

			$this->assertEquals(
				1, UserLoginTest::get()
								->count()
			);

		}
	}

	/**
	 * Class UserLoginTest
	 * @package
	 *
	 * @property int    Visit
	 * @property string IPAddress
	 *
	 */
	class    UserLoginTest extends DataObject implements TestOnly
	{
		static $db = array(
			'IPAddress' => 'Varchar(50)',
		);

		static $indexes = array();

		static $has_one = array();

		static $has_many = array();

		public function getCMSFields()
		{
			$fields = parent::getCMSFields();

			return $fields;
		}

		public function getFrontEndFields($params = NULL)
		{
			$fields = parent::getFrontEndFields($params);

			return $fields;
		}

		public function onBeforeWrite()
		{
			parent::onBeforeWrite();
			if(!$this->ID)
			{
				$this->IPAddress = $_SERVER['REMOTE_ADDR'];
			}
		}

		public function onAfterWrite()
		{
			parent::onAfterWrite();
		}
	}

