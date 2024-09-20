<?php

/**
 * @file plugins/generic/inlineHtmlGalley/InlineHtmlGalleyBlockPlugin.inc.php
 *
 * Copyright (c) University of Pittsburgh
 * Distributed under the GNU GPL v2 or later. For full terms see the file docs/COPYING.
 *
 * @class InlineHtmlGalleyBlockPlugin
 * @ingroup plugins_generic_inlineHtmlGalley
 *
 * @brief Class for Inline HTML Galley block plugin
 */
namespace APP\plugins\generic\inlineHtmlGalley;

use APP\core\PageRouter;
use PKP\plugins\BlockPlugin;
use PKP\config\Config;
use PKP\plugins\PluginRegistry;

class InlineHtmlGalleyBlockPlugin extends BlockPlugin {

	/** @var string $parentPluginName string name of InlineHtmlGalley plugin */
	public $parentPluginName;

	/** @var string $pluginPath string path to InlineHtmlGalley plugins */
	public $pluginPath;

	/**
	 * Constructor
	 * @param $parentPluginName string
	 * @param $pluginPath string
	 */
	public function __construct($parentPluginName, $pluginPath) {
		parent::__construct();
		$this->parentPluginName = $parentPluginName;
		$this->pluginPath = $pluginPath;
	}

	/**
	 * Override currentVersion to prevent upgrade and delete management.
	 * @return boolean
	 */
	public function getCurrentVersion() {
		return false;
	}

	/**
	 * @copydoc LazyLoadPlugin::getEnabled()
	 */
	public function getEnabled($contextId = null) {
		if (!Config::getVar('general', 'installed')) return true;
		return parent::getEnabled($contextId);
	}

	/**
	 * Get the display name of this plugin.
	 * @return string
	 */
	public function getDisplayName() {
		return __('plugins.generic.inlineHtmlGalley.block.download.displayName');
	}

	/**
	 * Get a description of the plugin.
	 * @return string
	 */
	public function getDescription() {
		return __('plugins.generic.inlineHtmlGalley.block.download.description');
	}

	/**
	 * Hide this plugin from the management interface (it's subsidiary)
	 * @return boolean
	 */
	public function getHideManagement() {
		return true;
	}

	/**
	 * Get the supported contexts (e.g. BLOCK_CONTEXT_...) for this block.
	 * @return array
	 */
	public function getSupportedContexts() {
		return array(BLOCK_CONTEXT_SIDEBAR);
	}

	/**
	 * Get the parent plugin
	 * @return object
	 */
	public function &getParentPlugin() {
		$plugin = PluginRegistry::getPlugin('generic', $this->parentPluginName);
		return $plugin;
	}

	/**
	 * Override the builtin to get the correct plugin path.
	 * @return string
	 */
	public function getPluginPath() {
		return $this->pluginPath;
	}

	/**
	 * Get the name of the block template file.
	 * @return string
	 */
	public function getBlockTemplateFilename() {
		return 'blockDownload.tpl';
	}

	/**
	 * @copydoc BlockPlugin::getContents()
	 */
	public function getContents($templateMgr, $request = null) {
		if ($templateMgr && $request) {
			/** @var PageRouter $router */
			$router = $request->getRouter();
			
			$page = $router->getRequestedPage($request);
			$op = $router->getRequestedOp($request);

			if ($page === 'article' && $op === 'view') {
				$submission = $templateMgr->getTemplateVars('article');
				$galley = $templateMgr->getTemplateVars('galley');
				
				// Ensure both submission and galley exist, and check if the galley is HTML
				if ($submission && $galley && $galley->getFileType() == 'text/html') {
					$templateMgr->assign('submissionId', $submission->getBestArticleId());
					$templateMgr->assign('galleyId', $galley->getBestGalleyId());
					return parent::getContents($templateMgr);
				}
			}
		}
		return false;
	}
}
