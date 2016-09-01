<?php

	class ReadOnlyAspect implements BeforeCallAspect
	{

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