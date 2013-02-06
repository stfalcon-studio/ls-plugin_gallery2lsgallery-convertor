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

class PluginMigrate_ModuleVote_MapperVote extends PluginMigrate_Inherit_ModuleVote_MapperVote {

	public function GetVotesByTargetId($aTargetId, $sTargetType)
    {
        $sql = "SELECT
					*
				FROM
					".Config::Get('db.table.vote')."
				WHERE
					target_id IN(?a)
					AND
					target_type = ? ";
        $aVotes=array();
        if ($aRows=$this->oDb->select($sql,$aTargetId,$sTargetType)) {
            foreach ($aRows as $aRow) {
                $aVotes[]=Engine::GetEntity('Vote',$aRow);
            }
        }
        return $aVotes;
	}
}
?>