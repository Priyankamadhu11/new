@extends('layouts.back-end.app-seller')

@section('title', translate('refund_policy'))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/Pages.png')}}" width="20" alt="">
                {{translate('Refund Policy')}}
            </h2>
        </div>
       
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  
                    <form action="{{route('seller.profile.refund_policy_update')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control" id="editor" name="refund_policy_text">{{$seller->refund_policy_text}}</textarea>
                            </div>
                            <div class="form-group">
                                <input class="form-control btn--primary" type="submit" value="{{translate('submit')}}" name="btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{--ck editor--}}
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/ckeditor.js"></script>
    <script src="{{asset('/')}}vendor/ckeditor/ckeditor/adapters/jquery.js"></script>
    <script>
        $('#editor').ckeditor({
            contentsLangDirection : '{{Session::get('direction')}}',
        });
    </script>
    {{--ck editor--}}
@endpush

