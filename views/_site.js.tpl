<script type="text/javascript" src="assets/prototype.js"></script>
<script type="text/javascript" src="assets/scriptaculous.js?load=effects"></script>
<script type="text/javascript" language="Javascript">

var name_entered = false;

function basename(path)
{
	return path.replace(/\\/g,'/').replace( /.*\//, '' );
}

function clean_name(name)
{
	name = name.replace(/\-/g, ' ').replace(/_/g, ' ');
	name = name.split(' ');
	var newVal = "";
	
	for(var c = 0; c < val.length; c++)
	{
		newVal += val[c].substring(0,1).toUpperCase() + val[c].substring(1,val[c].length) + ' ';
	}

	return newVal;
}

function check_path()
{
	var path = $('site_path').value;
	if( path != "" )
	{
		$('path_check').innerHTML = $('loader-img').innerHTML;
		
		new Ajax.Request('index.php' ,
		{
			method: "post",
			parameters:
			{
				mode: 'site',
				action: 'check_path',
				path: path
			},
			onSuccess: function(transport)
			{
				var response = transport.responseText || "??";
				
				$('path_check').innerHTML = response;
				
				if( !name_entered )
				{
					$('site_name').value = basename(path);
				}
			},
			onFailure: function()
			{
				$('path_check').innerHTML = "<p class=\"simple red\">Unable to check path.</p>";
			}
		});
	}
}

</script>
