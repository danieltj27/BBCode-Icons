<?php

/**
 * @package BBCode Icons
 * @copyright (c) 2024 Daniel James
 * @license https://opensource.org/license/mit MIT
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
			'core.display_custom_bbcodes_modify_row'	=> 'update_editor_template_vars',
		];

	}

	/**
	 * Add langauge files
	 */
	public function add_languages( $event ) {

		$this->language->add_lang( [ 'common' ], 'danieltj/bbcodeicons' );

	}

	/**
	 * Add the ACP template vars
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
	 * Update the bbcode data for add/edit
	 */
	public function update_acp_bbcode_data( $event ) {

		// Clean the input
		$bbcode_font_icon = $this->request->variable( 'bbcode_font_icon', '' );
		$bbcode_font_icon = substr( $bbcode_font_icon, 0, 50 );
		$bbcode_font_icon = preg_replace( "/[^A-Za-z0-9-]/", '', $bbcode_font_icon );

		// Add to update array
		$event[ 'sql_ary' ] = array_merge( $event[ 'sql_ary' ], [
			'bbcode_font_icon' => $bbcode_font_icon,
		] );

	}

	/**
	 * Update the post editor template vars
	 */
	public function update_editor_template_vars( $event ) {

		$bbcode_id = $event[ 'row' ][ 'bbcode_id' ];

		$sql = 'SELECT * FROM ' . BBCODES_TABLE . ' WHERE ' . $this->database->sql_build_array( 'SELECT', [
			'bbcode_id' => $bbcode_id,
		] );

		$result = $this->database->sql_query( $sql );
		$bbcode = $this->database->sql_fetchrow( $result );
		$this->database->sql_freeresult( $result );

		if ( ! empty( $bbcode ) ) {

			$event[ 'custom_tags' ] = array_merge( $event[ 'custom_tags' ], [
				'BBCODE_FONT_ICON' => $bbcode[ 'bbcode_font_icon' ],
			] );

			$event[ 'row' ] = array_merge( $event[ 'row' ], [
				'bbcode_font_icon' => $bbcode[ 'bbcode_font_icon' ],
			] );

		}

	}

}
