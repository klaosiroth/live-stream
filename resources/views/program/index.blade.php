@extends('adminlte::page')

@section('title', 'รายการ')

@section('content_header')
    <h1 class="m-0 text-dark d-flex">รายการ
        <a href="/program/add" class="ml-auto btn btn-success">
            <i class="fas fa-plus-circle"></i> เพิ่ม
        </a>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" dataTable>
                            <thead>
                                <tr>
                                    <th width="1%" data-orderable="false">#</th>
                                    <th>ชื่อ</th>
                                    <th width="25%" data-orderable="false">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($data) && count($data) > 0)
                                    @foreach ($data as $key => $d)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $d->name }}</td>
                                            <td>
                                                <a href="/program/edit/{{ $d->id }}" class="btn btn-warning"><i class="fas fa-edit"></i> แก้ไข</a>
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
        function deleteById(id, name) {
            Swal.fire({
                title: `ลบรายการ ${name} ใช่ไหม ?`,
                text: `หากลบข้อมูลแล้วจะไม่สามารถนำกลับคืนมาได้`,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'ยกเลิกการลบ',
                confirmButtonColor: '#D22',
                confirmButtonText: 'ลบข้อมูลทันที'
            }).then((result) => {
                if (result.isConfirmed) {
                    formDelete.action = `/program/delete/${id}`;
                    formDelete.submit();
                }
            });
        }
    </script>
@endsection
