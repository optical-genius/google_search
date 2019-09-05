<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Controllers\UploadedFile;
use App\Jobs\ProcessImageDownload;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Отправляем запрос на поиск по пользовательским параметрам
        $get_images = Image::get_images_google($request);

        // Сохраняем результат запроса в БД
        foreach ($get_images['items'] as $imageitems) {
            $image = new Image();
            $image->user_id = auth()->user()->id;
            $image->img_url = $imageitems['link'];
            $image->user_request = $request['search_request'][0];
            $image->img_name = $imageitems['title'];
            $image->img_color = $request['color'];
            $image->save();

        // Запускаем воркер на сохранение изображений локально. Пользователю возвращаем внешний урл.
            ProcessImageDownload::dispatch($image)->delay(now()->addMinutes(1));;
        }

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
