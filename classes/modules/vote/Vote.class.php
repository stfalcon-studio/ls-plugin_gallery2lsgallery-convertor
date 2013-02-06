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
 * Модуль для работы с голосованиями
 *
 */
class PluginMigrate_ModuleVote extends PluginMigrate_Inherit_ModuleVote {
	protected $oMapper;	

	public function Init()
    {
		$this->oMapper=Engine::GetMapper(__CLASS__);
	}

    public function GetVotesByTargetId($aTargetId, $sTargetType)
    {
        return $this->oMapper->GetVotesByTargetId($aTargetId, $sTargetType);
    }


}
?>