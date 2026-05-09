<?php

/**
 * @package BBCode Icons
 * @copyright (c) 2026 Daniel James
 * @license https://opensource.org/license/gpl-2-0
 */

namespace danieltj\bbcodeicons;

class ext extends \phpbb\extension\base {

	/**
	 * Check version compatibility.
	 */
	public function is_enableable() {

		$config = $this->container->get( 'config' );

		return phpbb_version_compare( $config[ 'version' ], '3.3.0', '>=' ) && phpbb_version_compare( $config[ 'version' ], '4.0.0', '<' );

	}

}
