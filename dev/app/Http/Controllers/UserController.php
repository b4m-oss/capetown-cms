<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $users = $this->userRepository->index();
        return $users;
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \App\Models\User
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->store($request);
        return $user;
    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \App\Models\User
     */
    public function show($id)
    {
        $user = $this->userRepository->show($id);
        return $user;
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  int  $id
     * @return \App\Models\User
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userRepository->update($request, $id);
        return $user;
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        $result = $this->userRepository->destroy($id);
        return $result;
    }

    /**
     * Paginate the users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(Request $request)
    {
        $perPage = $request->query('per_page');
        $maxResults = $request->query('max_results');
        $users = $this->userRepository->paginate($perPage, $maxResults);
        return $users;
    }

    /**
     * Search for users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(Request $request)
    {
        $keyword = $request->query('keyword');
        $columns = $request->query('columns', ['*']);
        $results = $this->userRepository->search($keyword, $columns);
        return $results;
    }

    /**
     * Bulk delete users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        $result = $this->userRepository->bulkDelete($ids);
        return $result;
    }

    /**
     * Bulk update users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function bulkUpdate(Request $request)
    {
        $updates = $request->input('updates', []);
        $result = $this->userRepository->bulkUpdate($updates);
        return $result;
    }
}
