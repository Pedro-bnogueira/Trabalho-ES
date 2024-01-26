<?php

class DescontoEstudante extends Desconto {

    public function retornaDesconto(): float{
        return 0.5; // 50% de desconto
    }
}