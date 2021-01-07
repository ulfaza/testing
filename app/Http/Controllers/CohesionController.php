<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use LcomVisitor;

use Illuminate\Http\Request;
use PhpParser\ParserFactory;
use Pattisahusiwa\Lcom\AstTraverser;
use Pattisahusiwa\Lcom\PhpParser;

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
        
        //Get teh file name and its directory path
        $subkarakteristik = SubKarakteristik::findOrFail($sk_id);
        $filename = $subkarakteristik->karakteristik->aplikasi->a_file;
        $apps_id = $subkarakteristik->karakteristik->aplikasi->a_id;
        // $path = public_path()."/".$apps_id."/".$filename;
        $path = public_path()."/".$apps_id."/";
        
        //Read the file content
        $content = file_get_contents($path. $filename);
        return $content;
        //Parse the file content 
        $this->parser->parse($content);

        $lcom = $this->lcom->getLcom();
        $this->assertSame($count, $lcom[$name]);
        // return $this->assertSame($count, $lcom[$name]);
        
      }

}
