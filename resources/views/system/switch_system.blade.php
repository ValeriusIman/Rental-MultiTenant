@extends('template.base')
@section('title','Switch System')
@section('description','Switch System')
@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listing</h3>
                </div>
                <div class="card-body">
                    <table id="data-user-mapping" class="table table-bordered table-hover">
                        <thead>
                        <tr style="background-color: #2E4053;">
                            <th style="color: #ecf0f1;">#</th>
                            <th style="color: #ecf0f1;">Name</th>
                            <th style="color: #ecf0f1;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userMapping as $ump)
                            <tr>
                                @if($ump['ump_ss_id'] !== $session['ss_id'])
                                <td>{{$loop->iteration}}</td>
                                <td>{{$ump['ump_ss_relation']}}</td>
                                <td>
                                    <a href="{{route('/doSwitchSystem',$ump['ump_ss_id'])}}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-fw fa-sign-in-alt"></i></a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $("#data-user-mapping").DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
