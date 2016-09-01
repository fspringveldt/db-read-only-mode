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
		protected static $fixture_file = 'ReadOnlyAspectYaml.yml';


		public function testBeforeMethodsCalled()
		{
			// Test preparation of equivalent statements
			$connector = DB::get_connector();

			$result1 = $connector->preparedQuery(
				'SELECT "Sort", "Title" FROM "MySQLDatabaseTest_Data" WHERE "Sort" > ? ORDER BY "Sort"', array(0)
			);

			$this->assertInstanceOf('MySQLStatement', $result1);

			// Also select non-prepared statement
			$result3 = $connector->query('SELECT "Sort", "Title" FROM "MySQLDatabaseTest_Data" ORDER BY "Sort"');
			$this->assertInstanceOf('MySQLQuery', $result3);

		}

		public function testBeforeMethodBlocks()
		{
			Config::inst()
				  ->update('ReadOnlyMode', 'active', 1);
			// Test preparation of equivalent statements

			$obj = new UserLoginTest();
			$id = $obj->write();

			$this->assertEquals(0, $id);

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
	class UserLoginTest extends DataObject implements TestOnly
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

