<?php

/**
 * @package BBCode Icons
 * @copyright (c) 2024 Daniel James
 * @license https://opensource.org/license/mit MIT
 */

namespace danieltj\bbcodeicons\migrations;

class install extends \phpbb\db\migration\migration {

	/**
	 * Require at least 3.3.x version.
	 */
	static public function depends_on() {

		return [ '\phpbb\db\migration\data\v33x\v331rc1' ];

	}

	/**
	 * Install database changes
	 */
	public function update_schema() {

		return [
			'add_columns' => [
				$this->table_prefix . 'bbcodes' => [
					'bbcode_font_icon' => [
						'VCHAR:50', ''
					]
				],
			]
		];

	}

	/**
	 * Uninstall database changes
	 */
	public function revert_schema() {

		return [
			'drop_columns' => [
				$this->table_prefix . 'bbcodes' => [
					'bbcode_font_icon'
				],
			]
		];

	}

}
