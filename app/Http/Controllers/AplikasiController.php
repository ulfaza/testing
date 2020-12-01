<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Aplikasi;
use App\Karakteristik;
use App\Subkarakteristik;
use App\PenilaianKarakteristik;
use App\PenilaianSubKarakteristik;

class AplikasiController extends Controller
{
    public function index()
    {
        $data['aplikasis'] = Aplikasi::all();
        return view('/aplikasi',$data);
    }
    public function nilai($a_id)
    {
        $data['no'] = 1;
        $data['aplikasis'] = Aplikasi::where('a_id',$a_id)->get();
        $data['ps'] = DB::table('penilaiansubkarakteristik')
        ->join('penilaiankarakteristik', 'penilaiankarakteristik.pk_id', '=', 'penilaiansubkarakteristik.pk_id')
        ->join('subkarakteristik','subkarakteristik.sk_id','=','penilaiansubkarakteristik.sk_id')
        ->join('aplikasi','aplikasi.a_id','=','penilaiankarakteristik.a_id')
        ->join('karakteristik','karakteristik.k_id','=','penilaiankarakteristik.k_id')
        ->where('aplikasi.a_id',$a_id)->get();
        return view('/nilai_app',$data);
    }

    public function insert()
    {
        return view('/tambah_aplikasi');
    }

    public function edit($a_id)
    {
        $aplikasi = Aplikasi::findOrFail($a_id);
        return view('/edit_aplikasi')->with('aplikasi', $aplikasi);
    }

    public function update(Request $request, $a_id){
        $aplikasi = Aplikasi::findorFail($a_id);
        $this->validate($request,[
            'a_nama'      =>['required'],
        ]);
        $aplikasi->a_nama       = $request->a_nama;
            
  
        if ($aplikasi->save())
          return redirect()->route('index.aplikasi');
    }

    public function store(Request $request)
    {
        $apps = Aplikasi::all()->count();
        $pk = PenilaianKarakteristik::all()->count();
        $pk+=1;

        $ps = PenilaianSubkarakteristik::all()->count();
        $ps+=1;

        $aplikasi = new aplikasi;
        $aplikasi->a_id      = $apps+1;
        $aplikasi->id        = Auth::user()->id;
        $aplikasi->a_nama    = $request->a_nama;
        $aplikasi->a_url     = $request->a_url;
        $aplikasi->a_total   = 0;
        $aplikasi->save();

        DB::insert('insert into penilaiankarakteristik (pk_id, a_id, k_id, pk_nilai) values(?,?,?,?)',
        [$pk++, $aplikasi->a_id, 1, 0]
        );
        DB::insert('insert into penilaiankarakteristik (pk_id, a_id, k_id, pk_nilai) values(?,?,?,?)',
        [$pk++, $aplikasi->a_id, 2, 0]
        );
        DB::insert('insert into penilaiankarakteristik (pk_id, a_id, k_id, pk_nilai) values(?,?,?,?)',
        [$pk++, $aplikasi->a_id, 3, 0]
        );
        DB::insert('insert into penilaiankarakteristik (pk_id, a_id, k_id, pk_nilai) values(?,?,?,?)',
        [$pk++, $aplikasi->a_id, 4, 0]
        );
        DB::insert('insert into penilaiankarakteristik (pk_id, a_id, k_id, pk_nilai) values(?,?,?,?)',
        [$pk++, $aplikasi->a_id, 5, 0]
        );
        DB::insert('insert into penilaiankarakteristik (pk_id, a_id, k_id, pk_nilai) values(?,?,?,?)',
        [$pk++, $aplikasi->a_id, 6, 0]
        );
        DB::insert('insert into penilaiankarakteristik (pk_id, a_id, k_id, pk_nilai) values(?,?,?,?)',
        [$pk++, $aplikasi->a_id, 7, 0]
        );
        DB::insert('insert into penilaiankarakteristik (pk_id, a_id, k_id, pk_nilai) values(?,?,?,?)',
        [$pk++, $aplikasi->a_id, 8, 0]
        );
        
        $no1 = $pk-8;
        $no2 = $pk-7;
        $no3 = $pk-6;
        $no4 = $pk-5;
        $no5 = $pk-4;
        $no6 = $pk-3;
        $no7 = $pk-2;
        $no8 = $pk-1;

        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no1, 1, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no1, 2, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no1, 3, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no2, 4, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no2, 5, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no2, 6, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no3, 7, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no3, 8, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no4, 9, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no4, 10, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no4, 11, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no4, 12, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no4, 13, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no4, 14, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no5, 15, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no5, 16, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no5, 17, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no5, 18, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no6, 19, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no6, 20, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no6, 21, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no6, 22, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no6, 23, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no7, 24, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no7, 25, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no7, 26, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no7, 27, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no7, 28, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no8, 29, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no8, 30, 0, 0, 0, 0, 0]);
        DB::insert('insert into penilaiansubkarakteristik (ps_id, pk_id, sk_id, jml_responden, total_per_sub, bobot_absolut, nilai_subfaktor, nilai_absolut) values(?,?,?,?,?,?,?,?)',
        [$ps++, $no8, 31, 0, 0, 0, 0, 0]);

        return redirect('/softwaretester/aplikasi')->with('success', 'item berhasil ditambahkan');
    }

    public function delete($a_id){
        $aplikasi = Aplikasi::findOrFail($a_id)->delete();
        return redirect()->route('index.aplikasi');
    }
}
