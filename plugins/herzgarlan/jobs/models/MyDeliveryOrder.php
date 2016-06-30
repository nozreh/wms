<?php namespace HerzGarlan\Jobs\Models;

use Model;
use Validator;
use ValidationException;
use October\Rain\Exception\ApplicationException;
use Input;
use Db;
use Flash;
use BackendAuth;
use HerzGarlan\Inventory\Models\Product;
use HerzGarlan\Config\Models\Rate;
use HerzGarlan\Config\Models\Timeslot;
use Rainlab\User\Models\User as UserModel;
use HerzGarlan\Jobs\Classes\JobsHelper;
use Carbon\Carbon;
use Mail;


/**
 * Model
 */
class MyDeliveryOrder extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
        'order_date' => 'required|after:now',
        'addr_from' => 'required',
        'postal_from' => 'required|digits:6|numeric',
        'addr_to' => 'required',
        'postal_to' => 'required|digits:6|numeric',
        'cartons' => 'numeric',
        'timeslot' => 'required'
    ];

    public $customMessages = [
       'order_date.required' => 'The Delivery Date field is required.',
       'order_date.after' => 'The Delivery Date must be a future date.',
       'timeslot.required' => 'The Timeslot field is required.',
       'addr_from.required' => 'The From Address field is required.',
       'addr_to.required' => 'The Destination Address field is required.',
       'postal_from.required' => 'The From Address postal code field is required.',
       'postal_to.required' => 'The Destination Address postal code field is required.',
       'postal_from.numeric' => 'The From Address Postal code must contain numbers only.',
       'postal_to.numeric' => 'The From Address Postal code must contain numbers only.',
       'postal_from.digits' => 'Invalid format for From Address Postal code.',
       'postal_to.digits' => 'Invalid format for Destination Address Postal code.',
       'cartons.numeric' => 'The No. of cartons must contain numbers only.',
    ];

    public $fillable = [
        'user',
        'user_id',
        'product',
        'product_id',
        'dimension',
        'weight',
    ];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = true;

    protected $dates = ['order_date'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'herzgarlan_jobs_delivery_order';

    public $belongsTo = [
        'product'  => ['HerzGarlan\Inventory\Models\Product'],
        'backend_user' => ['October\Rain\Auth\Models\User']
    ];

    public $belongsToMany = [
        'rates'       => ['HerzGarlan\Config\Models\Rate', 'table' => 'herzgarlan_jobs_delivery_order_rates', 'foreignKey' => 'rate_id', 'key' => 'delivery_order_id' , 'delete' => true],
        'rates_count' => ['HerzGarlan\Config\Models\Rate', 'table' => 'herzgarlan_jobs_delivery_order_rates', 'count' => true]
    ];

    public $hasMany = [
        'deliveryorderlog' => ['HerzGarlan\Jobs\Models\DeliveryOrderLog', 'foreignKey' => 'delivery_order_id', 'delete' => true]
    ];

    public $attachMany = [
        'photos' => ['System\Models\File', 'delete' => true]
    ];

    public function getProductOptions()
    {
        $backend_user = BackendAuth::getUser();
        $user = UserModel::where('backend_user_id', $backend_user->id)->first();
        return Product::getNameList($user->id);
    }

    public function getTimeslotOptions()
    {
        if( empty($this->order_date) ){
            return ['1' => 'Please select Delivery Date first'];
        }
        $date = $this->order_date;
        $timeslots = JobsHelper::getAvailableTimeslots($date);
        $slots = [];
        if(empty($timeslots) AND !empty($this->order_date)) // selected date has no defined timeslot
        {
            Flash::error('No timeslot available on selected date, Please select another Delivery Date.');
            return ['0' => 'Please select another Delivery Date.'];
        }
        foreach ($timeslots->timeslot as $key => $slot) 
        {
            $_timeslot = $slot['time_from'].'-'.$slot['time_to'];
            $capacityTaken = JobsHelper::getCapacityByTimeslot($this->order_date, $_timeslot);
            
            if( count($capacityTaken) >= $slot['capacity'] ) continue; // skip timeslot if it's 0

            $capacity = $slot['capacity'] - count($capacityTaken);
            $slots[ $_timeslot ] = $slot['time_from'].' - '.$slot['time_to'].' = Available Capacity - '.$capacity;
        }

        if( count($slots) > 0 ) 
        {
            return $slots;
        }
        else
        {
            Flash::error('No timeslot left on selected date, Please select another Delivery Date.');
            return ['0' => 'Please select another Delivery Date.'];
        }
    }

    public function filterFields($fields, $context = null)
    {
        if($fields->timeslot->value === 0){
            throw new ValidationException(['order_date' => $fields->timeslot->value]);
        }

        // No selected product
        if (empty($this->product_id)) {
            $fields->product_info->hidden = false;
            $fields->dimension->value = empty($this->product_info) ? '' : $this->dimension;
            $fields->weight->value = empty($this->product_info) ? '' : $this->weight;
        }
        else
        {
            $do = DeliveryOrder::where('id',$this->id)->get();
            $product = Product::where('id', $this->product_id)->get();
            //$fields->product_info->hidden = true;

            // if product is not changed
            if( count($do) > 0 )
            {
                if($do[0]['product_id'] == $this->product_id){
                    $fields->dimension->value = $do[0]['dimension'];
                    $fields->weight->value = $do[0]['weight'];
                    $fields->tracking_no->value = $do[0]['tracking_no'];
                }
                else
                {
                    $fields->dimension->value = $product[0]['dimension'];
                    $fields->weight->value = $product[0]['weight'];
                }
            }
            else
            {   
                $fields->dimension->value = $product[0]['dimension'];
                $fields->weight->value = $product[0]['weight'];
            }
       }
    
    }

    /**
     * @Events.
     */

    public function afterValidate()
    {
        $inputs = Input::get('MyDeliveryOrder');
        $rates = is_array( $inputs['rates'] ) ? true : false;

        if(!$rates){
            throw new ValidationException(['rates' => 'Type of Service is required']);
        }

        if(!empty($inputs['order_date']))
        {
            // check the selected date against Blocked Dates config
            $isBlockedDate = JobsHelper::isBlockedDate($this->order_date);
            if($isBlockedDate){
                throw new ValidationException(['order_date' => 'The selected delivery date and time is blocked please select another date.']);
            }
        }

        if(!empty($inputs['addr_from'] && $inputs['addr_to']))
        {
            // Make sure Product or Product info is not both empty
            if( empty($this->product_id) AND empty($inputs['product_info']) )
            {
                throw new ValidationException(['product_info' => 'Please select a Product or fill up the Product Info field.']);
            }
        }

        $sessionKey = uniqid('session_key', true);
        $deliveryOrder = DeliveryOrder::find(1);

        $fileFromPost = Input::file('photos');
        if ($fileFromPost) {
            $model->rules = [
                'photos'  => 'mimes:jpeg,bmp,png,gif'
            ];
            $deliveryOrder->photos()->create(['data' => $fileFromPost], $sessionKey);
        }

    }

    public function beforeCreate()
    {
        $backend_user = BackendAuth::getUser();
        $user = UserModel::where('backend_user_id', $backend_user->id)->first();
        $this->backend_user_id = $backend_user->id;
        $this->user_id = $user->id;
        $this->status = 'Pending';
        $this->tracking_no = strtoupper( str_random(12) );
    }

    public function beforeDelete()
    {
        Db::table('herzgarlan_jobs_delivery_order_rates')->where('delivery_order_id', '=', $this->id)->delete();
    }

    public function afterDelete()
    {
        if( !empty($this->photos) ){
            foreach ($this->photos as $photo) {
                $photo->delete();
            }
        }
    }


    public function afterCreate()
    {
        Flash::success('Delivery order has been created successfully and an Email has been sent to the customer.');
        $backend_user = BackendAuth::getUser();
        $user = UserModel::where('backend_user_id', $backend_user->id)->first();
        $product = empty( $this->product_id ) ? $this->product_info : Product::find($this->product_id);
        $product_info = empty( $this->product_id ) ? $this->product_info : $product->name;
        $contactEmail = $user->email;
        $contactName = $user->name;
        // These variables are available inside the message as Twig
        $vars = ['email' => $user->email, 
                'name' => $user->name, 
                'product' => $product_info, 
                'tracking_no' => $this->tracking_no,
                'delivery_date' => $this->order_date,
                'created_date' => $this->created_at,
                'backend_user' => $backend_user->name,
                'status' => 'Pending Delivery'];

        Mail::send('herzgarlan.jobs::mail.new_delivery_order', $vars, function($message) use ($contactEmail, $contactEmail) {

            $message->to($contactEmail, $contactEmail);
        
        });
    }

    public function afterSave()
    {
        Flash::success('Delivery order has been updated successfully and an Email has been sent to the customer.');

        $backend_user = BackendAuth::getUser();
        $user = UserModel::where('backend_user_id', $backend_user->id)->first();
        $product = empty( $this->product_id ) ? $this->product_info : Product::find($this->product_id);
        $product_info = empty( $this->product_id ) ? $this->product_info : $product->name;
        $contactEmail = $user->email;
        $contactName = $user->name;
        // These variables are available inside the message as Twig
        $vars = ['email' => $user->email, 
                'name' => $user->name, 
                'product' => $product_info, 
                'tracking_no' => $this->tracking_no,
                'backend_user' => $backend_user->name,
                'delivery_date' => $this->order_date,
                'updated_date' => $this->updated_at,
                'status' => 'Pending Delivery'];

        Mail::send('herzgarlan.jobs::mail.update_delivery_order', $vars, function($message) use ($contactEmail, $contactEmail) {

            $message->to($contactEmail, $contactEmail);
        
        });
    }

}