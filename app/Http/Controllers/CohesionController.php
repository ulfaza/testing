<?php

namespace App\Http\Controllers;
use PhpParser\ParserFactory;
use Pts\Lcom\AstTraverser;
use Pts\Lcom\PhpParser;
use Pts\Lcom\LcomVisitor;
use App\SubKarakteristik;
use App\Karakteristik;
use App\Aplikasi;

class CohesionController extends Controller
{
      /** @var LcomVisitor */
      private $lcom;

      /** @var PhpParser */
      private $parser;
  
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
        // return $path;
        
        //Read file content
        $content = file_get_contents($path. $filename);
        // return $content;

        $lastPos = 0;
        $lastFun = 0;
        $classnames = [];
        $functions = [];
        $classes = [];
        $current_class = '';

        // while(($lastPos = strpos($content, "class ", $lastPos)) !== false){
        //   $startsAt = strpos($content, "class ", $lastPos) + strlen("class ");
        //   $endsAt = strpos($content, "{", $startsAt);
        //   $res = trim(substr($content, $startsAt, $endsAt - $startsAt));
        //   $classnames[] = explode(" ", $res)[0];
        //   $lastPos = $endsAt + 1;  
        // }   

        while(($lastPos = strpos($content, "class ", $lastPos)) !== false){
          if(@$content[$lastPos - 1] == '$') {
            $lastPos++;
            continue;
          }
          $startsAt = strpos($content, "class ", $lastPos) + strlen("class ");
          $endsAt = strpos($content, "{", $startsAt);
          $res = trim(substr($content, $startsAt, $endsAt - $startsAt));
          $classnames[] = explode(" ", $res)[0];

          $lastPos = $endsAt + 1;
        }

        $this->setUp();
        //Parse file content 
        $this->parser->parse($content);
        $lcom = $this->lcom->getLcom();
        
        $result = [];    
        foreach ($classnames as $key => $value)
          $result[$value] = $lcom[$value];
        // return $result;
      }

      // ikut punya ulfa hehe
      $hasil = $result/1;
      $subkarakteristik->nilai_subfaktor = $hasil;
      $subkarakteristik->bobot_absolut 	= $subkarakteristik->karakteristik->k_bobot * $subkarakteristik->bobot_relatif;
      $subkarakteristik->nilai_absolut 	= $subkarakteristik->bobot_absolut * $subkarakteristik->nilai_subfaktor;
      $subkarakteristik->save();

      // insert nilai karakteristik
      $karakteristik = Karakteristik::findOrFail($subkarakteristik->karakteristik->k_id);
      $total = DB::table('subkarakteristik')->where('k_id','=', $karakteristik->k_id)->sum('nilai_absolut');
      $karakteristik->k_nilai = $total;
      $karakteristik->save();

      //insert nilai aplikasi
      $aplikasi = Aplikasi::findOrFail($karakteristik->aplikasi->a_id);
      $totalapp = DB::table('karakteristik')->where('a_id', '=', $aplikasi->a_id)->sum('k_nilai');
      $aplikasi->a_nilai = $totalapp;

      if ($aplikasi->save()) {
        return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('success', 'Url berhasil direquest');
      }
      else {
          return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('error', 'Url gagal direquest');
      }

}
