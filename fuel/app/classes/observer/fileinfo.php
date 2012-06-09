<?php

class Observer_Fileinfo extends Orm\Observer
{

    public function before_insert(Model_File $model)
    {
        $info = \File::file_info($model->path);
	$model->size = $info['size'];
	$model->realpath = $info['realpath'];
    }
}