
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
	
	
	
</script>

<!-- IF SCP_LOAD -->
<div id="scp_overlay">
	<div class="scp_dialog">
		<div class="scp_dialog_head">
			<h1 class="scp_dialog_title">{L_style_creator}</h1>
			<button class="scp_dialog_close" type="button"></button>
			(PLACEHOLDER)
		</div>
		<div class="scp_dialog_body">
			<ul class="scp_dialog_menu">
				<li>(PLACEHOLDER)</li>
				<li>(PLACEHOLDER)</li>
				<li>(PLACEHOLDER)</li>
				<li>(PLACEHOLDER)</li>
			</ul>
			<div class="scp_dialog_content">
				<fieldset class="scp_controls">
					<dl>
						<dt><label>(PLACEHOLDER)</label><span>(PLACEHOLDER)</span></dt>
						<dd><input type="text" /></dd>
					</dl>
					<dl>
						<dt><label>(PLACEHOLDER)</label></dt>
						<dd>
							<label><input type="radio" /> (PLACEHOLDER)</label>
							<label><input type="radio" /> (PLACEHOLDER)</label>
							<label><input type="radio" /> (PLACEHOLDER)</label>
							<label><input type="radio" /> (PLACEHOLDER)</label>
						</dd>
					</dl>
					<dl>
						<dt><label>(PLACEHOLDER)</label></dt>
						<dd class="scp_controls_radio_vert">
							<label><input type="radio" /> (PLACEHOLDER)</label>
							<label><input type="radio" /> (PLACEHOLDER)</label>
							<label><input type="radio" /> (PLACEHOLDER)</label>
						</dd>
					</dl>
					<dl>
						<dt><label>(PLACEHOLDER)</label>(PLACEHOLDER)</dt>
						<dd>
							<input value="#555" class="input colorpicker" size="14" readonly type="text">
							<div class="sp-replacer sp-light"><div class="sp-preview"><div class="sp-preview-inner" style="background-color: rgb(51, 51, 51);"></div></div><div class="sp-dd">▼</div></div>
						</dd>
					</dl>
					<dl>
						<dt><label>(PLACEHOLDER)</label></dt>
						<dd>
							<input value="#555" class="input colorpicker" size="14" readonly type="text">
							<div class="sp-replacer sp-light"><div class="sp-preview"><div class="sp-preview-inner" style="background-color: rgb(51, 51, 51);"></div></div><div class="sp-dd">▼</div></div>
						</dd>
					</dl>
					<dl>
						<dt><label>(PLACEHOLDER)</label><span>(PLACEHOLDER)</span>(PLACEHOLDER) (PLACEHOLDER) (PLACEHOLDER)</dt>
						<dd>
							<input value="#555" class="input colorpicker" size="14" readonly type="text">
							<div class="sp-replacer sp-light"><div class="sp-preview"><div class="sp-preview-inner" style="background-color: rgb(51, 51, 51);"></div></div><div class="sp-dd">▼</div></div>
						</dd>
					</dl>
				</fieldset>
			</div>
		</div>
	</div>
</div>

<!-- ENDIF -->



