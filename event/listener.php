<?php

/**
 * @package BBCode Icons
 * @copyright (c) 2024 Daniel James
 * @license https://opensource.org/license/gpl-2-0 GPL v2
 */

namespace danieltj\bbcodeicons\event;

use phpbb\db\driver\driver_interface as database;
use phpbb\template\template;
use phpbb\request\request;
use phpbb\language\language;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface {

	/**
	 * @var database
	 */
	protected $database;

	/**
	 * @var language
	 */
	protected $language;

	/**
	 * @var request
	 */
	protected $request;

	/**
	 * @var template
	 */
	protected $template;

	/**
	 * Constructor
	 */
	public function __construct( database $database, language $language, request $request, template $template ) {

		$this->database = $database;
		$this->language = $language;
		$this->request = $request;
		$this->template = $template;

	}

	/**
	 * Events
	 */
	static public function getSubscribedEvents() {

		return [
			'core.user_setup'							=> 'add_languages',
			'core.acp_bbcodes_edit_add'					=> 'add_acp_template_vars',
			'core.acp_bbcodes_modify_create'			=> 'update_acp_bbcode_data',
			'core.display_custom_bbcodes_modify_sql'	=> 'update_bbcode_sql_array',
			'core.display_custom_bbcodes_modify_row'	=> 'add_editor_template_vars',
			'core.display_custom_bbcodes'				=> 'delete_custom_tags_vars',
		];

	}

	/**
	 * Add languages
	 */
	public function add_languages( $event ) {

		$this->language->add_lang( [ 'common' ], 'danieltj/bbcodeicons' );

	}

	/**
	 * Add ACP template variables
	 */
	public function add_acp_template_vars( $event ) {

		$bbcode_font_icon = '';

		$sql = 'SELECT * FROM ' . BBCODES_TABLE . ' WHERE ' . $this->database->sql_build_array( 'SELECT', [
			'bbcode_id' => $event[ 'bbcode_id' ],
		] );

		$result = $this->database->sql_query( $sql );
		$bbcode = $this->database->sql_fetchrow( $result );
		$this->database->sql_freeresult( $result );

		if ( ! empty( $bbcode ) ) {

			$bbcode_font_icon = $bbcode[ 'bbcode_font_icon' ];

		}

		$this->template->assign_vars( [
			'BBCODE_FONT_ICON' => $bbcode_font_icon,
		] );

	}

	/**
	 * Update ACP SQL array
	 */
	public function update_acp_bbcode_data( $event ) {

		$bbcode_font_icon = $this->request->variable( 'bbcode_font_icon', '' );
		$bbcode_font_icon = substr( $bbcode_font_icon, 0, 50 );
		$bbcode_font_icon = preg_replace( "/[^A-Za-z0-9-]/", '', $bbcode_font_icon );

		$event[ 'sql_ary' ] = array_merge( $event[ 'sql_ary' ], [
			'bbcode_font_icon' => $bbcode_font_icon,
		] );

	}

	/**
	 * Add field to SQL array
	 */
	public function update_bbcode_sql_array( $event ) {

		$event[ 'sql_ary' ] = array_merge( $event[ 'sql_ary' ], [
			'SELECT' => $event[ 'sql_ary' ][ 'SELECT' ] . ', b.bbcode_font_icon',
		] );

	}

	/**
	 * Add icon to template variables
	 */
	public function add_editor_template_vars( $event ) {

		$event[ 'custom_tags' ] = array_merge( $event[ 'custom_tags' ], [
			'BBCODE_FONT_ICON' => $event[ 'row' ][ 'bbcode_font_icon' ],
		] );

		$custom_bbcodes = $event[ 'custom_tags' ];

		$this->template->assign_block_vars( 'custom_bbcodes', $custom_bbcodes );

	}

	/**
	 * Remove old BBCode template black variable
	 */
	public function delete_custom_tags_vars() {

		$this->template->destroy_block_vars( 'custom_tags' );

	}

}
