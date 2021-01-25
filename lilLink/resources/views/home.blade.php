@extends('layouts.app')

@section('content')
    <div class="container">

        <form action="/shorten" method="post">
            @csrf
            <div class="form-row">
                <div class="col">
                    <input type="url" name="long_url" class="form-control" placeholder="Long URL (required)">
                </div>
                <div class="col">
                    <input type="text" name="url_description" class="form-control" placeholder="Short URL keyword (optional)">
                </div>
                <div class="col form-check form-check-inline">
                    <input class="form-check-input" name="is_private" type="checkbox" id="chkPrivate" value="1">
                    <label class="form-check-label" for="chkPrivate">Private?</label>
                </div>

                <div class="col">
                    <button type="submit" class="form-control btn btn-primary">Shorten</button>
                </div>
            </div>
        </form>
    </div>
    <div class="container mt-3">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('list-update-success'))
            <div class="alert alert-success">
                {{ session('list-update-success') }}
            </div>
        @endif
        @if (session('shorten-success'))
            <div class="alert alert-success">
                {{ session('shorten-success') }}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="container mt-5">
        @isset($linkList)
            <h1>Recent links</h1>
            <div class="list-group">
                @foreach($linkList as $link)
                    <a href="{{ $link->long_url }}" class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ URL::to('/') . '/' . $link->short_url }}</h5>
                        </div>
                        <p class="app-regular mb-1">{{ \Carbon\Carbon::parse($link->updated_at)->diffForHumans() }}</p>
                        <p class="app-regular mb-1">{{ $link->long_url }}</p>
                    </a>
                @endforeach
            </div>
    </div>
    @endisset
@endsection
