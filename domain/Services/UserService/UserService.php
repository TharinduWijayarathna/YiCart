<?php

namespace domain\Services\UserService;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    protected $users;
    protected $customer;

    public function __construct()
    {
        $this->users = new User();
        $this->customer = new Customer();
    }


    /**
     * Get
     * retrieve relevant data using user_id
     *
     * @param  int  $user_id
     * @return void
     */
    public function get(int $user_id)
    {
        return $this->users->find($user_id);
    }

    public function getWithTrashed(int $user_id)
    {
        return $this->users->withTrashed()->find($user_id);
    }

    public function getByEmail(string $email)
    {
        return $this->users->getByEmail($email);
    }

    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        return $this->users->all();
    }

    /**
     * find
     *
     * @param  int $user_id
     * @return void
     */
    public function find(int $user_id)
    {
        return $this->users->find($user_id);
    }

    /**
     * Update
     * update existing data using user_id
     *
     * @param  array $data
     * @param  int   $user_id
     * @return void
     */
    public function update($data, $user_id)
    {
        $admin_count = $this->users->where('user_role_id', '1')->count();

        $user = $this->users->where('id', $user_id)->first();
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if ($admin_count == 1){
            $admin = $this->users->where('id', $user_id)->first();
            if ($admin){
                $data['user_role_id'] = 1;
            }
        }

        return $user->update($this->edit($user, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  selyn $user
     * @param  array    $data
     * @return void
     */
    protected function edit(User $user, array $data)
    {
        return array_merge($user->toArray(), $data);
    }

    /**
     * make
     *
     * @param  array $data
     * @return void
     */
    public function store(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_role_id' => $data['user_role_id'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }


    /**
     * update Password
     *
     * @param  array $data
     * @return void
     */
    public function updatePassword(array $data, int $user_id)
    {
        $user = $this->users->withTrashed()->find($user_id);
        // $user = $this->users->find($user_id);
        $user->password = bcrypt($data['password']);
        return $user->update();
    }

    /**
     * delete
     *
     * @param  int $user_id
     * @return void
     */
    public function delete(int $user_id)
    {
        $users = $this->users->find($user_id);
        $users->delete();
    }

    /**
     * restore
     *
     * @param  int $user_id
     * @return void
     */
    public function restore(int $user_id)
    {
        $users = $this->users->withTrashed()->find($user_id);
        $users->restore();
    }
}
