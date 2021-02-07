<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use Pts\Lcom\Graph\GraphDeduplicated;
use Pts\Lcom\Graph\GraphNode;

class MethodController extends NodeVisitorAbstract
{
    private $traverser;
    private $method;
    
     //try to find method
     public function trytofindmethod()
     {
         $this->method    = new MethodVisitor();
         $this->traverser = new NodeTraverser();
         $this->traverser->addVisitor($this->method);
     }

     public function leaveNode(Node $node)
     {
         if ($node instanceof Class_ || $node instanceof Trait_) {
             $this->fetchNode($node);
         }
 
         return null;
     }

     private function nodeName(ClassLike $node): string
     {
         if ($node instanceof Class_ && $node->isAnonymous() === true) {
             return 'anonymous@' . spl_object_hash($node);
         }
 
         return $node->namespacedName->toString();
     }

     private function fetchNode(ClassLike $node): void
    {
        $name  = $this->nodeName($node);
        $graph = new GraphDeduplicated();
        $temp = 0;
        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof ClassMethod) {
                if ($graph->has($stmt->name . '()') === false) {
                    $graph->insert(new GraphNode($stmt->name . '()'));
                    $temp+=1;
                }

                $from = $graph->get($stmt->name . '()');
                $this->method->setGraph($graph, $from);
                $this->traverser->traverse([$stmt]);
            }
        }
        // $arr = array();
        // array_push($arr, (string) $temp);
        // // print_r($arr);
        // file_put_contents('lcom.txt',print_r($arr));
        // // $myfile = fopen("lcom.txt","w");
        // // fwrite($myfile, (string) $arr);
        // // fclose($myfile);
    }
     
}
