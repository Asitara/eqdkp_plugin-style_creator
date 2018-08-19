
<!-- IF TEMPLATE_CLASS == 'admin_manage_extensions' -->
<script>
	function toggleStyleCreator(){
		if(sessionStorage.getItem('test') == 1) sessionStorage.setItem('test', 0);
		else sessionStorage.setItem('test', 1);
	}
	$('#plus_plugins_tab button[onclick$="create\'"]').before('<button class="mainoption" type="button" onclick="toggleStyleCreator();"><i class="fa fa-plus" /> Style Creator (PLACEHOLDER)</button>');
	
	
	var parser = new window.less.Parser(less);
	// parser.parse(additional_less, function(error, result){
	// 	// if(!error) console.log('DEBUG', result.toCSS());
	// 	// else console.log('DEBUG', error);
	// });
	
	try {
		parser.parse('color:#000;', function(error, result){
			if(!error){
                console.log('DEBUG', result.toCSS());
			}
			else{
				console.log('DEBUG', error);
			}
		});
	}
	catch (error){
		console.log('MyError', error);
	}
	
	// new(less.Parser)({ env: 'production' }).parse('', function(e,t){});
	
	
</script>
<!-- ENDIF -->


<div id="scp_overlay">
	<div class="scp_control_box">
		<h1 class="scp_title_bar">{L_style_creator}</h1>
		<button class="scp_button_close" type="button"></button>
		<div class="scp_control_box_head">(PLACEHOLDER)</div>
		<div class="scp_control_box_body">
			<ul class="scp_control_box_menu"><li>(PLACEHOLDER)</li></ul>
			<div class="scp_control_box_content">(PLACEHOLDER)</div>
		</div>
	</div>
</div>




<!-- <script src="{EQDKP_ROOT_PATH}plugins/style_creator/less/less.js" data-env="development"></script> -->

<!-- theoretisch können wir hier die script src less.js aufrufen etc, davor kommt noch ein style tag mit den additional less und tada :D -->


