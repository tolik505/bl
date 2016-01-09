<?php
use \backend\modules\imagesUpload\models\ImagesUploadModel;

?>
<a class="crop-link btn btn-xs btn-default pull-right" data-toggle="modal" href="<?= ImagesUploadModel::getCropUrl(['id' => '']) ?>" {dataKey} data-target=".modal-hidden">
    <i class="glyphicon glyphicon glyphicon-scissors file-icon-large text-success"></i>
</a>
