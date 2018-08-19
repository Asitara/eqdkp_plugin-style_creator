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

if (!class_exists('style_creator_portal_hook')){
	class style_creator_portal_hook extends gen_class {
		public function portal(){
			// if($this->env->current_page == 'admin/manage_extensions'){
			// 	$this->tpl->add_js('
			// 	function toggleStyleCreator(){
			// 		sessionStorage.setItem("test", 1);
			// 	}
			// 	$(\'#plus_plugins_tab button[onclick$="create\'"]\').before(\'<button class="mainoption" type="button" onclick="toggleStyleCreator();"><i class="fa fa-plus" /> Style Creator (PLACEHOLDER)</button>\');
			// ');
			// }
			$this->scp->addStyleFiles();
			$this->tpl->css_file($this->root_path.'plugins/style_creator/templates/base_templates/style_creator.css');
			$this->tpl->add_listener('body_bottom', file_get_contents($this->root_path.'plugins/style_creator/templates/base_templates/style_creator.tpl'), true);
		}
		
	} //end class
} //end if class not exists

