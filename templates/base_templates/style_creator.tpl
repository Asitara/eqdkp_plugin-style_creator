
<!-- IF TEMPLATE_CLASS == 'admin_manage_extensions' -->
<script>
	function toggleStyleCreator(){
		if(sessionStorage.getItem('test') == 1) sessionStorage.setItem('test', 0);
		else sessionStorage.setItem('test', 1);
	}
	$('#plus_plugins_tab button[onclick$="create\'"]').before('<button class="mainoption" type="button" onclick="toggleStyleCreator();"><i class="fa fa-plus" /> Style Creator (PLACEHOLDER)</button>');
	
</script>
<!-- ENDIF -->


<div id="scp_overlay">
	{TEMPLATE_CLASS}
</div>
