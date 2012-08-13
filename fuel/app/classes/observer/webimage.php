<?php

class Observer_Webimage extends Orm\Observer
{

    public function before_insert(Model_Web_Image $model)
    {

		$img = APPPATH.'tmp'.DS.\Str::random().'.'.pathinfo($model->url, PATHINFO_EXTENSION);;

		try
		{

			$page = Request::forge($model->url, array(
					    'driver' => 'curl',
					    'set_options' => array(
						//CURLOPT_FILE => $img,
						CURLOPT_HEADER => 0,
						CURLOPT_MAXREDIRS => 2,
						CURLOPT_FOLLOWLOCATION => 1,
						CURLOPT_HTTPHEADER => array(
						    "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 (.NET CLR 3.5.30729)",
						    "Accept-Language: en-us,en"
					    ))
					))->execute()->response();

			if (file_exists($img))
			{
				\File::delete($img);
			}
			\File::create(dirname($img), basename($img), $page);
			//file_put_contents($img, file_get_contents($model->url));

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