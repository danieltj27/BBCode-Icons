<?php

/**
 * @package BBCode Icons
 * @copyright (c) 2024 Daniel James
 * @license https://opensource.org/license/gpl-2-0 GPL v2
 */

namespace danieltj\bbcodeicons;

class ext extends \phpbb\extension\base {

	/**
	 * Require version 3.3 or later.
	 */
	public function is_enableable() {

		$config = $this->container->get( 'config' );

		return phpbb_version_compare( $config[ 'version' ], '3.3.0', '>=' );

	}

}
