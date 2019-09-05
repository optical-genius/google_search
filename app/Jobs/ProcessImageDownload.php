<?php

namespace App\Jobs;

use App\Image as ImageModel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Controllers\UploadedFile;

class ProcessImageDownload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ImageModel $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Отменяем проверку ssl
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $path_name_image = pathinfo($this->image->img_url);

        //Качаем файл по ссылке, меняем название на рандомное значение
        $contents = file_get_contents($this->image->img_url, false, stream_context_create($arrContextOptions));
        $file = public_path("img/") . rand() . '.' . $path_name_image['extension'];
        file_put_contents($file, $contents);

        // Сохраняем путь к локальному файлу в БД
        $this->image = Image::find($this->image->id);
        $this->image->img_url_local = $file;
        $this->image->save();

    }
}
