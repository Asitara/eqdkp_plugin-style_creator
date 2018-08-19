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

if(!defined('EQDKP_INC')) die('Do not access this file directly.');

if(!class_exists('style_creator_plugin')){
	class style_creator_plugin extends gen_class {
		public function __construct(){}
		
		public function getLessVars(){
			$style = $this->user->style;
			
			$template_background_file = '';
			switch($style['background_type']){
				case 1: //Game
					$template_background_file = $this->root_path.'games/'.$this->config->get('default_game').'/template_background.jpg';
					break;
					
				case 2: //Own
					if($style['background_img'] != ''){
						if (strpos($style['background_img'],'://') > 1) $template_background_file = $style['background_img'];
						else $template_background_file = $this->root_path.$style['background_img'];
					}
					break;
					
				default: //Style
					if(is_file($this->root_path.'templates/'.$style['template_path'].'/images/template_background.png'))
						$template_background_file = $this->root_path.'templates/'.$style['template_path'].'/images/template_background.png';
					else $template_background_file = $this->root_path.'templates/'.$style['template_path'].'/images/template_background.jpg';
			}
			if($template_background_file == '') $template_background_file = $root_path.'games/'.$this->config->get('default_game').'/template_background.jpg';
			
			$arrLessVars = [
				'eqdkpURL'							=> '"'.$this->env->link.'"',
				'eqdkpGame'							=> '"'.$this->config->get('default_game').'"',
				'eqdkpServerPath'					=> '"'.$this->server_path.'"',
				'eqdkpRootPath'						=> '"'.$this->root_path.'"',
				'eqdkpImagePath'					=> '"'.$this->root_path.'images/"',
				'eqdkpImageURL'						=> '"'.$this->env->link.'images/"',
				'eqdkpTemplatePathLess' 			=> '"./templates/'.$style['template_path'].'/"',
				'eqdkpTemplateImagePath' 			=> '"'.$this->root_path.'templates/'.$style['template_path'].'/images/"',
				'eqdkpTemplateImageURL'				=> '"'.$this->env->link.'templates/'.$style['template_path'].'/images/"',
				'eqdkpTemplateBanner' 				=> '"'.$this->replaceSomePathVariables($style['banner_img'], $this->root_path, $style['template_path']).'"',
				'eqdkpBannerImage' 					=> '"'.$this->replaceSomePathVariables($style['banner_img'], $this->root_path, $style['template_path']).'"',
				'eqdkpTemplateBackground' 			=> '"'.$this->replaceSomePathVariables($template_background_file, $this->root_path, $style['template_path']).'"',
				'eqdkpBackgroundImage' 				=> '"'.$this->replaceSomePathVariables($template_background_file, $this->root_path, $style['template_path']).'"',
				'eqdkpBackgroundImagePosition'		=> (($style['background_pos'] == 'normal') ? 'scroll' : 'fixed'),
				'eqdkpPortalWidth' 					=> ($style['portal_width'] != '') ? $style['portal_width'] : '900px',
				'eqdkpColumnLeftWidth' 				=> ($style['column_left_width'] != '') ? $style['column_left_width'] : '200px',
				'eqdkpColumnRightWidth' 			=> ($style['column_right_width'] != '') ? $style['column_right_width'] : '200px',
				'eqdkpPortalWidthWithoutBothColumns' => (intval($style['portal_width']) - intval($style['column_left_width']) - intval($style['column_right_width'])).((strpos($style['portal_width'], '%') !== false) ? '%' : 'px'),
				'eqdkpPortalWidthWithoutLeftColumn'	=> (intval($style['portal_width']) - intval($style['column_left_width'])).((strpos($style['portal_width'], '%') !== false) ? '%' : 'px'),
			];
			
			foreach($this->styles->styleOptions() as $key => $val){
				foreach($val as $name => $type){
					if($name == 'body_font_size') {
						$arrLessVars[$this->styles->convertNameToLessVar($name)] = (isset($style[$name]) && strlen($style[$name])) ? $style[$name].'px' : '13px';
						continue;
					}
					$arrLessVars[$this->styles->convertNameToLessVar($name)] = (isset($style[$name]) && strlen($style[$name])) ? $this->replaceSomePathVariables($style[$name]) : ((stripos($name, 'color')) ? '#000' : '""');
				}
			}
			
			$arrGameClasses = $this->game->get_primary_classes([], 'english');
			if(isset($arrGameClasses) && is_array($arrGameClasses)){
				$strClassColorList = '';
				foreach($arrGameClasses as $class_id => $class_name) {
					$strClassColor = ($this->game->get_class_color($class_id) != '') ? $this->game->get_class_color($class_id) : "''";
					$arrLessVars['eqdkpClasscolor'.$class_id] = $strClassColor;
					$strClassColorList .= $class_id." '".addcslashes(strtolower($class_name), "'")."' ".$strClassColor.", ";
				}
				$arrLessVars['eqdkpGameClasses'] = $strClassColorList;
			}else{
				$arrLessVars['eqdkpGameClasses'] = "''";
			}
			
			//NOTE: Finde eine lösung bzg $style['additional_less'] welches irwie interpretiert werden muss seitens LESS...
			//		In der Theorie würde ich sagen, einfach als <style> mit ausgeben
			
			// d($arrLessVars);
			return $arrLessVars;
		}
		
		public function addStyleFiles(){
			
			$strGlobalVars = ' ';
			foreach($this->getLessVars() as $var_name => $var_value){
				$strGlobalVars .= "'".$var_name."':'".$var_value."',";
			}
			
			$strHeadInjection = '
				<link href="{TEMPLATE_PATH}/'.$this->user->style['template_path'].'.css" type="text/css" rel="stylesheet/less" />
				<style></style>
				<script>
					less = {
						env: "development",
						async: true,
						fileAsync: true,
						poll: 1000,
						globalVars: '.json_encode($this->getLessVars()).',
					};
					additional_less = '.json_encode($this->user->style['additional_less']).';
				</script>
				<script src="{EQDKP_ROOT_PATH}plugins/style_creator/less/less.js"></script>
			';
			$this->tpl->add_listener('head', $strHeadInjection, true);
		}
		
		private function replaceSomePathVariables($strVar){
			$arrSearch = ['@eqdkpURL', '@eqdkpServerPath', '@eqdkpRootPath', '@eqdkpImagePath', '@eqdkpTemplateImagePath'];
			$arrReplace = [$this->env->link, $this->server_path, $this->root_path, $this->root_path.'images/', $this->root_path.'templates/'.$this->user->style['template_path'].'/images/'];
			return str_replace($arrSearch, $arrReplace, $strVar);
		}
	}
}