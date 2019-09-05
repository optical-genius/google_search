@extends('layouts.app')

@section('content')


    <div class="container" style="padding-top: 10%;">


        <h3 class="header">Начать поиск картинок</h3>


        <div class="row">


            <form action="/imagesearch" method="GET">
                {{csrf_field()}}
                <div class="col s10">
                    <div class="input-field">
                        <input style="padding-left: 50px;" id="search-example" type="search" required="" placeholder="котики"
                               name="search_request[]">
                        <label class="label-icon" for="search-example">
                            <i class="material-icons">search</i>
                        </label>
                    </div>
                </div>

                <div class="col s2">
                    <button class="waves-effect waves-light btn-large" type="submit">Искать</button>
                </div>


                <div class="col s12">
                    <p>Цвет</p>
                    <p>
                        <label>
                            <input type="radio" id="black" name="color" value="black" checked/>
                            <span>Черный</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="radio" id="white" name="color" value="white"/>
                            <span>Белый</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input type="radio" id="orange" name="color" value="orange"/>
                            <span>Рыжий</span>
                        </label>
                    </p>
                </div>

            </form>
        </div>

    </div>


    </div>

@if($images->isEmpty())

@else
    <div class="container">
        <h4>Картинки которые вы искали по запросу: {{$user_request->user_request}}</h4>
        <div class="grid">
            <div class="grid-sizer"></div>
            @foreach($images as $image)
                <div class="grid-item"><img src="{{$image->img_url}}" alt=""></div>
            @endforeach
        </div>
    </div>
@endif

    <script>
        // init Masonry
        var $grid = $('.grid').masonry({
            itemSelector: '.grid-item',
            percentPosition: true,
            columnWidth: '.grid-sizer'
        });

        // layout Masonry after each image loads
        $grid.imagesLoaded().progress(function () {
            $grid.masonry();
        });
    </script>
@endsection
