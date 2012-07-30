<?php

class Observer_Fileinfo extends Orm\Observer
{

    public function before_insert(Model_File $model)
    {
	try
	{
		$info = \File::file_info($model->path);
		$model->size = $info['size'];
		$model->realpath = $info['realpath'];
	}
	catch(\FuelException $e)
	{
		$model->size = 0;
		$model->realpath = '';
	}
    }
}