<?php
namespace Craft;

class AssetListPlugin extends BasePlugin {

	function getName() {
		return Craft::t('Asset List');
	}

	function getVersion() {
		return '1.0';
	}

	function getDeveloper() {
		return 'George Evans';
	}

	function getDeveloperUrl() {
		return 'http://www.test.com';
	}

	protected function defineSettings() {
		return array(
			'ignore' => array(
				AttributeType::String,
				'required' => false
			),
		);
	}

	public function getSettingsHtml() {
		return craft()->templates->render('assetlist/_settings', array(
				'settings' => $this->getSettings()
			));
	}

}
