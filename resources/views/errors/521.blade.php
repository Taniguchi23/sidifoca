@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '521')
@section('message', 'El token no es válido o esta vencido para esta página, recargué la página anterior')
