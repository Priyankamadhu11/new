@extends('layouts.back-end.app')

@section('title', translate('category'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0">
                <img src="{{asset('/public/assets/back-end/img/brand-setup.png')}}" class="mb-1 mr-1" alt="">
                @if($category['position'] == 1)
                    {{translate('sub')}}
                @elseif($category['position'] == 2)
                    {{translate('sub_Sub')}}
                @endif
                {{translate('category')}}
                {{translate('update')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <!-- <div class="card-header">
                        {{ translate('category_form')}}
                    </div> -->
                    <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        @if($category['position'] == 0 && theme_root_path() == 'theme_aster')
                        <form action="{{route('admin.category.update',[$category['id']])}}" method="POST" enctype="multipart/form-data">
                        @elseif($category['position'] == 1 && theme_root_path() == 'theme_aster')
                        <form action="{{route('admin.sub-category.update',[$category['id']])}}" method="POST" enctype="multipart/form-data">
                        @elseif($category['position'] == 2 && theme_root_path() == 'theme_aster')
                            <form action="{{route('admin.sub-sub-category.update',[$category['id']])}}" method="POST" enctype="multipart/form-data">
                        @endif

                            @csrf
                            @php($language=\App\Model\BusinessSetting::where('type','pnc_language')->first())
                            @php($language = $language->value ?? null)
                            @php($default_lang = 'en')

                            @php($default_lang = json_decode($language)[0])
                            <ul class="nav nav-tabs w-fit-content mb-4">
                                @foreach(json_decode($language) as $lang)
                                    <li class="nav-item text-capitalize">
                                        <a class="nav-link lang_link {{$lang == $default_lang? 'active':''}}"
                                           href="#"
                                           id="{{$lang}}-link">{{\App\CPU\Helpers::get_language_name($lang).'('.strtoupper($lang).')'}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="row">
                                <div class="{{ $category['parent_id']==0 || $category['position'] == 1 ? 'col-lg-6':'col-12' }}">
                                    @foreach(json_decode($language) as $lang)
                                    <div>
                                        <?php
                                        if (count($category['translations'])) {
                                            $translate = [];
                                            foreach ($category['translations'] as $t) {
                                                if ($t->locale == $lang && $t->key == "name") {
                                                    $translate[$lang]['name'] = $t->value;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="form-group {{$lang != $default_lang ? 'd-none':''}} lang_form"
                                            id="{{$lang}}-form">
                                            <label class="title-color">
                                            @if($category['position'] == 1)
                                                {{translate('sub_category_Name')}}
                                            @elseif($category['position'] == 2)
                                                {{translate('sub_sub_category_Name')}}
                                            @else
                                                {{translate('category_Name')}}
                                            @endif
                                                ({{strtoupper($lang)}})</label>
                                            <input type="text" name="name[]"
                                                value="{{$lang==$default_lang?$category['name']:($translate[$lang]['name']??'')}}"
                                                class="form-control"
                                                placeholder="{{translate('new_Category')}}" {{$lang == $default_lang? 'required':''}}>
                                        </div>
                                        <input type="hidden" name="lang[]" value="{{$lang}}">
                                    </div>
                                    @endforeach

                                    @if($category['position'] == 1 && theme_root_path() == 'theme_aster')
                                     
                                    <div class="form-group">
                                        <label class="title-color" for="exampleFormControlSelect1">{{translate('main_Category')}}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="exampleFormControlSelect1" name="parent_id" class="form-control" required>
                                            <option value="" selected disabled>{{translate('select_main_category')}}</option>
                                            @foreach(\App\Model\Category::where(['position'=>0])->get() as $main_category)
                                            <option value="{{$main_category['id']}}" @if($main_category['id'] == $category['parent_id']) selected @endif>
                                                {{$main_category['defaultname']}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @endif

                                    @if($category['position'] == 2 && theme_root_path() == 'theme_aster')

                                        <div class="form-group">
                                            <label
                                                class="title-color">{{translate('main_Category')}}
                                                <span class="text-danger">*</span></label>
                                                <select class="form-control" id="main_cat_id" required>
                                                    <option value="" disabled selected>{{translate('select_main_category')}}</option>
                                                    @foreach(\App\Model\Category::where(['position'=>0])->get() as $mainn_category)

                                                        <?php
                                                            $maincat = \App\Model\Category::where('id', $category['parent_id'])->first();
                                                        ?>
                                                        <option value="{{$mainn_category['id']}}" @if($mainn_category['id'] == $maincat->parent_id) selected @endif>{{$mainn_category['defaultName']}}</option>
                                                    @endforeach
                                                </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="title-color text-capitalize" for="name">{{translate('sub_category_Name')}}<span class="text-danger">*</span></label>
                                            <select name="parent_id" id="sub_parent_id" class="form-control">
                                                <option value="{{$maincat->id}}" selected>{{$maincat->name}}</option>
                                            </select>
                                        </div>

                                    @endif

                                    <div class="form-group">
                                        <label class="title-color" for="priority">{{translate('priority')}}</label>
                                        <select class="form-control" name="priority" id="" required>
                                            @for ($i = 0; $i <= 10; $i++)
                                            <option
                                            value="{{$i}}" {{$category['priority']==$i?'selected':''}}>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>

                                <!--image upload only for main category-->
                                @if($category['position'] == 0 || $category['position'] == 1 && theme_root_path() == 'theme_aster')
                                    <div class="from_part_2">
                                        <label class="title-color">{{translate('category_Logo')}}</label>
                                        <span class="text-info">({{translate('ratio')}} 1:1)</span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image" id="customFileEg1"
                                                   class="custom-file-input"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                            <label class="custom-file-label"
                                                   for="customFileEg1">{{translate('choose_File')}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-5 mt-lg-0 from_part_2">
                                    <div class="form-group">
                                        <center>
                                            <img class="upload-img-view"
                                                    id="viewer"
                                                    onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                    src="{{asset('storage/app/public/category')}}/{{$category['icon']}}"
                                                    alt=""/>
                                        </center>
                                    </div>
                                </div>
                                @else

                                @endif

                                @if($category['position'] == 2 || ($category['position'] == 1 && theme_root_path() != 'theme_aster'))
                                        <div class="d-flex justify-content-end gap-3">
                                            <button type="reset" id="reset" class="btn btn-secondary px-4">{{ translate('reset')}}</button>
                                            <button type="submit" class="btn btn--primary px-4">{{ translate('update')}}</button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if($category['parent_id']==0 || ($category['position'] == 1 && theme_root_path() == 'theme_aster'))
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="reset" id="reset" class="btn btn-secondary px-4">{{ translate('reset')}}</button>
                                    <button type="submit" class="btn btn--primary px-4">{{ translate('update')}}</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
     $main_cat_id=$maincat->id;
    ?>
@endsection

@push('script')

    <script>
        $(".lang_link").click(function (e) {
            e.preventDefault();
            $(".lang_link").removeClass('active');
            $(".lang_form").addClass('d-none');
            $(this).addClass('active');

            let form_id = this.id;
            let lang = form_id.split("-")[0];
            console.log(lang);
            $("#" + lang + "-form").removeClass('d-none');
            if (lang == '{{$default_lang}}') {
                $(".from_part_2").removeClass('d-none');
            } else {
                $(".from_part_2").addClass('d-none');
            }
        });

        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>
    <script>
        $( document ).ready(function() {

            var main_cat_id={{$main_cat_id}}
            $("#sub_parent_id").value(main_cat_id);
            var id = $("#main_cat_id").val();
            if (id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('admin.sub-sub-category.getSubCategory')}}',
                    data: {
                        id: id
                    },
                    success: function (result) {
                        $("#sub_parent_id").html(result);
                    }
                });
            }
        });
    </script>
    <script>
        $('#main_cat_id').on('change', function () {
            var id = $(this).val();
            console.log(id);
            if (id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('admin.sub-sub-category.getSubCategory')}}',
                    data: {
                        id: id
                    },
                    success: function (result) {
                        $("#sub_parent_id").html(result);
                    }
                });
            }
        });
    </script>
@endpush
