<?php

if (!defined("GLPI_MOD_FILES_DIR")) {
   define("GLPI_MOD_FILES_DIR", GLPI_ROOT."/files/_plugins/mod");
}

if (!defined("GLPI_MOD_USER_CSS_PATH")) {
   define("GLPI_MOD_USER_CSS_PATH", GLPI_MOD_FILES_DIR.'/userstyles.css');
}

function plugin_init_mod() {
  
   global $PLUGIN_HOOKS, $LANG ;
	
	$PLUGIN_HOOKS['csrf_compliant']['mod'] = true;         
   
   $plugin = new Plugin();
   if ($plugin->isInstalled('mod') && $plugin->isActivated('mod')) {

	   Plugin::registerClass('PluginMod', [
	      'addtabon' => ['Config']
	   ]);
	             
	   $PLUGIN_HOOKS['config_page']['mod'] = 'config.php';
	   //$PLUGIN_HOOKS['add_javascript']['mod'] = "scripts/mod.js";
	   $PLUGIN_HOOKS['add_javascript']['mod'][] = "scripts/stats.js";
	   $PLUGIN_HOOKS['add_javascript']['mod'][] = "scripts/ind.js";
 	}

        //Create editable basepath, if missing.
        if ( ! is_writable(GLPI_MOD_FILES_DIR)) {
           mkdir(GLPI_MOD_FILES_DIR);
        }

        //Add user customizable file if missing
        if( ! file_exists(GLPI_MOD_USER_CSS_PATH)) {
           file_put_contents(GLPI_MOD_USER_CSS_PATH, '/* Write custom login CSS after this */');
        }
}


function plugin_version_mod(){
	global $DB, $LANG;

	return array('name'			   => __('GLPI Modifications'),
					'version' 			=> '1.1.8',
					'author'			   => '<a href="mailto:stevenesdonato@gmail.com"> Stevenes Donato </b> </a>',
					'license'		 	=> 'GPLv2+',
					'homepage'			=> 'https://forge.glpi-project.org/projects/mod',
					'minGlpiVersion'	=> '9.2.2');
}

function plugin_mod_check_prerequisites(){
     if (GLPI_VERSION >= '9.2.2'){
	     	if(file_exists('/etc/hosts')){      	
	         return true;
	     	}
         
     } else {
         echo "GLPI version not compatible need 9.2.2";
     }
}


function plugin_mod_check_config($verbose=false){
	if ($verbose) {
		echo 'Installed / not configured';
	}
	return true;
}


?>
