<?php
/**
 * Deals plugin for Craft CMS
 *
 * Deals Model
 *
 * @author    Stephen Hamilton
 * @copyright Copyright (c) 2016 Stephen Hamilton
 * @link      http://www.shtc.co.uk
 * @package   Deals
 * @since     1.0.0
 */

namespace Craft;

class DealsModel extends BaseModel
{
    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), array(
            'enabled'     			=> array(AttributeType::Bool, 'default' => 0),
            'amount'    			=> array(AttributeType::Number, 'default' => 2),
            'qtyDiscount'     		=> array(AttributeType::Number, 'default' => 1),
            'amountDiscount'     	=> array(AttributeType::Number, 'decimals' => 2, 'default' => '0.00'),
            'percentageDiscount'    => array(AttributeType::Number, 'default' => 0),
            'description'     		=> array(AttributeType::String, 'default' => 'Buy one get one free'),
        ));
    }

}