<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Gallery
*   Copyright  ver.0.3.1 © 2008 Moiseev Kirill
*   Copyright  ver.0.4.2 © 2010 Vladimir Yuriev
*
*--------------------------------------------------------
*
*   Plugin Page: http://lsmods.ru
*   Contact e-mail: support@lsmods.ru
*
---------------------------------------------------------
*/

class PluginLsgallerymigrate_ModuleGallery extends PluginLsgallerymigrate_Inherit_PluginGallery_ModuleGallery {

	public function getAllAlbums() {
        $aResult = $this->oMapper->GetAllAlbumsIds();

        $aAlbumsId = array();
        foreach ($aResult as $aAlbumItem) {
            $aAlbumsId[] = $aAlbumItem['album_id'];
        }

        return $aAlbumsId;
    }
}
?>