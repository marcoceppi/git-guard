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
			hide_loader(content+'_content');
		},
		onFailure: function()
		{
			alert("Unable to fetch updates.");
			hide_loader(content+'_content');
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
			hide_loader('history_content');
		},
		onFailure: function()
		{
			alert("Unable to fetch updates.");
			hide_loader('history_content');
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
	if( command == null )
	{
		command = $('git-action').value;
		$('tmp').value = build_list('files_content');
	}
	else
	{
		$('tmp').value = '';
	}
	
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
				
				if( command == "stage" || command == "commitall" )
				{
					update_files('staged', 'stage');
				}
				
				if( command == "commit" || command == "commitall" )
				{
					update_logs(0);
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
		var loader_name = 'loader';
	}
	else
	{
		make_loader(el);
		
		$(el+'_loader').style.width = $(el).offsetWidth - 15;
		$(el+'_loader').style.height = $(el).offsetHeight - 15;
		$(el+'_loader').style.top = $(el).offsetTop;
		$(el+'_loader').style.left = $(el).offsetLeft;
		
		var loader_name = el+'_loader';
	}
	
	new Effect.Appear(loader_name, {from:0.0, to:0.5});
}

function hide_loader(el)
{
	new Effect.Fade(el+'_loader', {duration:0.3});
}

function make_loader(el)
{
	if( $(el+'_loader') )
	{
		// We've been had - the loader alread exists!
		return true;
	}
	else
	{
		// We should make one!
		loaderTPL = $('loader');
		newLoader = loaderTPL.clone();
		newLoader.id = el+"_loader";
		newLoader.innerHTML = loaderTPL.innerHTML;
		document.body.appendChild(newLoader);
		
		return true;
	}
}
	
//Event.observe(window, 'load', execute_action);
</script>
