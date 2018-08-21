<?php
/*	Project:	EQdkp-Plus
 *	Package:	Style Creator Plugin
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2018 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if (!defined('EQDKP_INC')){ header('HTTP/1.0 404 Not Found'); exit; }

class style_creator extends plugin_generic {
	public $version    = '0.0.1';
	public $build      = '';
	public $copyright  = 'Asitara';
	public $vstatus    = 'Beta';
	protected static $apiLevel = 23;
	
	public function __construct() {
		parent::__construct();
		
		$this->add_data([
			'name'              => 'Style Creator',
			'code'              => 'style_creator',
			'path'              => 'style_creator',
			// 'contact'           => '',
			// 'template_path'     => 'plugins/style_creator/templates/',
			'icon'              => 'fa fa-list-alt',
			'version'           => $this->version,
			'author'            => $this->copyright,
			'description'       => $this->user->lang('scp_short_desc'),
			'long_description'  => $this->user->lang('scp_long_desc'),
			'homepage'          => 'https://eqdkp-plus.eu/forum/index.php/User/476-assasinen/',
			'manuallink'        => 'https://eqdkp-plus.eu/wiki/Plugin:_Style_Creator',
			'plus_version'      => '2.3',
			'build'             => $this->build,
		]);
		$this->add_dependency([
			'plus_version'      => '2.3'
		]);
		
		// -- Register Permissions ----------------------------
		// permissions: 'a'=admins, 'u'=user
		// ('a'/'u', Permission-Name, Enable? 'Y'/'N', Language string, array of user-group-ids that should have this permission)
		// Groups: 1 = Guests, 2 = Super-Admin, 3 = Admin, 4 = Member
		// $this->add_permission('a', 'main', 'N', $this->user->lang('dynamictemplate_main_settings'), array(2,3));
		
		// -- Classes -----------------------------------------
		registry::add_class('style_creator_plugin', 'plugins/style_creator/classes/', 'scp');

		// -- PDH Modules -------------------------------------
		// $this->add_pdh_read_module('dynamictemplate');
		// $this->add_pdh_write_module('dynamictemplate');
		
		// -- Menu --------------------------------------------
		// $this->add_menu('admin', $this->gen_admin_menu());
		
		// -- Hooks -------------------------------------------
		$this->add_hook('portal', 'style_creator_portal_hook', 'portal');
	}
}