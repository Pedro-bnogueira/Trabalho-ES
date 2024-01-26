<?php

class DescontoIdoso extends Desconto {
    public function retornaDesconto(): float {
        return 1.0; // desconto de 100% para estudante
    }
}