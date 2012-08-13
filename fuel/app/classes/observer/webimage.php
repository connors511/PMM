<?php

class Observer_Webimage extends Orm\Observer
{

    public function before_insert(Model_Web_Image $model)
    {

		$img = APPPATH.'tmp'.DS.\Str::random().'.jpg';

		try
		{

			file_put_contents($img, file_get_contents($model->url));

			Image::load($img)
				->resize(100, 200, true)
				->save($img);

			$model->data = base64_encode(file_get_contents($img));
			if ($model->height == null or $model->height == 0)
			{
				$model->height = Image::sizes($img)->height;
			}
			if ($model->width == null or $model->width == 0)
			{
				$model->width = Image::sizes($img)->width;
			}

			unlink($img);
		}
		catch(\FuelException $e)
		{
			if ($model->data == null or $model->data == "")
			{
				$model->delete();
			}

			if (file_exists($img))
			{
				unlink($img);
			}
		}
    }
}