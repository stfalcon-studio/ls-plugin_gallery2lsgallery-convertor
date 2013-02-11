<?php

/**
 * Расширение маппера
 *
 * Class PluginLsgallerymigrate_ModuleVote_MapperVote
 */
class PluginLsgallerymigrate_ModuleVote_MapperVote extends PluginLsgallerymigrate_Inherit_ModuleVote_MapperVote {

    /**
     * @param integer $aTargetId
     * @param string $sTargetType ('image', 'topic', ...)
     *
     * @return ModuleVote_EntityVote[]
     */
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
        $aVotes = array();
        if ($aRows = $this->oDb->select($sql,$aTargetId,$sTargetType)) {
            foreach ($aRows as $aRow) {
                $aVotes[] = Engine::GetEntity('Vote',$aRow);
            }
        }

        return $aVotes;
	}
}