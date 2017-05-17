# Craft Asset List
This plugin provides a field type which can be used to get a dropdown of folder names. This allows the easy output of an asset folders contents.

## To install assetlist, follow these steps:

1. Download & unzip the file and place the assetlist directory into your craft/plugins directory
2. -OR- do a git clone https://github.com/georgeevans1995/craft-assetlist.git directly into your craft/plugins folder. You can then update it with git pull
3. Install plugin in the Craft Control Panel under Settings > Plugins

## template use
assetlist will output a folder id. From this id loop through and get the folder contents.

```twig

	{% for asset in craft.assets.folderId(entry.assetlistFieldHandle) %}
		 <li><img src="{{ asset.getUrl() }}" alt="{{ asset.title }}"/></li>
	{% endfor %}

```
