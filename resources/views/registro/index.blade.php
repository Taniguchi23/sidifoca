@extends('layout')

@section('content')
<div class="container">
    <div class="jumbotron">
        <h1>Inscripción</h1>
        <p>En esta edición del Concurso de Buenas Prácticas de Gestión Educativa, las DRE/GRE y UGEL tienen la
            opción de
            postular en las siguientes modalidades:</p>
        <ul>
            <li><strong>Modalidad Individual</strong>: pueden postular las DRE/GRE y UGEL.</li>
            <li><strong>Modalidad Colectiva</strong>: pueden postular las DRE+UGEL, UGEL+UGEL o UGEL+GOBIERNO LOCAL.
            </li>
        </ul>
        <p>Seleccione una de las modalidades para su inscripción y/o postulación</p>
        <a href="{{ route('individual') }}" class="btn btn-primary btn-block btn-lg">MODALIDAD INDIVIDUAL</a>
        <a href="{{ route('colectiva') }}" class="btn btn-success btn-block btn-lg">MODALIDAD COLECTIVA</a>
        <div class="bases">
            <a href="{{ route('bases_concurso', $token) }}" target="_blank"><img src="{{ asset('images/bot_bases.png') }}" alt=""></a>
            <p class="small">
                DESCARGA LAS BASES
                <br>
                DEL CONCURSO
            </p>
        </div>
    </div>
</div>
@endsection