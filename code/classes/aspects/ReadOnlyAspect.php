<?php

	/**
	 * Class ReadOnlyAspect
	 *
	 * A simple BeforeCallAspect which disables and ddl or write operations from executing
	 * if ReadOnlyMode is set to active.
	 */
	class ReadOnlyAspect implements BeforeCallAspect
	{
		/**
		 * @var bool
		 */
		public $activate;

		/**
		 * @var
		 */
		public $throwExceptions;

		/**
		 * Before call aspect which silently dis-allows write requests
		 *
		 * @param MySQLDatabase $proxied
		 * @param string        $method
		 * @param string        $args
		 * @param mixed         $alternateReturn
		 *
		 * @return bool
		 */
		public function beforeCall($proxied, $method, $args, &$alternateReturn)
		{
			//Re-use $proxied->getConnector() to check if the query is mutable
			$connector = $proxied->getConnector();
			if($this->activate)
			{
				if(isset($args[0]))
				{
					$sql = $args[0];
					if($connector->isQueryMutable($sql))
					{
						if($this->throwExceptions)
						{
							throw new Exception(_t('ReadOnlyDBMode', 'Unable to write as the site is in ReadOnly mode'));
						}else
						{
							//Softly return a zero
							$alternateReturn = 0;
						}

						return false;
					}
				}
			}
		}
	}