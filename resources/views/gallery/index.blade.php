@extends('layouts.auth')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries) > 0)
                        @foreach ($galleries as $gallery)
                        <img class="example-image img-fluid mb-2" src="{{ route('gallery.showPict', $gallery->picture) }}" alt="{{ $gallery->description }}" />
                            <div class="col-sm-2">
                                <div>
                                    <a class="example-image-link" href="{{ route('gallery.showPict', $gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                        {{-- <img class="example-image img-fluid mb-2" src="{{ route('gallery.showPict', $gallery->picture) }}" alt="{{ $gallery->description }}" /> --}}
                                        <img class="example-image img-fluid mb-2" src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="{{ $gallery->description }}" />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data.</h3>
                    @endif
                </div>
                <div class="d-flex">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
        <a href="{{ route('gallery.create') }}">klik</a>
    </div>
</div>
@endsection
