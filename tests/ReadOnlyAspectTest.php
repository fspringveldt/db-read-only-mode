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

		protected $extraDataObjects = array(
			'MySQLDatabaseTest_Data',
		);

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
			$connector = DB::get_connector();
			// Test preparation of equivalent statements


			// Also select non-prepared statement
			$result3 = $connector->query("INSERT INTO \"MySQLDatabaseTest_Data\" (\"Sort\", \"Title\") Values (6,'Sixth Item')");

			$this->assertEquals(0, $result3);

		}
	}