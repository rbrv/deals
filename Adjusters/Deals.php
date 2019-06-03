<?php

namespace Commerce\Adjusters;
use Craft\Commerce_LineItemModel;
use Craft\Commerce_OrderAdjustmentModel;
use Craft\Commerce_OrderModel;
use Commerce\Helpers\CommerceCurrencyHelper;

class Deals implements Commerce_AdjusterInterface {

    public function adjust(Commerce_OrderModel &$order, array $lineItems = []){

        $adjusters = [];
        
        foreach ($lineItems as $item) {
	        
	        $deal = $this->getLineItemDeal($item);
	        $product = $item->purchasable->product;
	        
	        if($deal){
		        
		        $amount = $deal['amount'];
		        $qty = $item->qty;
		        
		        if($qty >= $amount){
		        	
		        	$timesToApply = floor($qty / $amount);
		        	
			        $dealAdjuster = new Commerce_OrderAdjustmentModel();
			        
			        $dealAdjuster->amount = 0;
			        $dealAdjuster->orderId = $order->id;
			        $dealAdjuster->type = "Product Deal";
			        $dealAdjuster->name = $product->title;
			        $dealAdjuster->description = $deal['description'];
			        
			        if($deal['qtyDiscount'] > 0){
				        // qty discount
						$discount = -(CommerceCurrencyHelper::round($timesToApply * ($deal['qtyDiscount'] * $item->price)));
			        }elseif($deal['amountDiscount'] > 0){
				        // amount discount
						$discount = -(CommerceCurrencyHelper::round($timesToApply * ($deal['amountDiscount'])));
			        }elseif($deal['percentageDiscount'] > 0){
				        // percent discount
				        $percent = $deal['percentageDiscount'] / 100;
						$discount = -(CommerceCurrencyHelper::round(($percent * ($timesToApply * ($item->price * $amount)))));
			        }
			        
	                $item->discount = $discount;
	                $dealAdjuster->amount += $discount;
	                
			        $dealAdjuster->optionsJson = ['lineItemsAffected'=>[$item->id]];
			        $dealAdjuster->included = true;
			        
			        $adjusters[] = $dealAdjuster;
		        
		        }
		        
	        }
	        
        }
		
        return $adjusters;

    }

    private function getLineItemDeal($lineItem){
	    
	   	// get product, check for deal field and if it's enabled
	   	$product = $lineItem->purchasable->product;
	   	$content = $product->content;
	   	foreach($content as $field){
		   	if(is_array($field) && array_key_exists('dealFieldType', $field)){
			   	if($field['enabled']){
		   			return $field;
		   		}
		   	}
	   	}
	   	
	   	// or return null
	   	return null;
	   	
	}

}