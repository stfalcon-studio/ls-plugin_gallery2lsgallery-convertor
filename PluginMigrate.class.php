<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
	die('Hacking attempt!');
}

class PluginMigrate extends Plugin {

	protected $aInherits = array(
        'mapper' => array(
            'PluginGallery_ModuleGallery_MapperGallery' => 'PluginMigrate_ModuleGallery_MapperGallery',
		),
        'module' => array(
            'PluginGallery_ModuleGallery' => 'PluginMigrate_ModuleGallery',
            //'PluginLsgallery_ModuleImage' => 'PluginMigrate_ModuleImage',
            'ModuleVote' => 'PluginMigrate_ModuleVote',
        ),
	);

	
	/**
	 * Активация плагина "Статические страницы".
	 * Создание таблицы в базе данных при ее отсутствии.
	 */
	public function Activate() {
		return true;
	}
	
	/**
	 * Инициализация плагина
	 */
	public function Init() {
	
	}
}
?>