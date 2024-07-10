<?php

namespace BoneCreative\CheckFront\Controllers;

use App\Http\Controllers\Controller;
use BoneCreative\CheckFront\Client as CheckFront;
use BoneCreative\CheckFront\Requests\AncillaryRegionRequest;
use BoneCreative\CheckFront\Requests\DetailRequest;
use Carbon\Carbon;
use FuquIo\LaravelExchangeRates\Client;
use FuquIo\LaravelWorld\Country;
use FuquIo\LaravelWorld\Currency;

class AncillaryController extends Controller
{
    //
    public function regions(AncillaryRegionRequest $request)
    {
        $states = Country::where('iso_a2', $request->country)->firstOrFail()->States;
        
        $ret = [];
        foreach($states as $state){
            $ret[] = [
                'label' => $state->name,
                'value' => $state->iso_a2,
            ];
        }
        
        return $ret;
    }
    
    public function fee(DetailRequest $request, CheckFront $checkfront)
    {
        $params = [
            'date'    => Carbon::parse($request->date)->format('Ymd'),
            'item_id' => $request->details,
            'param'   => ['qty' => $request->quantity],
        ];
        
        $checkfront->item($params);
        
        if($checkfront->rate['status'] != 'AVAILABLE'){
            return [];
        }
        
        //$stamp   = Carbon::parse($request->date->format('Y-m-d') . ' ' . $checkfront->rate['start_time']);
        $pricing = DetailController::makePriceChart($checkfront);
        
        try{
            $ret = [
                'id'      => $request->details,
                'name'    => $checkfront->record['name'],
                'status'  => $checkfront->rate['status'],
                'hint'    => ($checkfront->record['stock'] > 10) ? 'Available' : $checkfront->rate['summary']['title'],
                //'time'    => $stamp->format('g:i a'),
                'pricing' => $pricing,
                'limit'   => $checkfront->rate['available'],
                //'token'   => $checkfront->rate['slip'],
            ];
        }catch(\Exception $e){
            abort(500, $e->getMessage());
        }
        
        
        return $ret;
    }
    
    public function exchangeRates(Client $client, CheckFront $checkfront)
    {
        return $client->getRates();
    }
    
    public function currencySymbol($currency)
    {
        return Currency::with('Symbol')->whereCode($currency)->first()->Symbol->character
            ?? '';
    }
    
}
