
<script>
	
	// TODO: refactor: sort object elements --- exclude SCP to seperate js file
	
	var SCP, less;
	$(function(){
		SCP = {
			'load_order': {SCP_LOAD_ORDER},
			'additional_less': {SCP_ADDITIONAL_LESS},
			'global_vars': {SCP_GLOBAL_VARS},
			'init': function(){
				
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
				
				// Add executable style element to <head>
				$('html > head').append('<style id="scp_less_dist" type="text/less"></style>');
				SCP.gen_less_src();
				
				// Load less.js file with ajax (prevent: immediate rendering)
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
			'poll': 2000,
			'watch_timer': null,
			'watch_mode': false,
			'watch': function(){
				SCP.watch_mode = true;
				start_MS = new Date();
				
				SCP.refresh();
			},
			'unwatch': function(){
				clearTimeout(SCP.watch_timer);
				SCP.watch_mode = false;
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
							
							if(SCP.watch_mode) SCP.watch_timer = window.setTimeout('SCP.refresh()', ((SCP.poll > parse_time_tolerance)? SCP.poll : parse_time_tolerance));
							
							return src;
						}
					});
				}
			},
		};
		SCP.init();
		
		// Inject ToggleSCP Button
		if(mmocms_page == 'admin/manage_extensions') $('#plus_plugins_tab button[onclick$="create\'"]').before('<button class="mainoption" type="button" onclick="SCP.toggle();"><i class="fa fa-plus" /> Style Creator (PLACEHOLDER)</button>');
		
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
	<div class="scp_dialog">
		<div class="scp_dialog_head">
			<h1 class="scp_dialog_title">{L_style_creator}</h1>
			<button class="scp_dialog_close" type="button"></button>
			(PLACEHOLDER)
		</div>
		<div class="scp_dialog_body">
			<ul class="scp_dialog_menu">
				<!-- BEGIN scp_style_settings -->
					<li data-category="{scp_style_settings.NAME}">{scp_style_settings.LABEL}</li>
				<!-- END scp_style_settings -->
			</ul>
			<div class="scp_dialog_content">
				<!-- BEGIN scp_style_settings -->
					<fieldset class="scp_controls" data-category="{scp_style_settings.NAME}">
						<!-- BEGIN controls -->
							<dl data-control="{scp_style_settings.controls.NAME}">
								<dt><label>{scp_style_settings.controls.LABEL}</label><span>{scp_style_settings.controls.HELP}</span>@{scp_style_settings.controls.NAME}</dt>
								<dd>{scp_style_settings.controls.INPUT}</dd>
							</dl>
						<!-- END controls -->
					</fieldset>
				<!-- END scp_style_settings -->
			</div>
		</div>
	</div>
</div>




