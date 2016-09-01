<?php

	/**
	 * Created by PhpStorm.
	 * User: francospringveldt
	 * Date: 2016/09/01
	 * Time: 7:04 PM
	 *
	 *
	 * Classes which implement this interface are still allowed to write
	 * regardless of whether the site is in readOnlyMode or not. It will be
	 * injected somehow
	 */
	interface IAllowWriteInReadOnlyMode
	{
		//@todo: Write mechanism to use this class to allow DataObjects to skip the ReadOnly mode and continue writing
	}