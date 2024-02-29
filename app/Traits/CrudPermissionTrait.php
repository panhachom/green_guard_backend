<?php
namespace App\Traits;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * CrudPermissionTrait: use Permissions to configure Backpack
 */
trait CrudPermissionTrait
{
    // the operations defined for CRUD controller
    public array $operations = ['list', 'show', 'create', 'update', 'delete'];


    /**
     * set CRUD access using spatie Permissions defined for logged in user
     *
     * @return void
     */
    public function setAccessUsingPermissions()
    {

        // default
       $this->crud->denyAccess($this->operations);

        // get context
        $table = CRUD::getModel()->getTable();

        $user = request()->user();

        // dd($user->checkPermissionTo("cases.list"));

        // double check if no authenticated user
        if (!$user) {
            return; // allow nothing
        }

        // enable operations depending on permission
        foreach ([
            // permission level => [crud operations]
            'list' => ['list'], // e.g. permission 'users.see' allows to display users
            'show' => ['show'],
            'update' => ['update'],
            'create' => ['create'],
            'delete' => ['delete']
        ] as $level => $operations) {

            if ($user->can("$table.$level")) {
                $this->crud->allowAccess($operations);
            }
        }
    }
}