<?php
namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckoutAccessoryNotification;

/**
 * Model for Accessories.
 *
 * @version    v1.0
 */
class Accessory extends SnipeModel
{
    protected $presenter = 'App\Presenters\AccessoryPresenter';
    use CompanyableTrait;
    use Loggable, Presentable;
    use SoftDeletes;

    protected $dates = ['deleted_at', 'purchase_date'];
    protected $table = 'accessories';
    protected $casts = [
        'requestable' => 'boolean'
    ];

    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableAttributes = ['name', 'model_number', 'order_number', 'purchase_date'];

    /**
     * The relations and their attributes that should be included when searching the model.
     * 
     * @var array
     */
    protected $searchableRelations = [
        'category'     => ['name'],
        'company'      => ['name'],
        'manufacturer' => ['name'],
        'supplier'     => ['name'],
        'location'     => ['name']
    ];
   
    /**
     * Set static properties to determine which checkout/checkin handlers we should use
     */
    public static $checkoutClass = CheckoutAccessoryNotification::class;
    public static $checkinClass = CheckinAccessoryNotification::class;


    /**
    * Accessory validation rules
    */
    public $rules = array(
        'name'              => 'required|min:3|max:255',
        'qty'               => 'required|integer|min:1',
        'category_id'       => 'required|integer|exists:categories,id',
        'company_id'        => 'integer|nullable',
        'min_amt'           => 'integer|min:0|nullable',
        'purchase_cost'     => 'numeric|nullable',
    );


    /**
    * Whether the model should inject it's identifier to the unique
    * validation rules before attempting validation. If this property
    * is not set in the model it will default to true.
    *
    * @var boolean
    */
    protected $injectUniqueIdentifier = true;
    use ValidatingTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'company_id',
        'location_id',
        'name',
        'order_number',
        'purchase_cost',
        'purchase_date',
        'model_number',
        'manufacturer_id',
        'supplier_id',
        'image',
        'qty',
        'requestable'
    ];




    public function supplier()
    {
        return $this->belongsTo('\App\Models\Supplier', 'supplier_id');
    }
    

    public function setRequestableAttribute($value)
    {
        if ($value == '') {
            $value = null;
        }
        $this->attributes['requestable'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
        return;
    }

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id');
    }

    public function location()
    {
        return $this->belongsTo('\App\Models\Location', 'location_id');
    }

    public function category()
    {
        return $this->belongsTo('\App\Models\Category', 'category_id')->where('category_type', '=', 'accessory');
    }

    /**
    * Get action logs for this accessory
    */
    public function assetlog()
    {
        return $this->hasMany('\App\Models\Actionlog', 'item_id')->where('item_type', Accessory::class)->orderBy('created_at', 'desc')->withTrashed();
    }

    public function getImageUrl() {
        if ($this->image) {
            return url('/').'/uploads/accessories/'.$this->image;
        }
        return false;

    }

    public function users()
    {
        return $this->belongsToMany('\App\Models\User', 'accessories_users', 'accessory_id', 'assigned_to')->withPivot('id')->withTrashed();
    }

    public function hasUsers()
    {
        return $this->belongsToMany('\App\Models\User', 'accessories_users', 'accessory_id', 'assigned_to')->count();
    }

    public function manufacturer()
    {
        return $this->belongsTo('\App\Models\Manufacturer', 'manufacturer_id');
    }

    public function checkin_email()
    {
        return $this->category->checkin_email;
    }

    public function requireAcceptance()
    {
        return $this->category->require_acceptance;
    }

    public function getEula()
    {

        $Parsedown = new \Parsedown();

        if ($this->category->eula_text) {
            return $Parsedown->text(e($this->category->eula_text));
        } elseif ((Setting::getSettings()->default_eula_text) && ($this->category->use_default_eula=='1')) {
            return $Parsedown->text(e(Setting::getSettings()->default_eula_text));
        }
            return null;
    }

    public function numRemaining()
    {
        $checkedout = $this->users->count();
        $total = $this->qty;
        $remaining = $total - $checkedout;
        return $remaining;
    }

    /**
    * Query builder scope to order on company
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCompany($query, $order)
    {
        return $query->leftJoin('companies', 'accessories.company_id', '=', 'companies.id')
        ->orderBy('companies.name', $order);
    }

    /**
    * Query builder scope to order on category
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderCategory($query, $order)
    {
        return $query->leftJoin('categories', 'accessories.category_id', '=', 'categories.id')
        ->orderBy('categories.name', $order);
    }

    /**
    * Query builder scope to order on location
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderLocation($query, $order)
    {
        return $query->leftJoin('locations', 'accessories.location_id', '=', 'locations.id')
        ->orderBy('locations.name', $order);
    }

    /**
    * Query builder scope to order on manufacturer
    *
    * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
    * @param  text                              $order       Order
    *
    * @return \Illuminate\Database\Query\Builder          Modified query builder
    */
    public function scopeOrderManufacturer($query, $order)
    {
        return $query->leftJoin('manufacturers', 'accessories.manufacturer_id', '=', 'manufacturers.id')->orderBy('manufacturers.name', $order);
    }
}
