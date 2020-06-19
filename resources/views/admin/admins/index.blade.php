@extends('admin.index')
@section('content')


<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{$title}}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            {{$dataTable->table(['calss'=>'dataTable table table-bordered table-hover'],true)}}
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          @push('js')
{!! $dataTable->scripts() !!}
@endpush
@endsection