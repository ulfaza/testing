<?php

namespace App\Http\Controllers;
use PhpParser\ParserFactory;
use Pts\Lcom\AstTraverser;
use Pts\Lcom\PhpParser;
use Pts\Lcom\LcomVisitor;
use App\SubKarakteristik;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use Pts\Lcom\Graph\GraphDeduplicated;
use Pts\Lcom\Graph\GraphNode;
use PhpParser\NodeTraverserInterface;
use App\Karakteristik;
use App\Aplikasi;
use Illuminate\Support\Facades\DB;

class CohesionController extends Controller
{
      /** @var LcomVisitor */
      private $lcom;
     
      /** @var PhpParser */
      private $parser;

      private $cfncn;
  
      protected function setUp(): void
      {
          $this->lcom = new LcomVisitor();
  
          $factory   = new ParserFactory();
          $parser    = $factory->create(ParserFactory::PREFER_PHP7);
          $traverser = new AstTraverser();
  
          $this->parser = new PhpParser($parser, $traverser);
          $this->parser->addVisitor($this->lcom);
      }

      public function cohesion($sk_id){
  
        //Get file name and its directory path
        $subkarakteristik = SubKarakteristik::findOrFail($sk_id);
        $filename = $subkarakteristik->karakteristik->aplikasi->a_file;
        $apps_id = $subkarakteristik->karakteristik->aplikasi->a_id;
        $path = public_path()."/".$apps_id."/";
        
        //Read file content
        $content = file_get_contents($path. $filename);
        $this->setUp();

          //Parse file content 
        $this->parser->parse($content);
        $lcom = $this->lcom->getLcom();
        // dd ($lcom);
        
        $sum = 0;
        $hasil = [];
        foreach ($lcom as $value) {
          $sum++;
          array_push($hasil, $value);
        }
        $result = [];
        for($i=0;$i<$sum;$i++){
          if($i%2 != 0){
            $output = 1 - ($hasil[$i-1]/$hasil[$i]);
            array_push($result, $output);
          }
        }
        $total = array_sum($result);
        $n = sizeof($result);
        $final_result = ($total/$n)*100;
        
        $subkarakteristik->nilai_subfaktor = $final_result;
        $subkarakteristik->bobot_absolut 	= $subkarakteristik->karakteristik->k_bobot * $subkarakteristik->bobot_relatif;
        $subkarakteristik->nilai_absolut 	= $subkarakteristik->bobot_absolut * $subkarakteristik->nilai_subfaktor;
        $subkarakteristik->save();

        // insert nilai karakteristik
        $karakteristik = Karakteristik::findOrFail($subkarakteristik->karakteristik->k_id);
        $total = DB::table('subkarakteristik')->where('k_id','=', $karakteristik->k_id)->sum('nilai_absolut');
        $temp_total = ($total/($karakteristik->k_bobot*100))*100;
        $karakteristik->k_nilai = $total;
        $karakteristik->k_final_nilai = $temp_total;
        $karakteristik->save();

        //insert nilai aplikasi
        $aplikasi = Aplikasi::findOrFail($karakteristik->aplikasi->a_id);
        $totalapp = DB::table('karakteristik')->where('a_id', '=', $aplikasi->a_id)->sum('k_nilai');
        $aplikasi->a_nilai = $totalapp;


        if ($aplikasi->save()) {
        	return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('success', 'Modularity berhasil diukur');
        }
        else {
            return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('error', 'Modularity gagal diukur');
        }

  
      }
}