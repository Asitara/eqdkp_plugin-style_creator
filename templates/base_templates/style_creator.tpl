
<script>
	
	var SCP, less;
	$(function(){
		SCP = {
			poll: 2000,								// public: delay for auto-refresh when watch_mode
			disable_style: true,						// public: disable original style
			
			load_order: {SCP_LOAD_ORDER},								// public: load order of less files
			include_less: { additional_less: {SCP_ADDITIONAL_LESS}, },	// public: include addiotnal less (see: load_order)
			
			_storage_key: 'plugins.style_creator.',	// private: localStorage key prefix
			_global_vars: {SCP_GLOBAL_VARS},		// private: global vars of style
			_watch_mode: false,						// private: state of watch_mode
			_watch_timer: null,						// private: ID of setTimeout when watch_mode
			_cache_disabled: false,					// private: state of xhr caching
			_style_disabled: false,					// private: state of original style
			_parse_time: 1000,						// private: parse time of current less process
			_last_delays: [],						// private: last delays of less parsing
			
			
			init: function(){
				SCP.toggleStyleSettings(true);
				
				SCP.disableCache();
				
				// Add executable style element to <head>
				$('html > head').append('<style id="scp_less_dist" type="text/less"></style>');
				SCP.genLessSrc();
				
				// Init less options
				less = {
					env: 'development',			// NOTE: maybe we can set it to production, we have own watch mode
					useFileCache: false,
					// errorReporting: self.errorHandler,
					plugins: [SCP._less_plugin],
					globalVars: SCP._global_vars,
				};
				
				// Load less with ajax (prevent: immediately execution)
				$.getScript( mmocms_root_path+'plugins/style_creator/less/less.js');
				
			},
			
			toggle: function(){
				$.post(mmocms_controller_path+mmocms_sid+'&scp_toggle', {'{SCP_CSRF_TOKEN}':'{SCP_CSRF_TOKEN}'},
					function(response){
						response = JSON.parse(response);
						if(!response.error) location.reload();
				});
				
				// TODO: wipe_data in localStorage => current_vars & additional_less -- prevent old vars in new projects
			},
			
			message: function(){
				$('#scp_overlay > .scp_msg_box').toggleClass('scp_msg_box-active');
			},
			
			errorHandler: function(){
				console.log(arguments); alert('Bibo hat ein LESS Fehler gefunden: siehe Konsole (PLACEHOLDER)');
			},
			
			refresh: function(new_vars=false){
				new_vars = (typeof new_vars == 'object')? new_vars : { };
				let current_vars = JSON.parse(localStorage.getItem(this._storage_key+'current_vars'));
				current_vars = (typeof current_vars == 'object')? current_vars : { };
				
				let less_vars = {...this._global_vars, ...current_vars, ...new_vars};
				
				SCP.genLessSrc();
				
				localStorage.setItem(this._storage_key+'current_vars', JSON.stringify(less_vars));
				return less.modifyVars(less_vars);
			},
			
			watch: function(){
				SCP._watch_mode = true;
				SCP.refresh();
			},
			
			unwatch: function(){
				clearTimeout(SCP._watch_timer);
				SCP._watch_mode = false;
			},
			
			genLessSrc: function(){
				let less_code = '';
				
				let load_order = this.load_order;
				$(load_order).each(function(index){
					if(!load_order[index].load) return;
					if(load_order[index].type == 'var'){
						less_code += (SCP.include_less[load_order[index].file])? SCP.include_less[load_order[index].file]+'\n' : '';
					}else{
						less_code += '@import ('+load_order[index].options+') "@{'+'eqdkpRootPath'+'}'+load_order[index].file+'";'+'\n';
					}
				});
				
				$('#scp_less_dist').attr('type','text/less').text(less_code);
				return less_code;
			},
			
			// NOTE: added a force argument for the user control, but it's currently not in use
			disableStyle: function(disable=true, force=false){
				if(this.disable_style && disable != this._style_disabled || force){
					let load_order = this.load_order;
					var parser = document.createElement('a');
					
					for(let i = 0; i < document.styleSheets.length; i++){
						if(this._compareWithLoadOrder(document.styleSheets.item(i).href)) document.styleSheets.item(i).disabled = disable;
					}
					
					this._style_disabled = disable;
				}
			},
			
			disableCache: function(){
				if(!this._cache_disabled){
					let self = this;
					let xhr_open = XMLHttpRequest.prototype.open;
					
					XMLHttpRequest.prototype.open = function(){
						let args = Array.prototype.slice.call(arguments, 0);
						
						if(self._compareWithLoadOrder(args[1])) args[1] += '?timestamp='+Date.now();
						
						return xhr_open.apply(this, args);
					};
					
					this._cache_disabled = true;
				}
			},
			
			_less_plugin: {
				install: function(less, pluginManager){
					pluginManager.addPreProcessor({
						process: function (src, extra){
							SCP._parse_time = new Date();
							
							// BUG: Maybe you can add here a routine to re-write path, less options doesn't work correctly
							
							return src;
						}
					});
					pluginManager.addPostProcessor({
						process: function (src, extra){
							let parse_time = new Date() - SCP._parse_time;
							SCP._setAverageDelay(parse_time);
							
							SCP.disableStyle();
							
							if(SCP._watch_mode){
								parse_time = SCP._getAverageDelay() / .66;
								SCP._watch_timer = window.setTimeout('SCP.refresh()', ((SCP.poll > parse_time)? SCP.poll : parse_time));
							}
							
							console.log('Less has finished after '+parse_time+'ms. (PLACEHOLDER)');
							return src;
						}
					});
				}
			},
			
			toggleStyleSettings: function(init=false){
				let storage_key		= SCP._storage_key+'show_sidebar';
				let show_sidebar	= localStorage.getItem(storage_key);
				let base_element	= $('#scp_overlay > .scp_style_settings');
				
				if(init) show_sidebar = (show_sidebar === null || show_sidebar == 'false')? false : true;
				else show_sidebar = base_element.hasClass('scp_dialog');
				
				if(  show_sidebar  ){
					base_element.switchClass('scp_dialog','scp_sidebar', (init)? 0 : 400);
					base_element.find('.scp_controls[data-category]').each(function(index, element){
						let menu_item = base_element.find('.scp_style_settings_menu > [data-category="'+$(element).data('category')+'"]');
						if(menu_item.length) $(element).detach().appendTo(menu_item);
					});
					localStorage.setItem(storage_key, true);
				}else{
					base_element.switchClass('scp_sidebar','scp_dialog');
					base_element.find('.scp_controls[data-category]').each(function(index, element){
						$(element).detach().appendTo(base_element.find('.scp_style_settings_content'));
					});
					localStorage.setItem(storage_key, false);
				}
			},
			
			_compareWithLoadOrder: function(url){
				let url_parser = document.createElement('a'); // { protocol => "http:", host => "example.com:3000", hostname => "example.com", port => "3000", pathname => "/pathname/", search => "?search=test", hash => "#hash" }
						
				url_parser.href = url;
				let input_file = url_parser.pathname.substr(url_parser.pathname.lastIndexOf('/')+1);
				for(let i = 0; i < this.load_order.length; i++){
					if(this.load_order[i].load && this.load_order[i].type == 'file'){
						url_parser.href = this.load_order[i].file;
						let file = url_parser.pathname.substr(url_parser.pathname.lastIndexOf('/')+1);
						if(input_file.match(file)) return true;
					}
				}
				return false;
			},
			
			_setAverageDelay: function(delay){
				if(this._last_delays.length >= 10) this._last_delays.shift();
				this._last_delays.push(delay);
			},
			
			_getAverageDelay: () => SCP._last_delays.reduce((total, current_value) => total += current_value, 0) / SCP._last_delays.length,
		};
		SCP.init();
		
		// NOTE: Maybe we should here use the template overwrite method of EQdkp
		if(mmocms_page == 'admin/manage_extensions') $('#plus_plugins_tab button[onclick$="create\'"]').before('<button class="mainoption" type="button" onclick="SCP.toggle();"><i class="fa fa-paint-brush" /> (PLACEHOLDER)</button>');
		
	});
	
	/*	TODO:
			Das draggen des Dialogs
				$( "#scp_overlay .scp_dialog" ).draggable({ distance: 20, revert: "invalid", }); $("#scp_overlay").droppable();
	*/
	
</script>


<div id="scp_overlay">
	<div class="scp_style_settings scp_dialog">
		<div class="scp_style_settings_head">
			<h1 class="scp_style_settings_title">{L_style_creator}</h1>
			<button class="scp_button scp_button-close" type="button"></button>
			
			<button class="scp_button scp_button-toggle" type="button" onclick="SCP.toggleStyleSettings();"></button>
			<button class="scp_button scp_button-config" type="button">(PLACEHOLDER)</button>
		</div>
		<div class="scp_style_settings_body">
			<ul class="scp_style_settings_menu">
				<!-- BEGIN scp_style_settings -->
					<li class="scp_style_settings_menu_item" data-category="{scp_style_settings.NAME}"><label>(PLACEHOLDER){scp_style_settings.LABEL}</label></li>
				<!-- END scp_style_settings -->
			</ul>
			<div class="scp_style_settings_content">
				<!-- BEGIN scp_style_settings -->
					<fieldset class="scp_controls" data-category="{scp_style_settings.NAME}">
						<!-- BEGIN controls -->
							<dl data-control="{scp_style_settings.controls.NAME}">
								<dt><label>(PLACEHOLDER){scp_style_settings.controls.LABEL}</label><p>(PLACEHOLDER){scp_style_settings.controls.HELP}</p><span>@{scp_style_settings.controls.NAME}</span></dt>
								<dd>{scp_style_settings.controls.INPUT}</dd>
							</dl>
						<!-- END controls -->
					</fieldset>
				<!-- END scp_style_settings -->
			</div>
		</div>
	</div>
	
	<div class="scp_msg_box">
		<div class="scp_msg_box_overlay"></div>
		<div class="scp_msg_box_content">
			<div class="scp_msg_box_head">
				<h3 class="scp_msg_box_title">(PLACEHOLDER)</h3>
				<button class="scp_button scp_button-close" type="button"></button>
			</div>
			<div class="scp_msg_box_body">
				<p class="scp_msg_box_text">(PLACEHOLDER)</p>
				<button class="scp_button scp_button-confirm" type="button">(PLACEHOLDER)</button>
				<button class="scp_button scp_button-abort" type="button">(PLACEHOLDER)</button>
			</div>
		</div>
	</div>
</div>




