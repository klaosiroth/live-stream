@extends('adminlte::page')

@section('title', 'เพิ่มตารางารแข่ง')

@section('content_header')
    <h1 class="m-0 text-dark d-flex">
        เพิ่มตารางารแข่ง
        <a href="/schedule" class="ml-auto btn btn-primary">
            <i class="fas fa-chevron-circle-left"></i> กลับ
        </a>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="/schedule/add" method="POST">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="programId">รายการ</label>
                            <select class="form-control" name="programId" id="programId" select2>
                                @if (isset($program) && count($program) > 0)
                                    <option value="" selected disabled>เลือกรายการ</option>
                                    @foreach ($program as $key => $d)
                                        <option value="{{ $d->id }}" {{ $d->id == old('programId') ? 'selected' : '' }}>{{ $d->name }}</option>
                                    @endforeach
                                @else
                                    <option value="" selected disabled>ไม่พบข้อมูลรายการในระบบ</option>
                                @endif
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="HomeName">เจ้าบ้าน</label>
                                <input type="text" name="home" value="{{ old('home') }}" class="form-control" id="HomeName" placeholder="ชื่อทีม เจ้าบ้าน" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="AwayName">ทีมเยือน</label>
                                <input type="text" name="away" value="{{ old('away') }}" class="form-control" id="AwayName" placeholder="ชื่อทีม ทีมเยือน" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="MatchTime">เวลาการแข่งขัน</label>
                            <input type="datetime-local" name="match_time" value="{{ old('match_time') }}" class="form-control" id="MatchTime" required>
                        </div>
                        <div class="form-group">
                            <label for="StreamYoutube">ลิงก์สตรีม Youtube (ถ้ามี)</label>
                            <input type="text" name="youtube" value="{{ old('youtube') }}" class="form-control" id="StreamYoutube" placeholder="ลิงก์สตรีม Youtube">
                        </div> 
                        <div class="form-group">
                            <label for="StreamFacebook">ลิงก์สตรีม Facebook (ถ้ามี)</label>
                            <input type="text" name="facebook" value="{{ old('facebook') }}" class="form-control" id="StreamFacebook" placeholder="ลิงก์สตรีม Facebook">
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" name="more" {{ old('more') == 'on' ? 'checked' : '' }} class="form-check-input" id="checkBox">
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
