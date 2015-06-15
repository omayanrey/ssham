<?php

namespace SSHAM\Http\Controllers;

use SSHAM\Http\Controllers\Controller;
use SSHAM\Http\Requests\UserRequest;
use SSHAM\User;
use yajra\Datatables\Datatables;

class UserController extends Controller
{
    
    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Create a new controller instance.
     * 
     * Inject the models.
     * @param User       $user
     * 
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Title
        $title = \Lang::get('user/title.user_management');

        // The list of users will be filled later using the JSON Data method
        // below - to populate the DataTables table.
        return view('user/index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Title
        $title = \Lang::get('user/title.create_a_new_user');

        return view('user.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $this->user = User::create($request->all());
        
        if ($this->user->id) {
            return redirect()->route('users.index')
                ->with('success', \Lang::get('user/messages.create.success'));
        } else {
            // Get validation errors (see Ardent package)
            $error = $this->user->errors()->all();

            return redirect()->route('users.create')
                ->withInput()
                ->with('error', $error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(User $user)
    {
        // Title
        $title = \Lang::get('user/title.user_show');

        return view('user.show', compact('user', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(User $user)
    {
        // Title
        $title = \Lang::get('user/title.user_update');

        return view('user.edit', compact('user', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->save();
        
        return redirect()->route('user.edit', [$user->id]);
    }

    /**
     * Remove user.
     *
     * @param $user
     * @return Response
     */
    public function delete(User $user)
    {
        // $roles = $this->role->all();
        // $permissions = $this->permission->all();
        // Title
        $title = Lang::get('user/title.user_delete');

        return view('user/delete', compact('user', 'title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function data(Datatables $datatable)
    {
        $users = User::select(array(
                'id', 'name', 'type', 'fingerprint', 'active'
        ));

        return $datatable->usingEloquent($users)
                ->editColumn('active', function($model) {
                    return ($model->active) ? '<span class="label label-sm label-success">Activo</span>' : '<span class="label label-sm label-danger">Inactivo</span>';
                })
                ->addColumn('actions', function($model) {
                    return view('partials.actions_dd', array(
                            'model' => 'users',
                            'id' => $model->id
                        ))->render();
                })
                ->removeColumn('id')
                ->make(true);
    }
}
