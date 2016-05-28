<?php

namespace Craft;

class AssetList_SelectFieldType extends BaseFieldType {

	public function getName() {
		return Craft::t('Asset List');
	}

	public function defineContentAttribute() {
		return AttributeType::String;
	}

	public function getInputHtml($name, $value) {

		//test for plugin
		if (!$plugin = craft()->plugins->getPlugin('assetList')) {
			die('Could not find the plugin');
		}

		//get the settings and fomart them
		$settings       = $plugin->getSettings();
		$ignoreSettings = str_replace(' ', '', $settings['ignore']);
		$ignoreFolders  = explode(',', $ignoreSettings);

		//set defualt
		$assetFolders = array('' => Craft::t(' -- No asset folder chosen --'));

		//get the folder models
		$folderModels = craft()->assets->findFolders();

		//store the models attributs in an array for reference
		foreach ($folderModels as $folderModel) {
			$folderAttributes                                = $folderModel->attributes;
			$folderModelsAttributes[$folderAttributes['id']] = $folderAttributes;
		}

		//recursive get parent folder name function
		function getParentFolderName($parentId, $folderModelsAttributes) {

			$parentModelAttributes = $folderModelsAttributes[$parentId];
			$parentName            = $parentModelAttributes['name'];
			$parentOfParent        = $parentModelAttributes['parentId'];

			if ($parentOfParent) {
				$folderParentModel = $folderModelsAttributes[$parentOfParent];
				$parentName        = getParentFolderName($parentOfParent, $folderModelsAttributes).'->'.$parentName;
			}
			return $parentName;
		}

		//create the final array for dropdown
		foreach ($folderModelsAttributes as $folderAttributes) {
			$folderName   = $folderAttributes['name'];
			$folderId     = $folderAttributes['id'];
			$folderParent = $folderAttributes['parentId'];

			//if has parent recursively get the parents
			if (!in_array($folderName, $ignoreFolders)) {
				if ($folderParent) {
					$folderName = getParentFolderName($folderParent, $folderModelsAttributes).'->'.$folderName;
				}

				$assetFolders[$folderId] = $folderName;
			}
		}

		//sort them alphabetcially
		asort($assetFolders);

		//return value
		return craft()->templates->render('_includes/forms/select', array(
				'name'    => $name,
				'value'   => $value,
				'options' => $assetFolders,
			));
	}

}
