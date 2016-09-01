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
			$active = (bool)Config::inst()
								  ->get('ReadOnlyMode', 'activate');
			if($active)
			{
				if(isset($args[0]))
				{
					$sql = $args[0];
					if(in_array(strtolower(substr($sql, 0, strpos($sql, ' '))), $writeQueries))
					{
						$alternateReturn = 0;

						return false;
					}
				}
			}
		}
	}