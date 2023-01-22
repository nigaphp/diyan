<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest as Request;
use Niga\Diyan\Diyan;

use function PHPUnit\Framework\assertEquals;

class DiyanTest extends TestCase
{
    public $diyan;

    public function setUp(): void
    {
        $this->diyan = new Diyan(Request::fromGlobals());
        $this->diyan->render('test');
    }
    
    /**
     * @test
     */
    public function get_only_view()
    {
        $onlyView = $this->diyan->getOnlyView();
        assertEquals($onlyView, file_get_contents('./views/test.php'));
    }
    
    /**
     * @test
     */
    public function get_base_view()
    {
      assertEquals($this->diyan->getBaseView(), str_replace("{{body}}", $this->diyan->getOnlyView(), $this->diyan->getBaseView()));
    }
    
    /**
     * @test
     */
    public function set_and_get_body()
    {
        $this->diyan->setBody("<h1>Code html</>");
        assertEquals($this->diyan->getOnlyView(), "<h1>Code html</>");
    }
    
}