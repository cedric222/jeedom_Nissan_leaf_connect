<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class nissan_leaf_connect extends eqLogic {
    /*     * *************************Attributs****************************** */



    /*     * ***********************Methode static*************************** */
      public static function cron30() {
      }

      public static function cron5() {
       log::add('nissan_leaf_connect', 'debug', 'cron2');
       
       $eqLogics = eqLogic::byType('nissan_leaf_connect');
           foreach ($eqLogics as $eqLogic)
                {
                $request_shell = new com_shell('python /var/www/html/plugins/nissan_leaf_connect/ressources/nissan-leaf.py '.$eqLogic->getConfiguration('username').' '.$eqLogic->getConfiguration('password').' 2>&1');
                log::add('nissan_leaf_connect', 'debug', 'Execution de : ' . $request_shell->getCmd());
                $result = trim($request_shell->exec());

                $json = json_decode($result, TRUE);            
                log::add('nissan_leaf_connect', 'debug', 'result : ' . $result);

                $cmd = $eqLogic->getCmd('info', 'BatteryCapacity');
 		if (is_object($cmd)) {
                         if ( isset ( $json["battery_status"]["batteryCapacity"] )) {
                         	$cmd->setCollectDate('');
                         	$cmd->event($json["battery_status"]["batteryCapacity"] );
				}
		}
                $cmd = $eqLogic->getCmd('info', 'batteryDegradation');
 		if (is_object($cmd)) {
                         if ( isset ( $json["battery_status"]["batteryDegradation"] )) {
                         	$cmd->setCollectDate('');
                         	$cmd->event($json["battery_status"]["batteryDegradation"]);
				}
		}
                $cmd = $eqLogic->getCmd('info', 'CruisingRangeAcOn');
 		if (is_object($cmd)) {
                         if ( isset ( $json["battery_status"]["cruisingRangeAcOn"]) ) {
                         	$cmd->setCollectDate('');
                         	$cmd->event(intval ($json["battery_status"]["cruisingRangeAcOn"] / 1000 ));
				}
		}
                $cmd = $eqLogic->getCmd('info', 'CruisingRangeAcOff');
 		if (is_object($cmd)) {
                         if ( isset ( $json["battery_status"]["cruisingRangeAcOff"] )) {
                         	$cmd->setCollectDate('');
                         	$cmd->event(intval ($json["battery_status"]["cruisingRangeAcOff"] / 1000 ));
				}
		}
                $cmd = $eqLogic->getCmd('info', 'BatteryRemainingAmount');
 		if (is_object($cmd)) {
                         if ( isset ( $json["leaf_info"]["BatteryStatusRecords"]["BatteryStatus"]["BatteryRemainingAmountWH"] )) {
                         	$cmd->setCollectDate('');
                         	$cmd->event($json["leaf_info"]["BatteryStatusRecords"]["BatteryStatus"]["BatteryRemainingAmountWH"]);
				}
		}
                $cmd = $eqLogic->getCmd('info', 'BatteryChargingStatus');
 		if (is_object($cmd)) {
                         if ( isset ( $json["leaf_info"]["BatteryStatusRecords"]["BatteryStatus"]["BatteryChargingStatus"] )) {
                         	$cmd->setCollectDate('');
                         	$cmd->event($json["leaf_info"]["BatteryStatusRecords"]["BatteryStatus"]["BatteryChargingStatus"]);
				}
		}
                $cmd = $eqLogic->getCmd('info', 'NotificationDateAndTime');
 		if (is_object($cmd)) {
                         if ( isset ( $json["leaf_info"]["BatteryStatusRecords"]["OperationDateAndTime"] )) {
                         	$cmd->setCollectDate('');
                         	$cmd->event($json["leaf_info"]["BatteryStatusRecords"]["OperationDateAndTime"]);
				}
		}
	   }
           log::add('nissan_leaf_connect', 'debug', 'cron end');
      }
     


/*      public static function cronHourly() {
	

      }
*/
    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom
      public static function cronDayly() {

      }
     */



    /*     * *********************Méthodes d'instance************************* */

    public function preInsert() {
      log::add('nissan_leaf_connect', 'debug', 'preInsert');
    
        
    }

    public function postInsert() {
      log::add('nissan_leaf_connect', 'debug', 'postInsert');
        
    }

    public function preSave() {
      log::add('nissan_leaf_connect', 'debug', 'preSave');
        
    }

    public function postSave() {
      log::add('nissan_leaf_connect', 'debug', 'postSave');
        
    }

    public function preUpdate() {
      log::add('nissan_leaf_connect', 'debug', 'preUpdate');
        
    }

    public function postUpdate() {
      log::add('nissan_leaf_connect', 'debug', 'postUpdate');
      
      $new_cmd = $this->getCmd(null, 'start_climate_control');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Chauffage On', __FILE__));
      $new_cmd->setLogicalId('start_climate_control');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setSubType('other');
      $new_cmd->setType('action');
      $new_cmd->save();
      
      $new_cmd = $this->getCmd(null, 'stop_climate_control');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Chauffage Off', __FILE__));
      $new_cmd->setLogicalId('stop_climate_control');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setSubType('other');
      $new_cmd->setType('action');
      $new_cmd->save();
      
      $new_cmd = $this->getCmd(null, 'BatteryCapacity');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Capacité', __FILE__));
      $new_cmd->setLogicalId('BatteryCapacity');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setUnite('kWH');
      $new_cmd->setType('info');
      $new_cmd->setSubType('numeric');
      $new_cmd->save();
      
      $new_cmd = $this->getCmd(null, 'batteryDegradation');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Batterie', __FILE__));
      $new_cmd->setLogicalId('batteryDegradation');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setUnite('kWH');
      $new_cmd->setType('info');
      $new_cmd->setSubType('numeric');
      $new_cmd->save();
      
      $new_cmd = $this->getCmd(null, 'CruisingRangeAcOn');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Auton. avec AC', __FILE__));
      $new_cmd->setLogicalId('CruisingRangeAcOn');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setUnite('Km');
      $new_cmd->setType('info');
      $new_cmd->setSubType('numeric');
      $new_cmd->save();

      $new_cmd = $this->getCmd(null, 'CruisingRangeAcOff');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Auton. sans AC', __FILE__));
      $new_cmd->setLogicalId('CruisingRangeAcOff');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setUnite('Km');
      $new_cmd->setType('info');
      $new_cmd->setSubType('numeric');
      $new_cmd->save();

      $new_cmd = $this->getCmd(null, 'BatteryRemainingAmount');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Etat restant', __FILE__));
      $new_cmd->setLogicalId('BatteryRemainingAmount');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setUnite('kWH');
      $new_cmd->setType('info');
      $new_cmd->setSubType('numeric');
      $new_cmd->save();
 
      $new_cmd = $this->getCmd(null, 'BatteryChargingStatus');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Etat de Charge', __FILE__));
      $new_cmd->setLogicalId('BatteryChargingStatus');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setType('info');
      $new_cmd->setSubType('string');
      $new_cmd->save();
      
      $new_cmd = $this->getCmd(null, 'NotificationDateAndTime');
      if (!is_object($new_cmd)) {
             $new_cmd = new nissan_leaf_connectCmd();
             }
      $new_cmd->setName(__('Mise a jour', __FILE__));
      $new_cmd->setLogicalId('NotificationDateAndTime');
      $new_cmd->setEqLogic_id($this->getId());
      $new_cmd->setType('info');
      $new_cmd->setSubType('string');
      $new_cmd->save();
    }

    public function preRemove() {
      log::add('nissan_leaf_connect', 'debug', 'preRemove');
        
    }

    public function postRemove() {
      log::add('nissan_leaf_connect', 'debug', 'postRemove');
        
    }

    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
      public function toHtml($_version = 'dashboard') {

      }
     */

    /*     * **********************Getteur Setteur*************************** */
 public function toHtml2($_version = 'dashboard') {
                log::add('nissan_leaf_connect', 'debug', 'toHtml1 ' + $_version);
                $replace = $this->preToHtml($_version);
                #if (!is_array($replace)) {
                #        return $replace;
                #}
                $version = jeedom::versionAlias($_version);
                if ($this->getDisplay('hideOn' . $version) == 1) {
                        return '';
                }
                log::add('nissan_leaf_connect', 'debug', 'toHtml10');

		$html = template_replace($replace, getTemplate('core', $version, 'eqlogic', 'nissan_leaf_connect'));
                cache::set('widgetHtml' . $version . $this->getId(), $html, 0);
                return $html;
}
}

class nissan_leaf_connectCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */


     public function execute($_options = array()) {
    log::add('nissan_leaf_connect', 'debug', 'in function execute' );
                #if ($this->getLogicalId() == 'refresh') {
                #        $this->getEqLogic()->updateWeatherData();
                #}
                return false;
        }


    }

    /*     * **********************Getteur Setteur*************************** */


    /*     * **********************Getteur Setteur*************************** */

?>
