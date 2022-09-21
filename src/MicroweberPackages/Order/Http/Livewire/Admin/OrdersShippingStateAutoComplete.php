<?php

namespace MicroweberPackages\Order\Http\Livewire\Admin;

class OrdersShippingStateAutoComplete extends OrdersShippingCountryAutoComplete
{
    public $selectedItemKey = 'shipping.state';
    public string $placeholder = 'Type to search by state...';
    public $modelGroupByField = 'state';
}