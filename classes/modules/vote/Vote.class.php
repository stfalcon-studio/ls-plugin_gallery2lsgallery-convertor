<?php

/**
 * Расширение модуля Голосования
 */
class PluginLsgallerymigrate_ModuleVote extends PluginLsgallerymigrate_Inherit_ModuleVote {

    /**
     * Возвращает список все голосований по Идентификатору
     *
     * @param integer $aTargetId
     * @param string $sTargetType ('topic', 'image', ... )
     *
     * @return ModuleVote_EntityVote[]
     */
    public function GetVotesByTargetId($aTargetId, $sTargetType)
    {
        return $this->oMapper->GetVotesByTargetId($aTargetId, $sTargetType);
    }
}