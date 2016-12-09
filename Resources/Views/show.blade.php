@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <p>{!! $page->description !!}</p>

                @if(!$page->media->isEmpty() && $page->medias == '1')
                    @foreach($page->media as $media)

                        <a href="{{asset($media->path . $media->file)}}" class="fancybox"><img
                                    src="{{asset($media->path .'C_'. $media->file)}}" alt="{{$media->title}}"/></a>

                    @endforeach
                @endif
            </div>
        </div>
    </div>

@stop