@extends('adminlte::page')

@section('title', 'ตารางการแข่ง')

@section('content_header')
    <h1 class="m-0 text-dark d-flex">ตารางการแข่ง
        <a href="/schedule/add" class="ml-auto btn btn-success">
            <i class="fas fa-plus-circle"></i> เพิ่ม
        </a>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="input-group mb-3 row">
                <div class="col-md-3 input-group-prepend">
                    <span class="w-100 justify-content-center input-group-text"><i class="fas fw-fw fa-filter"></i> กรองจากรายการ</span>
                </div>
                <div class="col-md-9">
                    <select class="form-control" onchange="filterProgram(event.target.value)" select2>
                        @if (isset($program) && count($program) > 0)
                            <option value="all" {{ Request::is('schedule') ? 'selected' : '' }}>ทั้งหมด</option>
                            @foreach ($program as $key => $d)
                                <option value="{{ $d->id }}" {{ Request::is("schedule/program/$d->id") ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        @else
                            <option value="" selected disabled>ไม่พบข้อมูลรายการในระบบ</option>
                        @endif
                    </select>
                </div>
            </div>
            <form class="row">
                <div class="col-md-5 input-group mb-3 row">
                    <div class="col-md-3 input-group-prepend">
                        <span class="w-100 justify-content-center input-group-text"><i class="fas fw-fw fa-calendar"></i>&nbsp; จากวันที่</span>
                    </div>
                    <div class="col-md-9">
                        <input class="form-control" type="datetime-local" name="from" id="" value="{{ $request->from ?? date('Y-m-d\T00:00') }}">
                    </div>
                </div>
                <div class="col-md-5 input-group mb-3 row">
                    <div class="col-md-3 input-group-prepend">
                        <span class="w-100 justify-content-center input-group-text"><i class="fas fw-fw fa-calendar"></i>&nbsp; ถึงวันที่</span>
                    </div>
                    <div class="col-md-9">
                        <input class="form-control" type="datetime-local" name="to" id="" value="{{ $request->to ?? date('Y-m-d\T23:59') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-primary"><i class="fas fa-fw fa-search"></i> ค้นหา</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" dataTable>
                            <thead>
                                <tr>
                                    <th width="1%" data-orderable="false">#</th>
                                    <th>รายการ</th>
                                    <th>เจ้าบ้าน</th>
                                    <th>ทีมเยือน</th>
                                    <th>วันที่ - เวลา การแข่งขัน</th>
                                    <th>สตรีมแพลตฟอร์ม</th>
                                    <th width="25%" data-orderable="false">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data) && count($data) > 0)
                                    @foreach ($data as $key => $d)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $d->program->name }}</td>
                                            <td>{{ $d->home }}</td>
                                            <td>{{ $d->away }}</td>
                                            <td>{{ date('d/m/Y H:i', strtotime($d->match_time)) }}</td>
                                            <td>
                                                @php
                                                    $platform = [];
                                                    if (isset($d->youtube)) {
                                                        array_push($platform, 'Youtube');
                                                    }
                                                    if (isset($d->facebook)) {
                                                        array_push($platform, 'Facebook');
                                                    }
                                                    if (!isset($d->youtube) && !isset($d->facebook)) {
                                                        array_push($platform, 'ไม่มี');
                                                    }
                                                @endphp
                                                {{ join(',', $platform) }}
                                            </td>
                                            <td>
                                                <a href="/schedule/edit/{{ $d->id }}" class="btn btn-warning"><i class="fas fa-edit"></i> แก้ไข</a>
                                                <button onclick="deleteById({{ $d->id }},'{{ $d->name }}')" class="btn btn-danger"><i class="fas fa-trash-alt"></i> ลบ</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="formDelete" class="d-none" action="" method="POST">
        @method('delete')
        @csrf
    </form>
@stop

@section('adminlte_js')
    <script>
        function filterProgram(value) {
            if (Number.isInteger(parseInt(value))) {
                return window.location.href = `/schedule/program/${value}` + window.location.search
            } else {
                return window.location.href = '/schedule' + window.location.search
            }
        }

        function deleteById(id, name) {
            Swal.fire({
                title: `ลบตารางการแข่ง ${name} ใช่ไหม ?`,
                text: `หากลบข้อมูลแล้วจะไม่สามารถนำกลับคืนมาได้`,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'ยกเลิกการลบ',
                confirmButtonColor: '#D22',
                confirmButtonText: 'ลบข้อมูลทันที'
            }).then((result) => {
                if (result.isConfirmed) {
                    formDelete.action = `/schedule/delete/${id}`;
                    formDelete.submit();
                }
            });
        }
    </script>
@endsection
