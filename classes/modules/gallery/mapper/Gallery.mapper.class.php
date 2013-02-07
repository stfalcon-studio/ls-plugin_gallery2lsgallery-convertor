<?php

class PluginLsgallerymigrate_ModuleGallery_MapperGallery extends PluginLsgallerymigrate_Inherit_PluginGallery_ModuleGallery_MapperGallery {

    public function GetAllAlbumsIds()
    {
        $sql = "SELECT album_id FROM ".Config::Get('db.table.gallery.album')." ;";
        return $this->oDb->query($sql);
    }
}
