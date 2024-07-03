<?php

	/* classe abstrata é apenas estrutural (serve para ser base para as filhas). 
	NUNCA deve ser instanciada como objeto comum*/

	abstract class Conta{

		/* protected sao variaveis que serão vistas pela propria classe e seus filhos/herdeiros */
		protected $saldo;
		protected $agencia;
		protected $conta;

		public function __construct($saldo, $agencia, $conta){
			$this->saldo = $saldo;

			$this->agencia = $agencia;

			$this->conta = $conta;
		}

		/* o FINAL em metodos diz que esse metodo NÃO pode ser sobrescrito nos filhos */
		public final function getDetalhes(){
			return "Agencia {$this->saldo}, conta: {$this->conta}, saldo: {$this->saldo}";
		}

		public function depositarSaldo($saldo){
			$this->saldo += $saldo;

			echo "Novo saldo: $this->saldo <br>";
		}

		/* o ABSTRACT em metodo, é apenas a assinatura dele. Diz que os filhos tem que obrigatoria-
		mente implementar getSaldo */
		public abstract function getSaldo($saldo);
	}

	/* FINAL serve para dizer que a class poupança não pode ser pai de ninguem */
	final class Poupanca extends Conta{

		public function getSaldo($saldo){
			return "O saldo atual {$this->saldo} e o saldo a colocar é $saldo";
		}

		public function saque($saque){
			if ($this->saldo >= $saque){

				$this->saldo -= $saque; 

				echo "Saque de $saque. Novo saldo {$this->saldo}<br>";
			}

			else{
				echo "Saque não autorizado. Saldo de {$this->saldo}<br>";
			}
		}
	}

	final class Corrente extends Conta{

		protected $limite;

		public function __construct($saldo, $agencia, $conta, $limite){
			$this->limite = $limite;

			parent::__construct($saldo, $agencia, $conta);
		}

		public function getSaldo($saldo){
			return "O saldo atual {$this->saldo} e o saldo a colocar é $saldo";
		}

		public function depositarSaldo($saldo){
			parent::depositarSaldo($saldo);

			echo "limite: {$this->limite}<br>";
		}

		public function saque($saque){
			if ( ($this->saldo + $this->limite ) >= $saque){

				$this->saldo -= $saque; 

				echo "Saque de $saque. Novo saldo {$this->saldo}, limite {$this->limite}<br>";
			}

			else{
				echo "Saque não autorizado. Saldo de {$this->saldo}<br>";
			}
		}
		
	}

	/* caso por exemplo, queira se criar uma classe Poupança universitaria, no modelo apresentado acima,
	com o FINAL em poupança, so podemos criar essa classe "poupança universitaria" vinda de Conta e não de
	Poupança */

	$conta = new Corrente(1000, '1010', '5674', 500);
	$conta->depositarSaldo(600);
	$conta->saque(1200);
	$conta->saque(2200);

	var_dump($conta);
?>