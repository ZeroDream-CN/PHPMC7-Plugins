<?php
class API {
	
	public $package = "cn.phpmc.api";
	
	public static function onload() {
		global $Loader;
		$Loader->Event->registerClass("defaultActionEvent", new API());
	}
	
	public function defaultActionEvent($data) {
		global $Loader;
		if($data['action'] == 'api') {
			$config = $this->getConfig();
			if(!isset($data['token']) || $data['token'] !== $config['token']) {
				PHPMC::Error()->Println("Token verify error");
			} else {
				if(isset($data['type'])) {
					switch($data['type']) {
						case 'getserver':
							$Loader->Event->EventHandle("getServerEvent", array($_GET));
							break;
						case 'start':
							$Loader->Event->EventHandle("startServerEvent", array($_GET));
							break;
						case 'stop':
							$Loader->Event->EventHandle("stopServerEvent", array($_GET));
							break;
						case 'restart':
							$Loader->Event->EventHandle("restartServerEvent", array($_GET));
							break;
						case 'sendcommand':
							$Loader->Event->EventHandle("onCommandEvent", array($_GET));
							break;
						case 'status':
							$Loader->Event->EventHandle("getStatusEvent", array($_GET));
							break;
						case 'getserverinfo':
							$Loader->Event->EventHandle("getServerInfoEvent", array($_GET));
							break;
						case 'getdaemoninfo':
							$Loader->Event->EventHandle("getDaemonInfoEvent", array($_GET));
							break;
						case 'getuserinfo':
							$Loader->Event->EventHandle("getUserInfoEvent", array($_GET));
							break;
						case 'saveconfig':
							$Loader->Event->EventHandle("saveConfigEvent", array($_GET));
							break;
						case 'createserver':
							$Loader->Event->EventHandle("createServerEvent", array($_GET));
							break;
						case 'updateserver':
							$Loader->Event->EventHandle("updateServerEvent", array($_GET));
							break;
						case 'deleteserver':
							$Loader->Event->EventHandle("deleteServerEvent", array($_GET));
							break;
						case 'createdaemon':
							$Loader->Event->EventHandle("createDaemonEvent", array($_GET));
							break;
						case 'updatedaemon':
							$Loader->Event->EventHandle("updateDaemonEvent", array($_GET));
							break;
						case 'deletedaemon':
							$Loader->Event->EventHandle("deleteDaemonEvent", array($_GET));
							break;
						case 'createuser':
							$Loader->Event->EventHandle("createUserEvent", array($_GET));
							break;
						case 'updateuser':
							$Loader->Event->EventHandle("updateUserEvent", array($_GET));
							break;
						case 'deleteuser':
							$Loader->Event->EventHandle("deleteUserEvent", array($_GET));
							break;
						default:
							PHPMC::Error()->Println("Unknown type");
					}
				} else {
					PHPMC::Error()->Println("API Type Undefined");
				}
			}
			return true;
		}
		return false;
	}
	
	public function getConfig() {
		$data = json_decode(@file_get_contents(ROOT . "/plugins/" . $this->package . "/" . $this->package . ".json"), true);
		if(!$data) {
			PHPMC::Error()->Println("Can't read plugin config file: " . $this->package);
		}
		return $data['config'];
	}
}