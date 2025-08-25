@extends('errors::illustrated-layout')
@section('title', __('Not Found'))
@section('code', '404')
@section('image')
<img src="{{ Storage::url(getSettingShortValue('not_found_img')) }}" height="500px" width="500px">
@endsection
@section('message', __('Not Found'))
