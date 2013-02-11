<?php

/**
 * Расширение маппера плагина Gallery
 *
 * Class PluginLsgallerymigrate_ModuleGallery_MapperGallery
 */
class PluginLsgallerymigrate_ModuleGallery_MapperGallery extends PluginLsgallerymigrate_Inherit_PluginGallery_ModuleGallery_MapperGallery {

    /**
     *Получает список сущностей альбомов
     *
     * @return PluginGallery_ModuleGallery_EntityGallery[]
     */
    public function GetAllAlbumsIds()
    {
        $sql = "SELECT album_id FROM ".Config::Get('db.table.gallery.album')." ;";
        return $this->oDb->query($sql);
    }
}
