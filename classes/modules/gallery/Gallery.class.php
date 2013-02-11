<?php

/**
 * Расширение плагина Gallery
 *
 * Class PluginLsgallerymigrate_ModuleGallery
 */
class PluginLsgallerymigrate_ModuleGallery extends PluginLsgallerymigrate_Inherit_PluginGallery_ModuleGallery {

    /**
     * Получает список Идентификаторов всех альбомов плагина Gallery
     *
     * @return array();
     */
    public function getAllAlbums() {
        $aResult = $this->oMapper->GetAllAlbumsIds();

        $aAlbumsId = array();
        foreach ($aResult as $aAlbumItem) {
            $aAlbumsId[] = $aAlbumItem['album_id'];
        }

        return $aAlbumsId;
    }
}