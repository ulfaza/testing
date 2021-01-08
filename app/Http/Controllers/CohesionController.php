<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use PhpParser\ParserFactory;
use Pts\Lcom\AstTraverser;
use Pts\Lcom\PhpParser;
use \Pts\Lcom\LcomVisitor;

use App\Karakteristik;
use App\SubKarakteristik;
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
        
        //Read file content
        $content = file_get_contents($path. $filename);
        
        //Parse file content 
        $this->parser->parse($content);

        $lcom = $this->lcom->getLcom();
        // return $lcom;
        $this->assertSame($count, $lcom[$content]);
        return $this->assertSame($count, $lcom[$name]);
      }

}
