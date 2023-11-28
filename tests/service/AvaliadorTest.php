<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {

        // ARRANGE - ACT

        $leiloeiro = new Avaliador();

        // ACT - WHEN
        $leiloeiro->avalia($leilao);
        $maiorValor = $leiloeiro->getMaiorValor();

        // ASSERT - THEN

        self::assertEquals(2500, $maiorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {

        // ARRANGE - ACT
        $leiloeiro = new Avaliador();

        // ACT - WHEN
        $leiloeiro->avalia($leilao);
        $menorValor = $leiloeiro->getMenorValor();

        // ASSERT - THEN

        self::assertEquals(1700, $menorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorDeveBuscar3MaioresValores(Leilao $leilao)
    {
        // ARRANGE - ACT
        $leiloeiro = new Avaliador();

        // ACT - WHEN
        $leiloeiro->avalia($leilao);
        $maiores = $leiloeiro->getMaioresLances();

        // ASSERT - THEN

        self::assertCount(3, $maiores);

        self::assertEquals(2500, $maiores[0]->getValor());
        self::assertEquals(2000, $maiores[1]->getValor());
        self::assertEquals(1700, $maiores[2]->getValor());
    }

    static public function leilaoEmOrdemCrescente()
    {
        // ARRANGE - ACT
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($joao, 2500));

        return [[$leilao]];
    }

    static public function leilaoEmOrdemDecrescente()
    {
        // ARRANGE - ACT
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($joao, 2500));
        $leilao->recebeLance(new Lance($maria, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return [[$leilao]];
    }

    static public function leilaoEmOrdemAleatoria()
    {
        // ARRANGE - ACT
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');
        $ana = new Usuario('Ana');

        $leilao->recebeLance(new Lance($joao, 2500));
        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($maria, 2000));

        return [[$leilao]];
    }
}
