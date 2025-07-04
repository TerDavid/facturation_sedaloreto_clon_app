<?php

namespace App\Models;

use App\Models\Catalogs\AffectationIgvType;
use App\Models\Catalogs\CurrencyType;
use App\Models\Catalogs\SystemIscType;
use App\Models\Catalogs\UnitType;
use App\Models\AgrupacionInfoAdicionalItems;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $with = ['unit_type', 'currency_type'];
    protected $fillable = [
        'description',
        'item_type_id',
        'internal_id',
        'item_code',
        'item_code_gs1',
        'unit_type_id',
        'currency_type_id',
        'minimum_sale_unit_price',
        'sale_unit_price',
        'purchase_unit_price',
        'included_igv',
        'icbper',
        'has_isc',
        'system_isc_type_id',
        'percentage_isc',
        'suggested_price',
        'sale_affectation_igv_type_id',
        'purchase_affectation_igv_type_id',
        'stock',
        'stock_min',
        'trademark_id',
        'item_category_id',
        'attributes',
        'proyect_number_concar',
        'product_account_number_concar',
        'cost_center_code_concar',
        'amount_plastic_bag_taxes',
        'use_additional_information',
        'use_variations',
        'use_subitems'
    ];

    public function getAttributesAttribute($value)
    {
        return (is_null($value)) ? null : (object)json_decode($value);
    }

    public function setAttributesAttribute($value)
    {
        $this->attributes['attributes'] = (is_null($value)) ? null : json_encode($value);
    }

    public function item_type()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function trademark()
    {
        return $this->belongsTo(Trademarks::class);
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function unit_type()
    {
        return $this->belongsTo(UnitType::class, 'unit_type_id');
    }

    public function currency_type()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id');
    }

    public function system_isc_type()
    {
        return $this->belongsTo(SystemIscType::class, 'system_isc_type_id');
    }

    public function kardex()
    {
        return $this->hasMany(Kardex::class);
    }

    public function inventory_kardex()
    {
        return $this->hasMany(InventoryKardex::class);
    }

    public function purchase_item()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function item_warehouse()
    {
        return $this->hasMany(ItemWarehouse::class);
    }

    public function item_price_list()
    {
        return $this->hasMany(ItemPriceList::class);
    }

    public function sale_affectation_igv_type()
    {
        return $this->belongsTo(AffectationIgvType::class, 'sale_affectation_igv_type_id');
    }

    public function purchase_affectation_igv_type()
    {
        return $this->belongsTo(AffectationIgvType::class, 'purchase_affectation_igv_type_id');
    }

    public function warehouses()
    {
        return $this->hasMany(ItemWarehouse::class)->with('warehouse');
    }

    public function item_unit_types()
    {
        return $this->hasMany(ItemUnitType::class);
    }

    public function subitems()
    {
        return $this->hasMany(Subitem::class,'parent_id');
    }

}
