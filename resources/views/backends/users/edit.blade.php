@extends('layouts.master')
@section('title', __('users.title'))
@section('content')
<div id="users-list">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between border-bottom mb-5 pb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        {{ __('dashboard.title') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('users.index') }}">
                        <span class="sub-title">{{ __('users.sub_title') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="sub-title">{{  $users->lastname }} {{  $users->firstname }}</span>
                </li>
            </ol>
        </nav>
        <a href="{{route('users.index')}}" 
            class="btn btn-primary"
            data-toggle="tooltip" 
            data-placement="left" title="" 
            data-original-title="{{__('users.sub_title')}}"
        ><i class="fas fa-list"></i> {{__('users.sub_title')}}</a>
    </div>
    <div class="row mb-2">
        <div class="col-12 tab-card">
            <!-- Circle Buttons -->
            <div class="card mb-4">
                <div id="supplierList" class="card-body collapse show">
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="addsupplier" class="tab-pane active">
                            <form class="form-main" action="{{route('users.update', $users->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="lastname">{{__('users.list.lastname')}}:</label>
                                                    <input type="text" class="form-control {{ $errors->has('lastname') ? ' is-invalid' : '' }}" 
                                                        placeholder="{{__('users.list.lastname')}}"
                                                        name="lastname"
                                                        value="{{ old('lastname', $users->lastname) }}">
                                                    @if ($errors->has('lastname'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('lastname') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="col-6">
                                                    <label for="lastname">{{__('users.list.firstname')}}:</label>
                                                    <input type="text" class="form-control {{ $errors->has('firstname') ? ' is-invalid' : '' }}" 
                                                        placeholder="{{__('users.list.firstname')}}"
                                                        name="firstname"
                                                        value="{{ old('firstname', $users->firstname) }}">
                                                    @if ($errors->has('firstname'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('firstname') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check form-check-inline align-top" for="gender">{{__('users.list.gender')}}:</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="man" value="male" {{old('gender', $users->gender) == 'male' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="man">{{__('users.form.man')}}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="woman" value="female" {{old('gender', $users->gender) == 'female' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="woman">{{__('users.form.woman')}}</label>
                                            </div>
                                            @if ($errors->has('gender'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('gender') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_number">{{__('users.list.dob')}}:</label>
                                            <div class="input-group date" data-provide="datepicker">
                                                <input type="text" class="form-control" name="dob" placeholder="ថ្ងៃ/ខែ/ឆ្នាំ" 
                                                    value="{{ old('dob', date('d/m/Y', strtotime($users->dob))) }}">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><span class="far fa-calendar-alt"></span></div>
                                                </div>
                                            </div>
                                            @if ($errors->has('dob'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('dob') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="email">{{__('users.list.email')}}:</label>
                                            <input type="emal" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                                placeholder="{{__('users.list.email')}}"
                                                name="email"
                                                value="{{ old('email', $users->email) }}"
                                            >
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                
                                        </div>
                                        <div class="form-group">
                                            <label for="address">{{__('users.list.address')}}:</label>
                                            <textarea name="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" rows="5">{{old('address', $users->address)}}</textarea>
                                            @if ($errors->has('addresss'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="phone1">{{__('users.list.phone')}}:</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" class="form-control {{ $errors->has('phone1') ? ' is-invalid' : '' }}" 
                                                        name="phone1"
                                                        value="{{ old('phone1', $users->phone1) }}">
                                                    @if ($errors->has('phone1'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('phone1') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control {{ $errors->has('phone2') ? ' is-invalid' : '' }}" 
                                                        name="phone2"
                                                        value="{{ old('phone2', $users->phone2) }}"
                                                    >
                                                    @if ($errors->has('phone2'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('phone2') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="thumbnail">{{__('users.form.thumbnail')}}:</label>
                                            <div class="upload-profile img-upload">
                                                <div class="img-file-tab">
                                                    <div>
                                                        <span class="btn btn-file img-select-btn btn-block">
                                                            <i class="fa fa-fw fa-upload"></i> <span>{{__('users.form.add_thumbnail')}}</span>
                                                            <input type="file" name="profile_image">
                                                        </span>
                                                    </div>
                                                    <img class="thumbnail" src="{{$users->profile_image? getUploadUrl($users->profile_image, config('upload.users')) : asset('images/no-avatar.jpg') }}"/>
                                                    <span class="btn img-remove-btn"><i class="fa fa-fw fa-times"></i>{{__('button.delete')}}</span>
                                                </div>
                                            </div>
                                            @if ($errors->has('profile_image'))
                                                <div class="text-danger">
                                                    <strong>{{ $errors->first('profile_image') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div><!--/row-->
                                <div class="form-group w-50 d-inline-flex">
                                    <button type="submit" class="btn btn-primary w-25 mr-2">{{__('button.edit')}}</button>
                                    <a href="{{route('users.index')}}" class="btn btn-secondary w-25">{{__('button.return')}}</a>
                                </div>
                            </form><!--/form-main-->
                        </div><!--/tab-add-users-->
                    </div>
                </div>
            </div>
        </div>
    </div><!--/row-->
</div>
@endsection
@push('footer-script')
<script type="text/javascript" src="{{asset('/js/imageupload.js')}}"></script>
<script>
    // script for upload image
    $('.img-upload').imgUpload();
</script>
@endpush