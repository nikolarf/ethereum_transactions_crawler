<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $address;
    private $first;
    private $end;
    private $exchangeRate;
    private $ethPrice;
    private $btc;
    private $usd;
    private $eur;
    private $cad;
    private $arr;
    private $time;
    private $arr_time;

    public function __construct(){
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

    
    public function getNormalTransactions(Request $request){

        $this->address = $request->address;

        if(isset($request->first) && $request->first != NULL){
            $this->first = $request->first;
        }else{
            $this->first=NULL;
        }

        if(isset($request->end)&& $request->end!=NULL){
            $this->end = $request->end;
        }else{
            $this->end=NULL;
        }

        $urlNormal = "https://api.etherscan.io/api?module=account&action=txlist&address=" . $this->address . "&startblock=" . $this->first . "&endblock=" . $this->end . "&apikey=" . env('API_KEY');

        $urlNormal = (array)json_decode(file_get_contents($urlNormal));

        $dataUrlNormal = $urlNormal['result'];
        $dataUrlNormal = $this->paginateNormal($dataUrlNormal);
        
        return view('home', ['dataUrlNormal' => $dataUrlNormal, 'arr' => $this->arr]);
    }

    public function paginateNormal($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $url = '/getNormalTransactions?address=' . $this->address . '&first=' . $this->first . '&end=' . $this->end;
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => $url]);
    }

    public function getInternalTransactions(Request $request){

        $this->address = $request->address;

        if(isset($request->first) && $request->first != NULL){
            $this->first = $request->first;
        }else{
            $this->first=NULL;
        }

        if(isset($request->end)&& $request->end!=NULL){
            $this->end = $request->end;
        }else{
            $this->end=NULL;
        }

        $urlInternal = "https://api.etherscan.io/api?module=account&action=txlistinternal&address=" . $this->address . "&startblock=" . $this->first . "&endblock=" . $this->end . "&apikey=" . env('API_KEY');

        $urlInternal = (array)json_decode(file_get_contents($urlInternal));

        $dataUrlInternal = $urlInternal['result'];
        $dataUrlInternal = $this->paginateInternal($dataUrlInternal);

        //dd($dataUrlInternal);
        
        return view('home', ['dataUrlInternal' => $dataUrlInternal, 'arr' => $this->arr]);
    }

    public function paginateInternal($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $url = '/getInternalTransactions?address=' . $this->address . '&first=' . $this->first . '&end=' . $this->end;
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => $url]);
    }

    public function getTimeTransactions(Request $request){
        $this->address = $request->address;
        $this->time = $request->time;

        if(isset($request->first) && $request->first != NULL){
            $this->first = $request->first;
        }else{
            $this->first=NULL;
        }

        if(isset($request->end)&& $request->end!=NULL){
            $this->end = $request->end;
        }else{
            $this->end=NULL;
        }

        $urlNormal = "https://api.etherscan.io/api?module=account&action=txlist&address=" . $this->address . "&startblock=9000000&endblock=" . $this->end . "&apikey=" . env('API_KEY');
        
        $urlNormal = (array)json_decode(file_get_contents($urlNormal));

        $dataUrlTime = $urlNormal['result'];

        $count = 0;
        foreach($dataUrlTime as $key=>$value){
            
            if((string)date('m/d/Y', $dataUrlTime[$key]->timeStamp) == $this->time){
                $this->arr_time[]=$dataUrlTime[$key];
                $count = 1;
            }
        }   

        if($count==1){
            return view('home', ['dataUrlTime' => $dataUrlTime, 'arr_time' => $this->arr_time, 'arr' => $this->arr]);
        }else{
            echo "timestamp not found";die();
        }
    }
}
