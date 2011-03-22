<?php
/**
 * External Tokenizer Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_extokenizer extends Dokuwiki_Action_Plugin {

    function action_plugin_extokenizer(){
    }

    /**
     * Register its handlers with the dokuwiki's event controller
     */
    function register(&$controller) {
        $controller->register_hook('INDEXER_VERSION_GET', 'AFTER',  $this, '_version', array());
        $controller->register_hook('INDEXER_TEXT_PREPARE', 'BEFORE',  $this, '_tokenizer', array());
    }

    function _version(&$event, $param){
        $command = $this->getConf('command');
        $event->data['extokenizer'] = trim($command);
    }

    function _tokenizer(&$event, $param){
        $command = $this->getConf('command');
        if (0 == io_exec($command, $event->data, $output)) {
            $event->data = $output;
        }
        $event->preventDefault();
    }
}
