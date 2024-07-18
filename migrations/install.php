<?php

/**
 * @package BBCode Icons
 * @copyright (c) 2024 Daniel James
 * @license https://opensource.org/license/gpl-2-0 GPL v2
 */

namespace danieltj\bbcodeicons\migrations;

class install extends \phpbb\db\migration\migration {

	/**
	 * Require version 3.3 or later.
	 */
	static public function depends_on() {

		return [ '\phpbb\db\migration\data\v330\v330' ];

	}

	/**
	 * Add new column.
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
	 * Remove new column.
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
