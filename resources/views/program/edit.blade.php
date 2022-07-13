@extends('adminlte::page')

@section('title', 'เพิ่มรายการ')

@section('content_header')
    <h1 class="m-0 text-dark d-flex">
        แก้ไขรายการ
        <a href="/program" class="ml-auto btn btn-primary">
            <i class="fas fa-chevron-circle-left"></i> กลับ
        </a>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="/program/edit/{{ $data->id }}" method="POST">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="countryName">ชื่อรายการ</label>
                            <input type="text" name="name" value="{{ old('name') ?? $data->name }}" class="form-control"
                                id="countryName" required>
                        </div>
                        <button type="submit" class="btn-block btn btn-success">
                            <i class="fas fa-save"></i>
                            บันทึก
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
