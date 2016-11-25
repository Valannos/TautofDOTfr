<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tautof\PlatformBundle\Antispam;

class TautofAntispam {

   
    private $mailer;
    private $local;
    private $minLenght;
    
    public function isSpam($text) {
        
        return strlen($text) < $this->minLenght;
    }
    
    public function __construct(\Swift_Mailer $mailer, $local, $minLenght) {
        
        $this->mailer = $mailer;
        $this->local = $local;
        $this->minLenght = (int) $minLenght;
        
    }
    
    
    
    

}
