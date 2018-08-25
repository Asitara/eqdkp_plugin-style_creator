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
		
		public $allowed_variables = [
			'eqdkpAttendeesColumns',
			'eqdkpLogoPosition',
			'eqdkpFaviconImg',
			'eqdkpBannerImg',
			'eqdkpBackgroundImg',
			'eqdkpBackgroundPos',
			'eqdkpBackgroundType',
			'eqdkpColumnLeftWidth',
			'eqdkpColumnRightWidth',
			'eqdkpPortalWidth',
			'eqdkpBodyBackgroundColor',
			'eqdkpBodyFontColor',
			'eqdkpBodyFontSize',
			'eqdkpBodyFontFamily',
			'eqdkpBodyLinkColor',
			'eqdkpBodyLinkColorHover',
			'eqdkpBodyLinkDecoration',
			'eqdkpContainerBackgroundColor',
			'eqdkpContainerBorderColor',
			'eqdkpContentBackgroundColor',
			'eqdkpContentFontColor',
			'eqdkpContentFontColorHeadings',
			'eqdkpContentLinkColor',
			'eqdkpContentLinkColorHover',
			'eqdkpContentBorderColor',
			'eqdkpContentAccentColor',
			'eqdkpContentContrastColor',
			'eqdkpContentContrastBackgroundColor',
			'eqdkpContentContrastBorderColor',
			'eqdkpContentHighlightColor',
			'eqdkpContentPositiveColor',
			'eqdkpContentNegativeColor',
			'eqdkpContentNeutralColor',
			'eqdkpUserareaBackgroundColor',
			'eqdkpUserareaFontColor',
			'eqdkpUserareaLinkColor',
			'eqdkpUserareaLinkColorHover',
			'eqdkpTableThBackgroundColor',
			'eqdkpTableThFontColor',
			'eqdkpTableTrFontColor',
			'eqdkpTableTrBackgroundColor1',
			'eqdkpTableTrBackgroundColor2',
			'eqdkpTableTrBackgroundColorHover',
			'eqdkpTableBorderColor',
			'eqdkpMenuBackgroundColor',
			'eqdkpMenuFontColor',
			'eqdkpMenuItemBackgroundColor',
			'eqdkpMenuItemBackgroundColorHover',
			'eqdkpMenuItemFontColorHover',
			'eqdkpSidebarBackgroundColor',
			'eqdkpSidebarFontColor',
			'eqdkpSidebarBorderColor',
			'eqdkpButtonBackgroundColor',
			'eqdkpButtonFontColor',
			'eqdkpButtonBorderColor',
			'eqdkpButtonBackgroundColorHover',
			'eqdkpButtonFontColorHover',
			'eqdkpButtonBorderColorHover',
			'eqdkpInputBackgroundColor',
			'eqdkpInputBorderColor',
			'eqdkpInputFontColor',
			'eqdkpInputBackgroundColorActive',
			'eqdkpInputBorderColorActive',
			'eqdkpInputFontColorActive',
			'eqdkpMiscColor1',
			'eqdkpMiscColor2',
			'eqdkpMiscColor3',
			'eqdkpMiscText1',
			'eqdkpMiscText2',
			'eqdkpMiscText3',
			'eqdkpAdditionalLess',
			'eqdkpAdditionalFields',
			'eqdkpEditorTheme',
		];
		
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
				'eqdkpTemplatePath' 				=> '"./templates/'.$style['template_path'].'/"',
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
			
			$style_code = $this->user->style['template_path'];
			$style_path = $this->root_path.'templates/'.$style_code.'/';
			$arrLoadOrder = [
				['label'=>'core.css', 'load'=>true, 'code'=>'@import (less) "'.$this->root_path.'libraries/jquery/core/core.css";'],
				['label'=>'jquery.less', 'load'=>true, 'code'=>'@import (optional) "'.$style_path.'jquery.less";'],
				['label'=>'eqdkpplus.css', 'load'=>true, 'code'=>'@import (less) "'.$this->root_path.'templates/eqdkpplus.css";'],
				['label'=>$style_code.'.css', 'load'=>true, 'code'=>'@import (less) "'.$style_path.$style_code.'.css";'],
				['label'=>'additional_less (Style Settings)', 'load'=>true, 'code'=>'additional_less'],
				['label'=>'custom.css', 'load'=>true, 'code'=>'@import (less, optional) "'.$style_path.'custom.css";'],
			];
			
			$this->tpl->assign_vars([
				'SCP_LOAD'				=> false,
				'SCP_CSRF_TOKEN'		=> $this->user->csrfPostToken(),
				'SCP_GLOBAL_VARS'		=> json_encode($this->getLessVars(true)),
				'SCP_LOAD_ORDER'		=> json_encode($arrLoadOrder),
				'SCP_ADDITIONAL_LESS'	=> "'".str_replace("'", "\'", strip_tags($this->user->style['additional_less']))."'"
			]);
			
			if($this->in->exists('scp_toggle')) $this->toggle();
			
			// if($this->config->get('scp_enabled', 'style_creator')) $this->load();
			$this->loadPage();
			$this->tpl->css_file($this->root_path.'plugins/style_creator/templates/base_templates/style_creator.css');
			// $this->tpl->js_file($this->root_path.'plugins/style_creator/templates/base_templates/style_creator.js');
			$this->tpl->add_listener('body_bottom', file_get_contents($this->root_path.'plugins/style_creator/templates/base_templates/style_creator.tpl'), true);
		}
		
		public function loadPage(){
			
			foreach($this->getLessVars() as $strCategory => $arrCategoryVars){
				if($strCategory == 'environment') continue;
				
				$this->tpl->assign_block_vars('scp_style_settings', [
					'NAME'	=> $strCategory,
					'LABEL'	=> $this->user->lang('scp_style_settings_cat_'.$strCategory),
				]);
				
				foreach($arrCategoryVars as $strVarName => $arrVarData){
					if(!in_array($strVarName, $this->allowed_variables)) continue;
						
					$this->tpl->assign_block_vars('scp_style_settings.controls', [
						'NAME'	=> $strVarName,
						'LABEL'	=> $arrVarData['label'],
						'HELP'	=> $arrVarData['label'],
						'INPUT'	=> $this->genInput(array_merge($arrVarData, ['name' => $strVarName])),
					]);
				}
			}
			
		}
		
		private function genInput($arrVarData){
			
			$text_decoration = [
				'none'			=> 'none',
				'underline'		=> 'underline',
				'overline'		=> 'overline',
				'line-through'	=> 'line-through',
				'blink'			=> 'blink'
			];
			$border_style = [
				'none'		=> 'none',
				'hidden'	=> 'hidden',
				'dotted'	=> 'dotted',
				'dashed'	=> 'dashed',
				'solid'		=> 'solid',
				'double'	=> 'double',
				'groove'	=> 'groove',
				'ridge'		=> 'ridge',
				'inset'		=> 'inset',
				'outset'	=> 'outset'
			];
			// $width_options = [
			// 	'px'	=> 'px',
			// 	'%'		=> '%',
			// ];
			// $logo_positions = [
			// 	'center'=>	$this->user->lang('logo_position_center'),
			// 	'right'	=>	$this->user->lang('portalplugin_right'),
			// 	'left'	=>	$this->user->lang('portalplugin_left'),
			// 	'none'	=>	$this->user->lang('info_opt_ml_0'),
			// ];
			
			
			
			$arrUsedVariables = []; // TODO: Copy the manage_styles.php -> get_used_variables() :: to disable / hide some input fields
			
			
			$strHTML = '';
			$strPrefixedName = 'scp_style_var-'.$arrVarData['name'];
			
			switch($arrVarData['type']){
				case 'color':
						$strHTML .= (new htext($strPrefixedName, ['value' => $arrVarData['value'], 'size' => 14]))->output();
						$strHTML .= '<script>$(\'#'.$strPrefixedName.'\').spectrum('.json_encode([
							'disabled'				=> (!in_array($arrVarData['name'], $arrUsedVariables))? true : false,
							'showInput'				=> true,
							// 'showInitial'			=> true,
							'showAlpha'				=> true,
							'preferredFormat'		=> 'hex3',
							'showPalette'			=> true,
							'hideAfterPaletteSelect'=> true,
							'palette'				=> [
								['black', 'white', 'blanchedalmond'],
								['rgb(255, 128, 0);', 'hsv 100 70 50', 'lightyellow']
							],
							'showSelectionPalette'	=> true,
							// 'selectionPalette'		=> ["red", "green", "blue"],
							// 'localStorageKey'		=> 'plugins.style_creator.color_palette',
						]).');</script>';
					break;
				
				case 'decoration':
						$strHTML .= (new hdropdown($strPrefixedName, ['options' => $text_decoration, 'value' => $arrVarData['value'], 'disabled' => ((!in_array($arrVarData['name'], $arrUsedVariables))? true : false)]))->output();
					break;
				
				// case 'font-family':
				// 		$strHTML = (new htext($strPrefixedName, ['value' => sanitize($arrVarData['value']), 'size' => 30, 'disabled' => ((!in_array($name, $arrUsedVariables))? true : false)]))->output();
				// 	break;
				
				case 'size':
						$strHTML .= (new htext($name, ['value' => sanitize($this->style[$name]), 'size' => 3, 'after_txt' => 'px', 'disabled' => ((!in_array($name, $arrUsedVariables))? true : false)]))->output();
					break;
				
				default:
					$strHTML .= (new htext($strPrefixedName, ['value' => sanitize($arrVarData['value']), 'size' => 30, 'disabled' => ((!in_array($name, $arrUsedVariables))? true : false)]))->output();
			}
			
			return $strHTML;
		}
		
		public function toggle($return=false){
			$error = true;
			
			$blnCSRF = $this->user->checkCsrfPostToken($this->in->get($this->user->csrfPostToken()));
			$blnCSRF = $blnCSRF || $this->user->checkCsrfPostToken($this->in->get($this->user->csrfPostToken(true)));
			if($blnCSRF){
				$this->config->set('scp_enabled', !$this->config->get('scp_enabled', 'style_creator'), 'style_creator');
				$error = false;
			}
			
			if($return) return !$error;
			die(json_encode(['error' => $error]));
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