<?php

class DescontoProfissional extends Desconto {
  
    public function retornaDesconto(): float {
        return 0.2; // desconto de 20% para profissionais
    }
}