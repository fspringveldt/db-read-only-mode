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
		 * @param object $proxied
		 * @param string $method
		 * @param string $args
		 * @param mixed  $alternateReturn
		 *
		 * @return bool
		 */
		public function beforeCall($proxied, $method, $args, &$alternateReturn)
		{
			$cfg = Config::inst();
			$ddl = $cfg->get('DBConnector', 'ddl_operations');
			$writes = $cfg->get('DBConnector', 'write_operations');

			$writeQueries = array_merge($ddl, $writes);
			if(!isset($this->activate))
			{
				$this->activate = (bool)Config::inst()
											  ->get('ReadOnlyMode', 'activate');
			}

			if(!isset($this->throwExceptions))
			{
				$this->throwExceptions = (bool)Config::inst()
													 ->get('ReadOnlyMode', 'throw-exceptions');
			}
			if($this->activate)
			{
				if(isset($args[0]))
				{
					$sql = $args[0];
					$command = strtolower(substr($sql, 0, strpos($sql, ' ')));
					if(in_array($command, $writeQueries))
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