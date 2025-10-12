@extends('errors::minimal')

@section('title', __('An Error Occurred: Method Not Allowed'))
@section('code', '405')
@section('message', 'El servidor devolvió un "Método 405 no permitido"')
