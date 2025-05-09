@extends('app')

@section('content')
<div class="container-fluid justify-center items-center min-h-screen">
    <div class="row p-2 bg-info">
        
    @foreach ($models as $model)
        <div class="card col-1 mx-2">
            <a href="{{ route('models3d.show', $model->id) }}" class="card__link">
            <div class="card__shine"></div>
            <div class="card__glow"></div>
            <div class="card__content">
                <div style="--bg-color: #a78bfa" class="card__image">
                    @if ($model->image)
                        <img src="{{ asset('storage/' . $model->image) }}" alt="{{ $model->name }}" class="w-full h-full object-cover rounded-md">
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
                                fill="black"
                            ></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>
        </div>
    @endforeach
    </div>
</div>
@endsection