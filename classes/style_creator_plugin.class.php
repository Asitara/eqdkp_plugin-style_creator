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
		
		public function getLessVars($format_simple=false){
			$style = $this->user->style;
			
			/*
			$arrLessVars = ['environment' => [
				'eqdkpURL' => [
					'value' => '"'.$this->env->link.'"',
				],
				'eqdkpGame' => [
					'value' => '"'.$this->config->get('default_game').'"',
				],
				'eqdkpServerPath' => [
					'value' => '"'.$this->server_path.'"',
				],
				'eqdkpRootPath' => [
					'value' => '"'.$this->root_path.'"',
				],
				'eqdkpImagePath' => [
					'value' => '"'.$this->root_path.'images/"',
				],
				'eqdkpImageURL' => [
					'value' => '"'.$this->env->link.'images/"',
				],
				'eqdkpTemplatePathLess' => [
					'value' => '"./templates/'.$style['template_path'].'/"',
				],
				'eqdkpTemplateImagePath' => [
					'value' => '"'.$this->root_path.'templates/'.$style['template_path'].'/images/"',
				],
				'eqdkpTemplateImageURL' => [
					'value' => '"'.$this->env->link.'templates/'.$style['template_path'].'/images/"',
				],
				'eqdkpTemplateBanner' => [
					'value' => '"'.$this->replaceSomePathVariables($style['banner_img'], $this->root_path, $style['template_path']).'"',
				],
				'eqdkpBannerImage' => [
					'value' => '"'.$this->replaceSomePathVariables($style['banner_img'], $this->root_path, $style['template_path']).'"',
				],
				'eqdkpTemplateBackground' => [
					'value' => '"'.$this->replaceSomePathVariables($this->getStyleBackgroundImage(), $this->root_path, $style['template_path']).'"',
				],
				'eqdkpBackgroundImage' => [
					'value' => '"'.$this->replaceSomePathVariables($this->getStyleBackgroundImage(), $this->root_path, $style['template_path']).'"',
				],
				'eqdkpBackgroundImagePosition' => [
					'value' => (($style['background_pos'] == 'normal')? 'scroll' : 'fixed'),
				],
				'eqdkpPortalWidth' => [
					'value' => ($style['portal_width'] != '')? $style['portal_width'] : '900px',
				],
				'eqdkpColumnLeftWidth' => [
					'value' => ($style['column_left_width'] != '')? $style['column_left_width'] : '200px',
				],
				'eqdkpColumnRightWidth' => [
					'value' => ($style['column_right_width'] != '')? $style['column_right_width'] : '200px',
				],
				'eqdkpPortalWidthWithoutBothColumns' => [
					'value' => (intval($style['portal_width']) - intval($style['column_left_width']) - intval($style['column_right_width'])).((strpos($style['portal_width'], '%') !== false)? '%' : 'px'),
				],
				'eqdkpPortalWidthWithoutLeftColumn' => [
					'value' => (intval($style['portal_width']) - intval($style['column_left_width'])).((strpos($style['portal_width'], '%') !== false)? '%' : 'px'),
				],
			]];
			*/
			
			// Add Core/Environment variables
			$arrLessVars = ['environment' => [
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
				'eqdkpTemplateBackground' 			=> '"'.$this->replaceSomePathVariables($this->getStyleBackgroundImage(), $this->root_path, $style['template_path']).'"',
				'eqdkpBackgroundImage' 				=> '"'.$this->replaceSomePathVariables($this->getStyleBackgroundImage(), $this->root_path, $style['template_path']).'"',
				'eqdkpBackgroundImagePosition'		=> (($style['background_pos'] == 'normal')? 'scroll' : 'fixed'),
				'eqdkpPortalWidth' 					=> ($style['portal_width'] != '')? $style['portal_width'] : '900px',
				'eqdkpColumnLeftWidth' 				=> ($style['column_left_width'] != '')? $style['column_left_width'] : '200px',
				'eqdkpColumnRightWidth' 			=> ($style['column_right_width'] != '')? $style['column_right_width'] : '200px',
				'eqdkpPortalWidthWithoutBothColumns' => (intval($style['portal_width']) - intval($style['column_left_width']) - intval($style['column_right_width'])).((strpos($style['portal_width'], '%') !== false)? '%' : 'px'),
				'eqdkpPortalWidthWithoutLeftColumn'	=> (intval($style['portal_width']) - intval($style['column_left_width'])).((strpos($style['portal_width'], '%') !== false)? '%' : 'px'),
			]];
			foreach($arrLessVars['environment'] as $strVarName => $strVarValue) $arrLessVars['environment'][$strVarName] = ['value' => $strVarValue];
			
			// Add Style variables
			foreach($this->styles->styleOptions() as $strCategory => $arrCategoryVars){
				foreach($arrCategoryVars as $strVarName => $strVarType){
					if($strVarName == 'body_font_size'){
						$arrLessVars[$strCategory][$this->styles->convertNameToLessVar($strVarName)] = [
							'value'	=> (isset($style[$strVarName]) && strlen($style[$strVarName]))? $style[$strVarName].'px' : '13px',
							'type'	=> $strVarType,
						];
						continue;
					}
					$arrLessVars[$strCategory][$this->styles->convertNameToLessVar($strVarName)] = [
						'value'	=> (isset($style[$strVarName]) && strlen($style[$strVarName]))? $this->replaceSomePathVariables($style[$strVarName]) : ((stripos($strVarName, 'color'))? '#000' : '""'),
						'type'	=> $strVarType,
					];
				}
			}
			
			// Add Game variables
			foreach($this->game->get_primary_classes() as $intClassID => $strClassName){
				$arrLessVars['game']['eqdkpClasscolor'.$intClassID] = [
					'value'	=> ($this->game->get_class_color($class_id) != '') ? $this->game->get_class_color($class_id) : "''",
					'type'	=> 'color',
					'label'	=> '"'.$strClassName.'"',
				];
			}
			
			// Change format
			if($format_simple){
				$arrFormatted = [];
				foreach($arrLessVars as $strCategory => $arrCategoryVars){
					foreach($arrCategoryVars as $strVarName => $arrVarData){
						$arrFormatted[$strVarName] = $arrVarData['value'];
					}
				}
				$arrLessVars = &$arrFormatted;
			}
			
			
			// d($arrLessVars);die;
			
			
			return $arrLessVars;
		}
		
		public function init(){
			
			
		}
		
		public function load(){
			
			$strHeadInjection = '
				<!-- <link href="{TEMPLATE_PATH}/'.$this->user->style['template_path'].'.css" type="text/css" rel="stylesheet/less" /> -->
				<style id="scp_less_src">
					@import (less) "{TEMPLATE_PATH}/'.$this->user->style['template_path'].'.css";
					'.strip_tags($this->user->style['additional_less']).';
					@import (less, optional) "{TEMPLATE_PATH}/custom.css";
				</style>
				<style id="scp_less_dist" type="text/less">
					@import (less) "{TEMPLATE_PATH}/'.$this->user->style['template_path'].'.css";
					'.strip_tags($this->user->style['additional_less']).';
					@import (less, optional) "{TEMPLATE_PATH}/custom.css";
				</style>
				
				
				<script>
					less = {
						env: "development",
						useFileCache: false,
						// async: true,
						// fileAsync: true,
						// poll: 1000,
						// relativeUrls: true,
						// rootpath: "",
						// errorReporting: function(a,b,c){ console.log(a,b,c); },
						globalVars: '.json_encode($this->getLessVars(true)).',
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
		
		private function getStyleBackgroundImage(){
			$style = $this->user->style;
			$template_background_file = '';
			
			switch($style['background_type']){
				case 1: //Game
					$template_background_file = $this->root_path.'games/'.$this->config->get('default_game').'/template_background.jpg';
					break;
					
				case 2: //Own
					if($style['background_img'] != ''){
						if(strpos($style['background_img'],'://') > 1) $template_background_file = $style['background_img'];
						else $template_background_file = $this->root_path.$style['background_img'];
					}
					break;
					
				default: //Style
					if(is_file($this->root_path.'templates/'.$style['template_path'].'/images/template_background.png'))
						$template_background_file = $this->root_path.'templates/'.$style['template_path'].'/images/template_background.png';
					else $template_background_file = $this->root_path.'templates/'.$style['template_path'].'/images/template_background.jpg';
			}
			
			return ($template_background_file != '')? $template_background_file : $root_path.'games/'.$this->config->get('default_game').'/template_background.jpg';
		}
	}
}