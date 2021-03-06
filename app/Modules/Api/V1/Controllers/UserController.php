<?php

namespace App\Modules\Api\V1\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Modules\Electrons\Users\UserService;
use App\Modules\Electrons\Users\RoleService;
use App\Modules\Electrons\Activities\EntryService;
use App\Modules\Electrons\Storage\StorageService;
use App\Modules\Electrons\Keys\KeyService;
use App\Modules\Electrons\Alerts\AlertService;
use App\Modules\Electrons\Edits\EditService;
use App\Modules\Electrons\Shared\Controllers\JsonApiController;
use App\Modules\Api\V1\Requests\Users\UserIndexRequest;
use App\Modules\Api\V1\Requests\Users\UserShowRequest;
use App\Modules\Api\V1\Requests\Users\UserCurrentRequest;
use App\Modules\Api\V1\Requests\Users\UserInsertRequest;
use App\Modules\Api\V1\Requests\Users\UserUpdateRequest;
use App\Modules\Api\V1\Requests\Users\UserDeleteRequest;
use App\Modules\Api\V1\Requests\Users\GrantKeysRequest;
use App\Modules\Api\V1\Requests\Users\SeeAlertRequest;
use App\Modules\Api\V1\Requests\Users\ChangePasswordRequest;
use App\Modules\Api\V1\Requests\Keys\KeyIndexRequest;
use App\Modules\Api\V1\Requests\Alerts\AlertIndexRequest;
use App\Modules\Api\V1\Requests\Entries\EntryModifyRequest;
use App\Modules\Api\V1\Requests\Edits\EditIndexRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonApiController;

    /**
     * A user service instance.
     *
     * @var UserService
     */
    protected $users;

    /**
     * Create a new controller instance.
     *
     * @param  UserService  $users
     * @return void
     */
    public function __construct(UserService $users)
    {
        $this->users = $users;
    }

    /**
     * Get an array of users data.
     *
     * @param  UserIndexRequest  $request
     * @return Response
     */
    public function index(UserIndexRequest $request)
    {
        return $this->respondJson(
            ['users' => $this->users->multiple($request->all())]
        );
    }

    /**
     * Get a user data.
     *
     * @param  UserShowRequest  $request
     * @param  User             $user
     * @return Response
     */
    public function show(UserShowRequest $request, User $user)
    {
        $this->users->loadRelationships($user);

        return $this->respondJson(['user' => $user]);   
    }

    /**
     * Get the current user data.
     *
     * @param  UserCurrentRequest  $request
     * @return Response
     */
    public function current(UserCurrentRequest $request)
    {
        $user = auth()->user();

        $this->users->loadRelationships($user);

        return $this->respondJson(['user' => $user]);   
    }

    /**
     * Insert a new user data.
     *
     * @param  UserInsertRequest  $request
     * @param  RoleService        $roles
     * @param  ProfileService     $profiles
     * @param  EntryService       $entries
     * @return Response
     */
    public function insert(UserInsertRequest $request, RoleService $roles, 
        EntryService $entries)
    {
        $user = $this->users->create($request->all());

        $roles->associate($user, $request->input('role'));

        if ($user->isEntrant()) {
            $entries->associate($user, $request->input('entry'));
        }

        return $this->respondJson(['user' => $user]);
    }

    /**
     * Update a user data.
     *
     * @param  UserUpdateRequest  $request
     * @param  User               $user
     * @param  RoleService        $roles
     * @param  ProfileService     $profiles
     * @return Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->users->update($user, $request->all());

        return $this->respondJson(['user' => $user]);
    }

    /**
     * Delete a user data.
     *
     * @param  UserDeleteRequest  $request
     * @param  User               $user
     * @param  StorageService     $storages
     * @return Response
     */
    public function remove(
        UserDeleteRequest $request, 
        User $user, 
        StorageService $storages)
    {
        $this->users->remove($user);

        $storages->destroy('images', $user->id, 'profile');

        return $this->respondJson(['user' => $user]);
    }

    /**
     * Get keys owned by the given user.
     *
     * @param  KeyIndexRequest  $request
     * @param  User             $user
     * @param  KeyService       $keys
     * @return Response
     */
    public function keys(KeyIndexRequest $request, User $user, KeyService $keys)
    {
        $queries = $request->all();

        $queries['users'] = $user->id;

        return $this->respondJson(
            ['keys' => $keys->getMultiple($queries)]
        );
    }

    /**
     * Modify keys ownership to the given user.
     *
     * @param  GrantKeysRequest  $request
     * @param  User              $user
     * @param  KeyService        $keys
     * @return Response
     */
    public function grantKeys(GrantKeysRequest $request, User $user, KeyService $keys)
    {
        $keys->grant($user, $request->input('grant', []))
             ->ungrant($user, $request->input('ungrant', []));

        return $this->respondJson(
            ['keys' => $keys->getMultiple(['users' => $user->id])]
        );
    }

    /**
     * Get alerts announced to the given user.
     *
     * @param  AlertIndexRequest  $request
     * @param  User               $user
     * @param  AlertService       $alerts
     * @return Response
     */
    public function alerts(AlertIndexRequest $request, User $user, AlertService $alerts)
    {
        $queries = $request->all();

        return $this->respondJson(
            ['alerts' => $alerts->getMultipleCustomQuery($user->alerts()->getQuery(), $queries)]
        );
    }

    /**
     * See or unsee alerts by the given user.
     *
     * @param  SeeAlertRequest  $request
     * @param  User             $user
     * @param  AlertService     $alerts
     * @return Response
     */
    public function seeAlerts(SeeAlertRequest $request, User $user, AlertService $alerts)
    {
        $alerts->see($user, $request->input('see', []))
             ->unsee($user, $request->input('unsee', []));

        return $this->respondJson(
            ['alerts' => $alerts->getMultiple(['users' => $user->id])]
        );
    }

    /**
     * Get edits performed by the given user.
     *
     * @param  EditIndexRequest   $request
     * @param  User               $user
     * @param  EditService        $edits
     * @return Response
     */
    public function edits(EditIndexRequest $request, User $user, EditService $edits)
    {
        $queries = $request->all();

        $queries['user'] = $user->id;

        return $this->respondJson(
            ['edits' => $edits->getMultiple($queries)]
        );
    }

    /**
     * Perform a change password action
     */
    public function changePassword(ChangePasswordRequest $request, User $user)
    {
        if (! Hash::check($request->input('password_old'), $user->password)) {
            return response()->json(['password_old' => 'Wrong old password'], 422);
        }

        $this->users->update($user, $request->all());

        return $this->respondJson(['user' => $user]);
    }
}
