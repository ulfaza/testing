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
                            {{-- <th  style="text-align: center">ID</th>
                            <th  style="text-align: center">Karakteristik</th>
                            <th  style="text-align: center">Deskripsi</th>
                            <th  style="text-align: center">Nilai Karakteristik</th>
                            <th  style="text-align: center">Keterangan</th> --}}
                            <th>ID</th>
                            <th>Karakteristik</th>
                            <th>Bobot Karakteristik</th>
                            <th>Nilai karakteristik</th>
                            <th>Sub Karakteristik</th>
                            <th>Bobot Relatif</th>
                            <th>Bobot Absolut</th>
                            <th>Nilai Subkarakteristik</th>
                            <th>Nilai Absolut</th>
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


{{-- @extends('layouts.plain')
    
@section('content')
    <div class="col-md-12 padding-0">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">    
                    @include('admin.shared.components.alert')
                    <div class="responsive-table">
                        <table id="datatables-example" class="table table-bordered">
                            <thead>
                                <th>ID</th>
                                <th>Karakteristik</th>
                                <th>Bobot Karakteristik</th>
                                <th>Nilai karakteristik</th>
                                <th>Sub Karakteristik</th>
                                <th>Bobot Relatif</th>
                                <th>Bobot Absolut</th>
                                <th>Nilai Subkarakteristik</th>
                                <th>Nilai Absolut</th>
                            </thead>
                            <tbody>
                                @foreach($subkarakteristiks as $key => $s)
                                    <tr>                                
                                    @if (@$subkarakteristiks[$key - 1]->k_nama != $s->k_nama)
                                        <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $no++ }}</td>
                                        <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $s->k_nama }}</td>
                                        <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $s->k_bobot }}</td>
                                        <td rowspan="{{ $rowspan[$s->k_nama] }}">81.25</td>
                                    @endif
                                        <td>{{ $s->sk_nama }}</td>
                                        <td>{{ $s->bobot_relatif }}</td>
                                        <td>{{ $s->bobot_absolut }}</td>
                                        <td>{{ $s->nilai_subfaktor }}</td>
                                        <td>{{ $s->nilai_absolut }}</td>                                        
                                    </tr>                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}