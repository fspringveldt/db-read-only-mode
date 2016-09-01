<?php

	/**
	 * Class UserLogin
	 * @package
	 *
	 * @property int    Visit
	 * @property string IPAddress
	 *
	 */
	class UserLogin extends DataObject
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

