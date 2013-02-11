#!/usr/bin/env php
<?php
define('SYS_HACKER_CONSOLE',false);

$sDirRoot = dirname(realpath((dirname(__FILE__)) . "/../../../"));
set_include_path(get_include_path() . PATH_SEPARATOR . $sDirRoot);
chdir($sDirRoot);

require_once($sDirRoot . "/config/loader.php");
require_once($sDirRoot . "/engine/classes/Cron.class.php");


class GallerymigratonCron extends Cron {
	/**
	 * Выбираем пул заданий и рассылаем по ним e-mail
	 */
	public function Client()
    {
        $aActivePlugins = $this->Plugin_GetActivePlugins();
        if (!in_array('lsgallery', $aActivePlugins) || !in_array('gallery', $aActivePlugins) || !in_array('lsgallerymigrate', $aActivePlugins)) {
            echo ("One of galleries is not active." . PHP_EOL);
            ob_flush();
            return;
        }

        $this->Cache_Clean();
        $bError = false;

        $aAllAlbums = $this->PluginGallery_Gallery_GetAllAlbums();
        foreach ($this->PluginGallery_Gallery_GetAlbumsByArrayId($aAllAlbums) as $oAlbum) {

            $oLsAlbum = Engine::GetEntity('PluginLsgallery_ModuleAlbum_EntityAlbum');
            $oLsAlbum->SetUserId($oAlbum->getUserId());
            $oLsAlbum->setTitle($oAlbum->getTitle());
            $oLsAlbum->setDescription($oAlbum->getDescription());
            $oLsAlbum->setType($oAlbum->getType());
            $oLsAlbum->setDateAdd($oAlbum->getDateAdd());
            $oLsAlbum->setDateEdit($oAlbum->getDateEdit());
            $oLsAlbum->setCoverId($oAlbum->getCoverId()); //!!!!
            $oLsAlbum->setImageCount($oAlbum->getImageCount());
            $oSavedAlbum = $this->PluginLsgallery_Album_CreateAlbum($oLsAlbum);

            //Если не сохранилось, останавливаем скрипт
            if (!$oSavedAlbum) {
                //@todo cont
                $this->Log("Error saving the gallery " . $oAlbum->getId() . PHP_EOL);
                $bError = true;
                return;
            }

            foreach($this->PluginLsgallerymigrate_Gallery_getImagesByAlbumId($oAlbum->GetId()) as $oAlbumImage) {
                // eject
                if (!$sImagePath = $this->PluginLsgallerymigrate_Migrate_UploadImage(array('tmp_name' => $oAlbumImage->getImageOriginalServerPath()))){
                    $this->Log("Error uploading file " . $oAlbumImage->getId() . PHP_EOL);
                    $bError = true;
                    return;
                }

                // сохранение изображения
                $oLsImage = Engine::GetEntity('PluginLsgallery_ModuleImage_EntityImage');
                $oLsImage->setUserId($oAlbumImage->GetUserId());
                $oLsImage->setAlbumId($oSavedAlbum->GetId());
                $oLsImage->setFilename($sImagePath);

                if (!$oLsImage = $this->PluginLsgallery_Image_AddImage($oLsImage)){
                    $this->Log("Error saving image " . $oAlbumImage->getId() . PHP_EOL);
                    $bError = true;
                    return;
                }

                if ($oAlbum->getCoverId() == $oAlbumImage->getId()) {
                    $oSavedAlbum->SetCovetImageId($oLsImage->GetId());
                    $this->PluginLsgallery_Album_UpdateAlbum($oSavedAlbum);
                }

                // Обновление изображения
                $oLsImage->setDescription($oAlbumImage->GetTitle());
                $oLsImage->setImageTags($oAlbumImage->getImageTags());
                $oLsImage->setRating($oAlbumImage->getImageRating());
                $oLsImage->setCountVote($oAlbumImage->getImageCountVote());

                if (!$this->PluginLsgallery_Image_UpdateImage($oLsImage)){
                    $this->Log("Error updating image " . $oAlbumImage->getId() . PHP_EOL);
                    $bError = true;
                    return;
                }

                // debug
                //$oAlbumImage->getId()
                $aImageComments = $this->Comment_GetCommentsByTargetId($oAlbumImage->getId(), 'gallery');
                if (isset($aImageComments['comments'])) {
                    foreach ($aImageComments['comments'] as $oComment) {
                        $oComment->setId(NULL);
                        $oComment->setTargetId($oLsImage->getImageId());
                        $oComment->setTargetParentId($oLsImage->getAlbumId());
                        $oComment->setTargetType('image');
                        // removed comment!!!
                        if (!$this->Comment_AddComment($oComment)) {
                            $this->Log("Error updating comment for image {$oLsImage->getImageId()}" . PHP_EOL);
                            $bError = true;
                        }
                    }
                }

                foreach ($this->ModuleVote_MapperVote_GetVotesByTargetId(array($oAlbumImage->getId()), 'gallery') as $oVote )
                {
                    $oVote->SetId(NULL);
                    $oVote->setTargetType('image');
                    $oVote->setTargetId($oLsImage->getImageId());

                    if (!$this->Vote_AddVote($oVote)) {
                        $this->Log("Error updating Vote for image {$oLsImage->getImageId()}" . PHP_EOL);
                        $bError = true;
                    }
                }
            }
            echo 'migrate album - ' . $oAlbum->getId() . PHP_EOL;
            ob_flush();
        }

        if ($bError) {
            echo('Во время работы плагина произошла ошибка, подробности можно узнать в файле логирования');
        }

        $this->PluginLsgallery_Image_RecalculateFavourite();
        $this->PluginLsgallery_Image_RecalculateVote();
        $this->PluginLsgallery_Image_RecalculateComment();
        $this->Cache_Clean();
	}
}

$sLockFilePath=Config::Get('sys.cache.dir').'gallerymigration.lock';
/**
 * Создаем объект крон-процесса, 
 * передавая параметром путь к лок-файлу
 */
$app=new GallerymigratonCron($sLockFilePath);
print $app->Exec();
