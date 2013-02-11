ОПИСАНИЕ
--------

Плагин «LSGalleryMigrate» предназначен для переноса данных из плагина галереи "Gallery for LiveStreet 0.4.2/0.5"
от разработчика "extravert" 
http://livestreetcms.com/addons/view/26/
в галерею "Lsgallery"
http://livestreetcms.com/addons/view/378/
(https://github.com/stfalcon-studio/ls-plugin_lsgallery.git)
Плагин переносит: альбомы, комментарии, избранные, и рейтинги голосований, при этом данные плагина Gallery не удаляются.

Корректная работа обеих галерей одновременно, не возможна по причине конфликта роутов сайта, после проведения миграции 
одна из галерей должна быть отключена. 


ТРЕБОВАНИЯ:
LS 0.5
Плагин "Gallery" версии: 2.0.2
Плагин "Lsgallery" версии: 0.2.4

ЛИЦЕНЗИИ
-------

Файлы в этом архиве распространяются по лицензии GNU GPL. Вы можете найти копию
этой лицензии в файле LICENSE.txt.

ЗАПУСК
--------------
ВНИМАНИЕ! перед началом переноса, обязательно сделайте резервную копию данных
Все ошибки, произошедшие в процессе работы плагина пишутся в стандартный лог LS

Для начала переноса даных все три плагина (Gallery, Lsgallery, LSGalleryMigrate) должны быть активированы
Перенос даных запускается скриптом gallerymigration.php, который находится в папке /include/cron/ данного плагина

После переноса данных плагин больше не нужен и может быть удален или деактивирован.