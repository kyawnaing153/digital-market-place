@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
@endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.setting_title')</title>
@endsection

@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="#" class="setting-tab" data-target="seo-setting">SEO Settings</a></li>
                <li><a href="#" class="setting-tab" data-target="site-images-setting">Site Images Settings</a></li>
                <li><a href="#" class="setting-tab" data-target="home-images-setting">Home Images Settings</a></li>
                <li><a href="#" class="setting-tab" data-target="footer-settings">Footer Settings</a></li>
            
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <!-- SEO Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="seo-setting">
                        <form id="seo-form" action="{{ route('admin.setting.store') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Site Name</label>
                                            <input class="form-control" type="text" placeholder="Enter Site Name"
                                                name="site_name" value="{{ @$data->site_name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Site Title</label>
                                            <input class="form-control" type="text" placeholder="Enter Site Title"
                                                name="site_title" value="{{ @$data->site_title }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Site Author</label>
                                            <input class="form-control" type="text" placeholder="Enter Site Author"
                                                name="site_author" value="{{ @$data->site_author }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Meta Keywords</label>
                                            <textarea class="form-control form-textarea" rows="5" cols="50" spellcheck="true"
                                                placeholder="Enter Meta Keywords" name="site_meta_keywords">{{ @$data->site_meta_keywords }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Meta Description</label>
                                            <textarea class="form-control form-textarea" rows="5" cols="50" spellcheck="true"
                                                placeholder="Enter Meta Description" name="site_meta_desc">{{ @$data->site_meta_desc }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn" id="seo-form-btn"
                                                onclick="formValidate('seo-form')">update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- SITE Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="site-images-setting">
                        <div class="tp_catset_box_wrapper">
                            <form id="site-images-form" action="{{ route('admin.setting.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="tp_catset_box tp_set_site">
                                    <div class="alert alert-info">
                                        <strong>Info!</strong> Upload one at a time.
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Pre Loader</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div pre_loader_img">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->pre_loader_img) }}"
                                                                alt="pre-loader-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="pre_loader_img"
                                                                    value="{{ @$data->pre_loader_img }}">
                                                                <input name="pre_loader_img" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Preloader size 100x100px.</p>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Favicon</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div favicon_img">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->favicon_img) }}"
                                                                alt="favicon-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="favicon_img"
                                                                    value="{{ @$data->favicon_img }}">
                                                                <input name="favicon_img" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Favicon size 32x32px.</p>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Site Logo</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div my_logo">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->my_logo) }}"
                                                                alt="dark-header-logo-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="my_logo"
                                                                    value="{{ @$data->my_logo }}">
                                                                <input name="my_logo" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image min-size 180x43px , max-size 250x50px.</p>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">White Logo</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div white_logo">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->white_logo) }}"
                                                                alt="white-footer-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="white_logo"
                                                                    value="{{ @$data->white_logo }}">
                                                                <input name="white_logo" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image min-size 180x43px , max-size 250x50px.</p>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">404 image</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div not_found_img">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->not_found_img) }}"
                                                                alt="404-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="not_found_img"
                                                                    value="{{ @$data->not_found_img }}">
                                                                <input name="not_found_img" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 1124x679px.</p>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">OOPs image</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div error_icon_img">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->error_icon_img) }}"
                                                                alt="OOPs-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="error_icon_img"
                                                                    value="{{ @$data->error_icon_img }}">
                                                                <input name="error_icon_img" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 300x240px.</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Success image</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div success_icon_img">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->success_icon_img) }}"
                                                                alt="sucess-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="success_icon_img"
                                                                    value="{{ @$data->success_icon_img }}">
                                                                <input name="success_icon_img" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 300x240px.</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">SocialMedia Preview Image</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div preview_image">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->preview_image) }}"
                                                                alt="social-media-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="preview_image"
                                                                    value="{{ @$data->preview_image }}">
                                                                <input name="preview_image" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 600x335px.</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">User Placeholder Image</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div default_user_image">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->default_user_image) }}"
                                                                alt="user-placeholder-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="default_user_image"
                                                                    value="{{ @$data->default_user_image }}">
                                                                <input name="default_user_image" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 100x100px.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="tp_siteimg_btn">
                                                <button type="submit" class="tp_btn" id="site-images-form-btn"
                                                    onclick="formValidateFile('site-images-form')">update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Home Page Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="home-images-setting">
                        <div class="tp_catset_box_wrapper">
                            <form id="home-images-form" action="{{ route('admin.setting.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="tp_catset_box tp_set_site">
                                    <div class="alert alert-info">
                                        <strong>Info!</strong> Upload one at a time.
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Home Page BG Image</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div home_page_bg_img">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->home_page_bg_img) }}"
                                                                alt="homepage-bg-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="home_page_bg_img"
                                                                    value="{{ @$data->home_page_bg_img }}">
                                                                <input name="home_page_bg_img" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image Size 1920x1280px.</p>
                                                </div>
                                            </div>
                                            <div class="checkbox mb-3">
                                                <label>
                                                    <input class="form-control" type="hidden"
                                                        name="is_checked_show_all_anim_img" value="0">
                                                    <input class="form-control" type="checkbox"
                                                        name="is_checked_show_all_anim_img"
                                                        @if (@$data->is_checked_show_all_anim_img == 1) checked @endif value="1"><i
                                                        class="input-helper"></i>Checkbox shows,
                                                    all animation images.</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Home BG Animation Image</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div home_page_bg_animation_img">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->home_page_bg_animation_img) }}"
                                                                alt="home-bg-animation-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="home_page_bg_animation_img"
                                                                    value="{{ @$data->home_page_bg_animation_img }}">
                                                                <input name="home_page_bg_animation_img"
                                                                    class="file_upload image" type="file"
                                                                    accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 1918x834px.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Home Page Middle Banner</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div home_middle_banner">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->home_middle_banner) }}"
                                                                alt="homepage-middle-banner-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="home_middle_banner"
                                                                    value="{{ @$data->home_middle_banner }}">
                                                                <input name="home_middle_banner" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 1920×522 px</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Image 1</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div tp_img_div home_bg_s_img1">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->home_bg_s_img1) }}"
                                                                alt="image1-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="home_bg_s_img1"
                                                                    value="{{ @$data->home_bg_s_img1 }}">
                                                                <input name="home_bg_s_img1" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p> Image size 200*200.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Image 2</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div tp_img_div home_bg_s_img2">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->home_bg_s_img2) }}"
                                                                alt="image2-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="home_bg_s_img2"
                                                                    value="{{ @$data->home_bg_s_img2 }}">
                                                                <input name="home_bg_s_img2" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 200*200.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Image 3</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div tp_img_div home_bg_s_img3">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->home_bg_s_img3) }}"
                                                                alt="image3-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="home_bg_s_img3"
                                                                    value="{{ @$data->home_bg_s_img3 }}">
                                                                <input name="home_bg_s_img3" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 200*200.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Image 4</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div home_bg_s_img4">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->home_bg_s_img4) }}"
                                                                alt="image4-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="home_bg_s_img4"
                                                                    value="{{ @$data->home_bg_s_img4 }}">
                                                                <input name="home_bg_s_img4" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 200*200.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="tp-custom-cart mb-3">
                                                <h6 class="tp_heading">Login / SignUp BG Image</h6>
                                                <div class="tp_uploade_images_main">
                                                    <div class="tp_upload_area">
                                                        <div class="tp_pic_wrapper tp_img_div login_sign_bg_img">
                                                            <img class="tp_upload_pic"
                                                                src="{{ Storage::url(@$data->login_sign_bg_img) }}"
                                                                alt="login/signup-bg-img">
                                                        </div>
                                                        <div class="tp_upload_pic_thumb">
                                                            <label class="upload_button">
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                                        height="18px" fill="#fff" viewBox="0 0 32 32"
                                                                        xmlns:v="https://vecta.io/nano">
                                                                        <path
                                                                            d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                                                    </svg>
                                                                </span>
                                                                <input type="hidden" name="login_sign_bg_img"
                                                                    value="{{ @$data->login_sign_bg_img }}">
                                                                <input name="login_sign_bg_img" class="file_upload image"
                                                                    type="file" accept="image/*">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <p>Image size 1583x775px.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="tp_btn mt-2"
                                                onclick="formValidateFile('home-images-form')"
                                                id="home-images-form-btn">update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- footer Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="footer-settings">
                        <form id="footer-form" action="{{ route('admin.setting.store') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box tp_footer_setting">
                                <div class="alert alert-info">
                                    <strong>Info!</strong> Yes / No to make the frontend footer content visible or not.
                                </div>
                                <div class="tp_form_wrapper tp_label_bold ">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Copyright Text</label>
                                    </div>
                                    <input class="form-control" type="text" name="copyright_text"
                                        placeholder="Enter Copyright Text" value="{{ @$data->copyright_text }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Facebook URL</label>
                                        <input type="hidden" name="is_checked_facebook" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-1" type="checkbox" name="is_checked_facebook"
                                                value="1" {{ @$data->is_checked_facebook == 1 ? 'checked' : '' }}>
                                            <label for="check-active-1">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="facebook_url"
                                        placeholder="Enter Facebook URL" value="{{ @$data->facebook_url }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Twitter URL</label>
                                        <input type="hidden" name="is_checked_twitter" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-2" type="checkbox" name="is_checked_twitter"
                                                value="1" {{ @$data->is_checked_twitter == 1 ? 'checked' : '' }}>
                                            <label for="check-active-2">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="twitter_url"
                                        placeholder="Enter Twitter URL" value="{{ @$data->twitter_url }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Instagram URL</label>
                                        <input type="hidden" name="is_checked_insta" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-3" type="checkbox" name="is_checked_insta"
                                                value="1" {{ @$data->is_checked_insta == 1 ? 'checked' : '' }}>
                                            <label for="check-active-3">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="instagram_url"
                                        placeholder="Enter Instagram URL" value="{{ @$data->instagram_url }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">YouTube URL</label>
                                        <input type="hidden" name="is_checked_youtube" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-4" type="checkbox" name="is_checked_youtube"
                                                value="1" {{ @$data->is_checked_youtube == 1 ? 'checked' : '' }}>
                                            <label for="check-active-4">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="youtube_url"
                                        placeholder="Enter Youtube URL" value="{{ @$data->youtube_url }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Footer Text</label>
                                        <input type="hidden" name="is_checked_footer_text" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-5" type="checkbox" name="is_checked_footer_text"
                                                value="1" {{ @$data->is_checked_footer_text == 1 ? 'checked' : '' }}>
                                            <label for="check-active-5">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="footer_text"
                                        placeholder="Enter Footer Text" value="{{ @$data->footer_text }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Newsletter Text</label>
                                        <input type="hidden" name="is_checked_newsletter" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-newsletter" type="checkbox"
                                                name="is_checked_newsletter" value="1"
                                                {{ @$data->is_checked_newsletter == 1 ? 'checked' : '' }}>
                                            <label for="check-active-newsletter">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="newsletter_text"
                                        placeholder="Enter Newsletters Text" value="{{ @$data->newsletter_text }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Address</label>
                                        <input type="hidden" name="is_checked_address" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-address" type="checkbox" name="is_checked_address"
                                                value="1" {{ @$data->is_checked_address == 1 ? 'checked' : '' }}>
                                            <label for="check-active-address">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="company_adderss"
                                        placeholder="Enter Address" value="{{ @$data->company_adderss }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Phone</label>
                                        <input type="hidden" name="is_checked_phone" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-phone" type="checkbox" name="is_checked_phone"
                                                value="1" {{ @$data->is_checked_phone == 1 ? 'checked' : '' }}>
                                            <label for="check-active-phone">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="company_phone"
                                        placeholder="Enter Phone Number" value="{{ @$data->company_phone }}">
                                </div>
                                <div class="tp_form_wrapper tp_label_bold">
                                    <div class="tp_flex_lable">
                                        <label class="mb-2">Email</label>
                                        <input type="hidden" name="is_checked_email" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-email" type="checkbox" name="is_checked_email"
                                                value="1" {{ @$data->is_checked_email == 1 ? 'checked' : '' }}>
                                            <label for="check-active-email">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <input class="form-control" type="text" name="company_email"
                                        placeholder="Enter Email" value="{{ @$data->company_email }}">
                                </div>
                                <button type="submit" class="tp_btn" onclick="formValidate('footer-form')"
                                    id="footer-form-btn">update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/setting.js') }}"></script>
@endsection
