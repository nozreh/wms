<?php namespace HerzGarlan\Jobs\Components;

use Auth;
use Cms\Classes\ComponentBase;
use HerzGarlan\Jobs\Models\DeliveryOrder as DeliveryOrder;
use Lang;

class ViewDeliveryOrders extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'View Deliver Order Component',
            'description' => 'Corporate customers view details of their delivery orders'
        ];
    }

    public function deliveryorders()
    {
        $user = $this->user();
        $deliveryorders = DeliveryOrder::where('user_id', '=', $user->id)->paginate(15);
        
        return $deliveryorders;
    }

    public function defineProperties()
    {
        return [];
    }

    /**
     * Returns the logged in user, if available
     */
    public function user()
    {
        if (!Auth::check())
            return null;

        return Auth::getUser();
    }

}