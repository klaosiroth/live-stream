@extends('adminlte::page')

@section('title', 'เพิ่มรายการ')

@section('content_header')
    <h1 class="m-0 text-dark d-flex">
        เพิ่มรายการ
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
                    <form action="/program/add" method="POST">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="countryName">ชื่อรายการ</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="countryName" required>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="more" {{ old('more') == 'on' ? 'checked':'' }} class="form-check-input" id="checkBox">
                            <label class="form-check-label" for="checkBox">ต้องการเพิ่มหลายรายการ</label>
                        </div>
                        <button type="submit" class="btn-block btn btn-success">
                            <i class="fas fa-plus-circle"></i>
                            เพิ่ม
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
