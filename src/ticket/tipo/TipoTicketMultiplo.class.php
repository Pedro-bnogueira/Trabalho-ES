<?php

class TipoTicketMultiplo extends TipoTicket {

    public function getPreco(): float {
        return 10.0; // Múltiplo com custo de R$10,00
    }
}