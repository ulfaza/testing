@extends('layouts.plain')

@section('content')
  <div class="col-md-12 padding-0">
      <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">    
                @include('admin.shared.components.alert')
                <div class="responsive-table" >
                    <table id="datatables-example" class="table table-bordered">
                        <thead>
                            <th  style="text-align: center">ID</th>
                            <th  style="text-align: center">Karakteristik</th>
                            <th  style="text-align: center">Deskripsi</th>
                            <th  style="text-align: center">Nilai Karakteristik</th>
                            <th  style="text-align: center">Keterangan</th>
                        </thead>
                        <tbody>
                            @foreach($subkarakteristiks as $key => $s)
                                <tr>                                
                                @if (@$subkarakteristiks[$key - 1]->k_nama != $s->k_nama)
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $s->k_nama }}</td>
                                    <td>{{ $s->k_desc }}</td>
                                    <td  style="text-align: center">{{ $s->k_final_nilai }}</td>
                                    @if ($s->k_final_nilai < 70)
                                    <td>{{ 'Tidak Terpenuhi' }}</td>
                                    @elseif ($s->k_final_nilai >= 70)
                                    <td>{{ 'Terpenuhi' }}</td>
                                    @endif    
                                @endif                            
                                </tr>                                
                            @endforeach
                        </tbody>
                    </table>    
                    <button  class="btn btn-primary" onclick="window.print()">Print</button>      
                </div>
            </div>
        </div>
      </div>
  </div>
@endsection