<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/*
 * Customer
 * php version 8
 *
 * @category Model
 
 * */

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'website',
        'contact',
        'contact2',
        'contact3',
        'email',
        'email2',
        'email3',
        'credit_term',
        'status',
        'company',
        'customer_outstanding',
        'account_no',
        'bank_name',
        'branch_name',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'total_outstanding',
        'formatted_outstanding',
    ];

    public function getByNumber(int $contact)
    {
        return $this->where('contact', $contact)->orWhere('contact2', $contact)->orWhere('contact3', $contact)->first();
    }

    public function contacts()
    {
        return $this->hasMany(CustomerContact::class, 'customer_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(CustomerPayment::class, 'customer_id', 'id');
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class, 'customer_id', 'id');
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class, 'customer_id', 'id');
    }

    public function getTotalOutstandingAttribute()
    {
        $invoice = $this->invoice->where('pay_status', '!=', 3)->sum('due_amount');
        if ($invoice < 0) {
            $invoice = 0;
        }
        return number_format((float)$invoice, 2, '.', '');
    }

    public function search($query)
    {
        // $payload = $this->where('tenant_id', Auth::user()->tenant_id);
        $payload = $this->where(function ($payload) use ($query) {
            $payload = $payload->where('name', 'like', '%' . $query . '%')
                ->orWhere('email', 'like', '%' . $query . '%')
                ->orWhere('contact', 'like', '%' . $query . '%')
                ->orWhere('website', 'like', '%' . $query . '%')
                ->orWhere('address', 'like', '%' . $query . '%')
                ->orWhere('company', 'like', '%' . $query . '%');
        });
        // $payload = $payload->where(function ($payload) use ($query) {
        //     $payload = $payload->where('name', 'like', '%' . $query . '%')
        //         ->orWhere('email', 'like', '%' . $query . '%')
        //         ->orWhere('contact', 'like', '%' . $query . '%')
        //         ->orWhere('website', 'like', '%' . $query . '%')
        //         ->orWhere('address', 'like', '%' . $query . '%')
        //         ->orWhere('company', 'like', '%' . $query . '%');
        // });

        return $payload->limit(10)->get();
    }

    public function getFormattedOutstandingAttribute()
    {
        return number_format($this->customer_outstanding, 2);
    }
}
