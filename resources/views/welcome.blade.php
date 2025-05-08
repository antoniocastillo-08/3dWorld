@extends('app')

@section('content')
<div class="container-fluid justify-center items-center min-h-screen bg-danger">
    <div class="row">
        
    @foreach ($models as $model)
        <div class="card col-1 mx-2">
            <div class="card__shine"></div>
            <div class="card__glow"></div>
            <div class="card__content">
                <div style="--bg-color: #a78bfa" class="card__image">
                    @if ($model->image)
                        <img src="{{ $model->image }}" alt="{{ $model->name }}" class="w-full h-full object-cover rounded-md">
                    @else
                        <p>No image available</p>
                    @endif
                </div>
                                <div class="card__text">
                    <!-- Título dinámico -->
                    <p class="card__title">{{ $model->name }}</p>
                    <!-- Descripción dinámica -->
                    <p class="card__description">{{ $model->description }}</p>
                </div>
                <div class="card__footer">
                    <div class="card__button">
                        <svg height="16" width="16" viewBox="0 0 24 24">
                            <path
                                stroke-width="2"
                                stroke="currentColor"
                                d="M4 12H20M12 4V20"
                                fill="currentColor"
                            ></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection