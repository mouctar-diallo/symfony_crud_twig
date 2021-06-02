<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExoController extends AbstractController
{
    /**
     * @Route("/exo", name="exo")
     */
    public function index()
    {
        //encoder une chaine 
        $testEncode = $this->encode("aaatttcc");
        return new Response($testEncode);
    }

    public function encode($plaintext)
    {
        $encode = '';
        if ($plaintext !== null && $plaintext <=15000) {
            $convertTab = str_split($plaintext);
            $counter = 1;
            for ($i=0; $i < count($convertTab) ; $i++) { 
               if (array_key_exists($i+1, $convertTab) && $convertTab[$i] == $convertTab[$i+1]) {
                   $counter++;
                }else{
                    $encode.= $counter.$plaintext[$i];
                    $counter = 0;
                }
            }
        }
        return $encode;
    }
}
