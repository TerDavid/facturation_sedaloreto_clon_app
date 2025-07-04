<?php

namespace App\CoreFacturalo\Requests\Web\Validation;

use App\CoreFacturalo\Requests\Inputs\QuotationInput;
use App\Models\Tenant\ItemWarehouseVariationStock;
use Modules\Inventory\Models\InventoryConfiguration;
use stdClass;

class DocumentValidation
{
    public static function validation($inputs) {
        $series = Functions::findSeries($inputs);
        $inputs['series'] = $series->number;
        unset($inputs['series_id']);

        Functions::DNI($inputs);
        self::validate_item_variation_stocks($inputs);

        return $inputs;
    }

    public static function validate_item_variation_stocks($inputs){

        if( !in_array( $inputs['document_type_id'] , ['01', '03']) )return true;
        // $inventory_configuration = InventoryConfiguration::firstOrFail();
        $inventory_configuration = new stdClass();
        $inventory_configuration->stock_control = 0;

        if(!$inventory_configuration->stock_control)return true;

        //if( isset($inputs['quotation_id']) ){
            // foreach ($inputs['items'] as $row) {
            //     $variations =  $row['variation_stock'] ?? $row['variations'] ?? [];
            //     foreach ($variations as $variation) {
            //         //$variation_stock_id = isset($row['id']) ? $variation['variation_stock_id'] : $variation['id'];
            //         $variation_stock_id = $variation['variation_stock_id'] ?? $variation['id'] ?? null;

            //         $quantity = $variation['quantity'];

            //         $variation_stock = ItemWarehouseVariationStock::find($variation_stock_id);
            //         // $variation_stock = null;
            //         if( $quantity > $variation_stock->stock ){
            //             $item_description = $row['item']['description'];
            //             //no deberia de aparecer la canitdad de variaciones elegidas
            //             $description = QuotationInput::generateItemDescriptionFromVariations($row,'',['hide_quantity'=>true]);
            //             throw new \Exception("{$item_description} con variaiones{$description}. No tiene suficiente stock!");
            //         }
            //     }
            // }
        //}


    }

}
