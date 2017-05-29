<?php

class Comissao extends TbComissao {
	
	public function search($filtros) {
		return $this->ListarComissoesUsuario($filtros);
	}
}