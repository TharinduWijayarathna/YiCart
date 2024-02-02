<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\PosCustomer\CreatePosCustomerRequest;
use App\Http\Resources\DataResource;
use App\Models\Customer;
use domain\Facades\PosCustomerFacade\PosCustomerFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PosCustomerController extends ParentController
{
    public function index()
    {
        return Inertia::render('Customer/index');
    }

    public function store(CreatePosCustomerRequest $req)
    {
        // if (Auth::user()->can('access_customer_management')) {
        //     return PosCustomerFacade::store($req->all());
        // } else {
        //     $response['alert-danger'] = 'You do not have permission to create customers.';
        //     return redirect()->route('customer.index')->with($response);
        // }
        // $user = PosCustomerFacade::getTenantId();
        // dd($req);
        return PosCustomerFacade::store($req->all());
    }

    public function allStore(CreateCustomerRequest $req)
    {
        return PosCustomerFacade::allStore($req->all());
    }

    public function getByNumber(int $contact)
    {
        return PosCustomerFacade::getByNumber($contact);
    }

    public function all(Request $request)
    {
        $query = Customer::orderBy('id', 'desc');
        if (isset($request->search_customer_name)) {
            $query->where('name', 'like', "%{$request->search_customer_name}%");
        }
        if (isset($request->search_customer_contact)) {
            $searchContact = $request->search_customer_contact;
            $query->where(function ($query) use ($searchContact) {
                $query->where('contact', 'like', '%' . $searchContact . '%');
                $query->orWhere('contact2', 'like', '%' . $searchContact . '%');
                $query->orWhere('contact3', 'like', '%' . $searchContact . '%');
            });
        }
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['code'])
            ->allowedFilters(
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->Where('name', 'like', "%{$value}%");
                })
            )
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function get($student_id)
    {
        return PosCustomerFacade::get($student_id);
    }

    public function update(CreateCustomerRequest $req, $customer_id) {
        return PosCustomerFacade::update($req->all(), $customer_id);
    }

    public function delete($customer_id){
        return PosCustomerFacade::delete($customer_id);
    }

}
