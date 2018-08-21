
<script>
	
	$(function(){
		var SCP = {
			'init': function(){
				
				$.getScript( mmocms_root_path+'plugins/style_creator/less/less.js', function( data, textStatus, jqxhr ) {
					// error_handler nutzen wenn nicht geladen
				});
			},
			'toggle': function(){
				$.post(mmocms_controller_path+mmocms_sid+'&scp_toggle', {'{SCP_CSRF_TOKEN}':'{SCP_CSRF_TOKEN}'},
					function(response){
						response = JSON.parse(response);
						if(!response.error){
							// custom_message with function.on(click) = location.reload()
							location.reload();
						}else{
							// custom_message
						}
				});
			},
			'msg_box': function(){
			
			},
			'error_handler': function(a,b,c){
				alert('LESS Error: siehe Konsole');console.log(a,b,c);
			},
		};
		
		
		// Inject ToggleSCP Button
		if(mmocms_page == 'admin/manage_extensions') $('#plus_plugins_tab button[onclick$="create\'"]').before('<button class="mainoption" type="button" onclick="SCP.toggle();"><i class="fa fa-plus" /> Style Creator (PLACEHOLDER)</button>');
		
	});

	
	/*
		Workarounds method :::::
		<style type="text/less"> ..my less code..</style>
		then do: less.refresh()
		--------------------------------------------
		Wir schreiben in das <style id="scp_"> Element @import bla gedöns
		Nachdem die Seite geladen ist adden wir das Attribute type="text/less",
		damit es nicht beim sete laden bereits less veranlasst zu kompilieren
		Wir sollten ebenfalls den Inhalt des Elements dumpen in einer JS Variable
		Theorteisch reicht dann ein manuelles kompilieren im Sinne von:
			less.refresh().then(function(){
				$('style#scp_').attr('type', 'text/less').text( my_dumped_less_code );
			});
		
	*/
	
	
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


<!-- <script src="{EQDKP_ROOT_PATH}plugins/style_creator/less/less.js" data-env="development"></script> -->

<!-- theoretisch können wir hier die script src less.js aufrufen etc, davor kommt noch ein style tag mit den additional less und tada :D -->


