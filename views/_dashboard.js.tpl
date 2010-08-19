<script type="text/javascript" src="assets/prototype.js"></script>
<script type="text/javascript" src="assets/scriptaculous.js?effects"></script>
<script type="text/javascript" language="Javascript">

function update_files(action, content)
{
	show_loader(content+'_content');
	new Ajax.Request('index.php' ,
	{
		method: "post",
		parameters:
		{
			mode: 'dashboard',
			action: 'files',
			type: action,
			container: content
		},
		onSuccess: function(transport)
		{
			var response = transport.responseText || "Could not recieve update.";
			$(content+'_content').innerHTML = response;
			hide_loader();
		},
		onFailure: function()
		{
			alert("Unable to fetch updates.");
			hide_loader();
		}
	});
}

function update_logs(start)
{
	show_loader('history_content');
	new Ajax.Request('index.php' ,
	{
		method: "post",
		parameters:
		{
			mode: 'dashboard',
			action: 'log',
			start: start,
		},
		onSuccess: function(transport)
		{
			var response = transport.responseText || "Could not recieve update.";
			$('history_content').innerHTML = response;
			hide_loader();
		},
		onFailure: function()
		{
			alert("Unable to fetch updates.");
			hide_loader();
		}
	});
}

function build_list(el)
{
	var el_arr = new Array();
	
	boxes = $(el).select('input[type=checkbox]');
	i = 0;
	
	boxes.each( function(e)
	{
		if( e.checked )
		{
			el_arr[i] = e.value;
			i++;
		}
	});
	
	return el_arr;
}

function execute_action(command)
{
	command = $('git-action').value;
	$('tmp').value = build_list('files_content');
	new Ajax.Request('index.php' ,
	{
		method: "post",
		parameters:
		{
			mode: 'dashboard',
			action: 'execute',
			cmd: command,
			file_list: $('tmp').value
		},
		onSuccess: function(transport)
		{
			if( command != "diff" )
			{
				update_files('all', 'files');
				
				if( command == "stage" )
				{
					update_files('staged', 'stage');
				}
			}
			else
			{
				var response = transport.responseText || "Could not recieve update.";
				$('files_content').innerHTML = response;
			}
		},
		onFailure: function()
		{
			alert("Unable to fetch updates.");
		}
	});
}

function show_loader(el)
{
	if( el == null )
	{
		var viewport = document.viewport.getDimensions(); // Gets the viewport as an object literal
		var width = viewport.width; // Usable window width
		var height = viewport.height; // Usable window height
		
		//alert(width + " " + height);

		$('loader').style.width = '99%';
		$('loader').style.height = '99%';
		$('loader').style.top = 0;
		$('loader').style.left = 0;
	}
	else
	{
		$('loader').style.width = $(el).offsetWidth - 15;
		$('loader').style.height = $(el).offsetHeight - 15;
		$('loader').style.top = $(el).offsetTop;
		$('loader').style.left = $(el).offsetLeft;
	}
	
	new Effect.Appear('loader', {from:0.0, to:0.5});
}

function hide_loader()
{
	new Effect.Fade('loader', {duration:0.3});
}

	
//Event.observe(window, 'load', execute_action);
</script>
