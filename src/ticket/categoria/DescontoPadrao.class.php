<?php

class DescontoPadrao extends Desconto {

    public function retornaDesconto(): float {
        return 0.0; // 0% de desconto para Padrão
    }
}