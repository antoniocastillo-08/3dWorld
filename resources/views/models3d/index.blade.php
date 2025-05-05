@extends("templates.plantilla")
@section("title", "Modelos 3D")
@section("contenido")
    <h1>Modelos 3D</h1>
    <ul>
        @foreach($list_models as $model)
            <li><img src="{{$model->image}}">{{$model->name}}</li>
        @endforeach
    </ul>
@endsection