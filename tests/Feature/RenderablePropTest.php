<?php

namespace Tests\Feature;

use Illuminate\Contracts\Support\Renderable;
use Tests\TestCase;

class RenderablePropTest extends TestCase
{

    public function test_renderable_prop_type(): void
    {
        $money = new RenderableMoney(1000);
        // quote.blade.php : {{gettype($money)}}
        $html = view('quote', ['money' => $money])->render();
        // the money got rendered to string
        $this->assertEquals(trim($html), 'string');
    }

    public function test_nonrenderable_prop_type(): void
    {
        $money = new NonRenderableMoney(1000);
        // quote.blade.php : {{gettype($money)}}
        $html = view('quote', ['money' => $money])->render();
        $this->assertEquals(trim($html), 'object');
    }
}


class RenderableMoney extends NonRenderableMoney implements Renderable
{
    public function render ()
    {
        return $this->format();
    }
}

class NonRenderableMoney
{
    protected $amount, $currency;

    public function __construct($amount, $currency = "INR")
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function format ()
    {
        return $this->currency . ' ' . $this->amount;
    }
}
