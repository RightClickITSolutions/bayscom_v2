<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Warehouse;
use App\Models\Substore;
use App\Models\Lubebay;

//TODO
//use App\Models\State;
//use App\Models\Location;

class User extends Authenticatable
{   
    use SoftDeletes;
    //spatie
    use HasRoles;
    
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function allowedWarehouses(){
        //debug hasOne method
        //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
        $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
        //dubug 
        //die($accessible_entities);
        if($this->hasPermissionTo('access_all_entities')){
            return Warehouse::all();
        }
        elseif($accessible_entities!=null){

            return Warehouse::find( json_decode($accessible_entities->warehouses) );

        }
        else{
            return null;
        }
        
        
    }
    public function canAccessWarehouse($warehouse_id){
        //debug hasOne method
        //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
        $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
        //dubug 
        //die($accessible_entities);
        if($this->hasPermissionTo('access_all_entities')){
            return true;
        }
        elseif($accessible_entities!=null){

            if (in_array($warehouse_id,json_decode($accessible_entities->warehouses))) {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }    
        
    }
    public function allowedsubstores(){
        
        //debug hasOne method
            //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
            $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
            //dubug 
            //die($accessible_entities);
            if($this->hasPermissionTo('access_all_entities')){
                return Substore::all();
            }
            elseif($accessible_entities!=null | $accessible_entities!=""){
    
                return Substore::find( json_decode($accessible_entities->substores) );
    
            }
            else{
                return null;
            }            
    }

    public function canAccessSubstore($substore_id){
        //debug hasOne method
        //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
        $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
        //dubug 
        //die($accessible_entities);
        if($this->hasPermissionTo('access_all_entities')){
            return true;
        }
        elseif($accessible_entities!=null){

            if (in_array($substore_id,json_decode($accessible_entities->substores))) {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }    
        
    }

    public function allowedlubebays(){
        //debug hasOne method
            //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
            $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
            //dubug 
            //die($accessible_entities);
            if($this->hasPermissionTo('access_all_entities')){
                return Lubebay::all();
            }
            elseif($accessible_entities!=null | $accessible_entities!=""){
    
                return Lubebay::find( json_decode($accessible_entities->lubebays) );
    
            }
            else{
                return null;
            }
    }

    public function canAccessLubebay($lubebay_id){
        //debug hasOne method
        //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
        $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
        //dubug 
        //die($accessible_entities);
        if($this->hasPermissionTo('access_all_entities')){
            return true;
        }
        elseif($accessible_entities!=null){

            if (in_array($lubebay_id,json_decode($accessible_entities->lubebays))) {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }    
        
    }
    public function allowedStates(){
        //debug hasOne method
            //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
            $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
            //dubug 
            //die($accessible_entities);
            if($this->hasPermissionTo('access_all_entities')){
                return Lubebay::all();
            }
            elseif($accessible_entities!=null | $accessible_entities!=""){
    
                return Lubebay::find( json_decode($accessible_entities->states) );
    
            }
            else{
                return null;
            }
    }

    public function canAccessState($state_id){
        //debug hasOne method
        //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
        $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
        //dubug 
        //die($accessible_entities);
        if($this->hasPermissionTo('access_all_entities')){
            return true;
        }
        elseif($accessible_entities!=null){

            if (in_array($state_id,json_decode($accessible_entities->states))) {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }    
        
    }
    public function allowedCustomers(){

        //debug hasOne method
            //$accessible_entities = $this->hasOne('App\Models\AccessibleEntities','user_id','id');
            $accessible_entities = Models\AccessibleEntities::where('user_id',$this->id)->first();
            //dubug 
            //die($accessible_entities);
            if($this->hasPermissionTo('access_all_entities')){
                return Customer::all();
            }
            elseif($accessible_entities!=null | $accessible_entities!=""){
    
                return Customer::find( json_decode($accessible_entities->customers) );
    
            }
            else{
                return null;
            }

        
    }

    public function accessibleEntities(){
        return  Models\AccessibleEntities::where('user_id',$this->id)->first();
        
    }
}
