@extends('core::base.layouts.master')
@section('title')
    {{ translate('Update System') }}
@endsection
@section('custom_css')
@endsection
@section('main_content')
    <!-- Update System form -->
    <div class="row">
        <div class="col-md-7 mb-30 mx-auto">
            <form action="{{route('core.update.database')}}" method="post">
                @csrf
                <button type="submit" class="btn btn-success w-100">{{ translate('Update Databse') }}</button>
            </form>
        </div>
        @include('core::base.media.partial.media_modal')
    </div>
    <!-- /General settings form -->
@endsection
