
<script>
	
	var SCP, less;
	$(function(){
		SCP = {
			poll: 2000,								// public: delay for auto-refresh when watch_mode
			storageKey: 'plugins.style_creator.',	// public: localStorage key prefix
			load_order: {SCP_LOAD_ORDER},			// public: load order of less files
			additional_less: {SCP_ADDITIONAL_LESS},
			global_vars: {SCP_GLOBAL_VARS},
			
			_watch_mode: false,						// private: state of watch_mode
			_watch_timer: null,						// private: ID of setTimeout when watch_mode
			
			init: function(){
				
				
				
				SCP.toggleStyleSettings(true);
				
				// Add executable style element to <head>
				$('html > head').append('<style id="scp_less_dist" type="text/less"></style>');
				SCP.gen_less_src();
				
				// Init less options
				less = {
					env: 'development',
					// useFileCache: false,		// disabled, inline-css ignore this option
					// async: true,				// disabled, don't know if it re-sort load_order
					// fileAsync: true,			// disabled, don't know if it re-sort load_order
					// poll: 2000,				// disabled, we use own watch_mode
					// relativeUrls: true,		// disabled, seems not working - workaround in preProcessor
					// rootpath: '',			// disabled, seems not working - workaround in preProcessor
					// errorReporting: self.error_handler,
					plugins: [SCP.less_plugin],
					globalVars: SCP.global_vars,
				};
				
				// Load less with ajax (prevent: immediately execution)
				$.getScript( mmocms_root_path+'plugins/style_creator/less/less.js');
				
			},
			'toggle': function(){
				$.post(mmocms_controller_path+mmocms_sid+'&scp_toggle', {'{SCP_CSRF_TOKEN}':'{SCP_CSRF_TOKEN}'},
					function(response){
						response = JSON.parse(response);
						if(!response.error) location.reload();
				});
			},
			'msg_box': function(){
			
			},
			'error_handler': function(a,b,c){
				console.log(a,b,c);alert('LESS Error: siehe Konsole');
			},
			
			'refresh': function(new_vars=false){
				less_vars = (typeof new_vars == 'object')? {...SCP.global_vars, ...new_vars} : SCP.global_vars;
				// TODO: Dump changed vars & re-use
				SCP.gen_less_src();
				
				return less.modifyVars(less_vars);
			},
			'watch': function(){
				SCP._watch_mode = true;
				SCP.refresh();
			},
			'unwatch': function(){
				clearTimeout(SCP._watch_timer);
				SCP._watch_mode = false;
			},
			
			'gen_less_src': function(){
				scp_less_src = '';
				$(SCP.load_order).each(function(index){
					if(SCP.load_order[index].load) scp_less_src += ((SCP.load_order[index].code == 'additional_less')? SCP.additional_less : SCP.load_order[index].code) +'\n';
				});
				$('#scp_less_dist').attr('type','text/less').text(scp_less_src);
				// TODO: Make this smoother if page reload, by spliting into _less_src & _less_dist
				return scp_less_src;
			},
			
			'less_plugin': {
				install: function(less, pluginManager){
					pluginManager.addPreProcessor({
						process: function (src, extra){
							SCP.parse_time = new Date();
							
							// BUG: Maybe you can add here a routine to re-write path, less options doesn't work correctly (try: follow commented code)
							// src = SCP.gen_less_src();
							
							return src;
						}
					});
					pluginManager.addPostProcessor({
						process: function (src, extra){
							parse_time = new Date() - SCP.parse_time;
							parse_time_tolerance = parse_time / .66;
							console.log('Less has finished after '+parse_time+'ms.');
							
							if(SCP._watch_mode) SCP._watch_timer = window.setTimeout('SCP.refresh()', ((SCP.poll > parse_time_tolerance)? SCP.poll : parse_time_tolerance));
							
							return src;
						}
					});
				}
			},
			
			'toggleStyleSettings': function(init=false){
				let storageKey		= SCP.storageKey+'show_sidebar';
				let show_sidebar	= localStorage.getItem(storageKey);
				let base_element	= $('#scp_overlay > .scp_style_settings');
				
				if(init) show_sidebar = (show_sidebar === null || show_sidebar == 'false')? false : true;
				else show_sidebar = base_element.hasClass('scp_dialog');
				
				if(  show_sidebar  ){
					base_element.switchClass('scp_dialog','scp_sidebar', (init)? 0 : 400);
					base_element.find('.scp_controls[data-category]').each(function(index, element){
						let menu_item = base_element.find('.scp_style_settings_menu > [data-category="'+$(element).data('category')+'"]');
						if(menu_item.length) $(element).detach().appendTo(menu_item);
					});
					localStorage.setItem(storageKey, true);
				}else{
					base_element.switchClass('scp_sidebar','scp_dialog');
					base_element.find('.scp_controls[data-category]').each(function(index, element){
						$(element).detach().appendTo(base_element.find('.scp_style_settings_content'));
					});
					localStorage.setItem(storageKey, false);
				}
			},
		};
		SCP.init();
		
		// Inject ToggleSCP Button
		if(mmocms_page == 'admin/manage_extensions') $('#plus_plugins_tab button[onclick$="create\'"]').before('<button class="mainoption" type="button" onclick="SCP.toggle();"><i class="fa fa-paint-brush" /> (PLACEHOLDER)</button>');
		
	});
	
	
	// TODO: Include this in SCP.init() with pre-defined files @ url.match()
	var preOpen = XMLHttpRequest.prototype.open;
	XMLHttpRequest.prototype.open = function(method, url) {
		var args = Array.prototype.slice.call(arguments, 0);
		if (url.match(/\.css$/)) {
			url += '?timestamp='+Date.now();
			args[1]=url;
		}
		return preOpen.apply(this, args);
	}
	
	/*	NOTE: Sidebar/Dialog (Proof of Concept)
			das ".menu li" bekommt ein div, in diesem label ==> dies bekommt das eigentluchte li styling
			dann nurnoch das css klassenmanagment so gestalten das mit simplen class.nameChange gearbeitet wird
		
			Das umwandeln zur Sidebar
				var element = $('fieldset.scp_controls[data-category="body"]').detach();
				element.appendTo('.menu li[data-*] > div');
				
			Das umwandeln zum Dialog
				var element = $('fieldset.scp_controls[data-category="body"]').detach();
				element.appendTo('.body');
				
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




