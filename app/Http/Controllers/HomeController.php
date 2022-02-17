<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $address;
    private $first;
    private $end;
    private $exchangeRate;
    private $ethPrice;
    private $btc;
    private $usd;
    private $eur;
    private $cad;
    public $arr;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->ethPrice = 'https://api.etherscan.io/api?module=stats&action=ethprice&apikey=CD5G8JQYWFHJ84A56KM7728NGMMG4UADYD';
        $ethPriceArr = (array)json_decode(file_get_contents($this->ethPrice));
        $this->btc = $ethPriceArr['result']->ethbtc;
        $this->usd = $ethPriceArr['result']->ethusd;
        $this->exchangeRate = 'http://api.exchangeratesapi.io/v1/latest?access_key=25b2098df312b795f17bfb643159a37b&format=1';
        $exchangeRatePrice = (array)json_decode(file_get_contents($this->exchangeRate));
        $this->eur = $this->usd / $exchangeRatePrice['rates']->USD;
        $this->cad = $this->eur * $exchangeRatePrice['rates']->CAD;
        $this->arr = [
            'btc' => number_format($this->btc, 3, '.', ''),
            'usd' => number_format($this->usd, 3, '.', ''),
            'eur' => number_format($this->eur, 3, '.', ''),
            'cad' => number_format($this->cad, 3, '.', ''),
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home')->with('arr', $this->arr);
    }
}
