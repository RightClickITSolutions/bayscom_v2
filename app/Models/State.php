<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'states';

    public function warehouses(){
        return $this->hasMany('App\Models\Warehouse' , 'state','id');
    } 

    public function substores(){
        return  $this->hasMany('App\Models\SubStore' , 'state','id');
    } 

    public function lubebays(){
        return  $this->hasMany('App\Models\Lubebay' , 'state','id');
    } 

    public function  totalDirectSales($start_time= null, $end_time = null){
        $state_total_direct_sales = 0 ;
        foreach ($this->warehouses as $warehouse) {
            $state_total_direct_sales += $warehouse->directTotalSales($start_time, $end_time);
        }
        return $state_total_direct_sales;
    }

    public function  totalRetailSales($start_time, $end_time){
        $state_total_retail_sales = 0 ;
        foreach ($this->sustores as $substore) {
            $state_total_retail_sales += $substore->total_sales($start_time, $end_time);
        }
        return $state_total_retail_sales;
    }

    public function  totalLubebayServiceSales($start_time, $end_time){
        $state_total_lubebay_service_sales = 0 ;
        foreach ($this->lubebays as $lubebay) {
            $state_total_lubebay_service_sales += $lubebay->total_sales($start_time, $end_time);
        }
        return $state_total_lubebay_service_sales;
    }

    public function  totalLubebayServicelogement($start_time, $end_time){
        $state_total_lubebay_service_lodgements = 0 ;
        foreach ($this->lubebays as $lubebay) {
            $state_total_lubebay_service_lodgements += $lubebay->total_lodgements($start_time, $end_time);
        }
        return $state_total_lubebay_service_lodgements;
    }
    
    //
}
