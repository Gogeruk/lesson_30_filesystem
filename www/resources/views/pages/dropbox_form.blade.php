@extends('layout')

@section('dropbox_form')

<div class="m-3">
    <form class="form-group" method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3 text-center">
            <label for="image">File input</label>
            <input type="file" name="image" class="form-control-file" id="dropboxfileInput">
        </div>
        @if($errors->has('image'))
            <div class="alert alert-danger mb-3" role="alert">
                {{ $errors->get('image')[0] }}
            </div>
        @endif
        <div class="m-12 text-center">
            <button type="submit" class="btn btn-info btn-sm" id="dropboxbutton" name="submit">Submit</button>
            @if (!empty($__data['status']))
                <a href="{{ $__data['status'] }}" class="btn btn-primary btn-link">Success!</a>
            @endif
        </div>
    </form>
</div>


@endsection
