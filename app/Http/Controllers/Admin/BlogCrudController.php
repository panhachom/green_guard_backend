<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\ImageFile;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class BlogCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BlogCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }


    protected $blogModel;

    /**
     * @return void
     */
    public function setup()
    {
        $this->blogModel = \App\Models\Blog::class;
        CRUD::setModel($this->blogModel);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/blog');
        CRUD::setEntityNameStrings('blog', 'blogs');
    }

    /**
     * @return void
     */
    protected function setupListOperation()
    {
        $currentUserId = Auth::id();
        CRUD::column('title');
        CRUD::column('sub_title');
        CRUD::column('status')->type('status');
        CRUD::column('category');
        CRUD::column('created_at');
        if(backpack_user()->hasRole('normal_user')){
            $this->crud->addClause('where', 'user_id', '=', $currentUserId);
        }
    }

    /**
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(BlogRequest::class);

        $this->crud->setCreateView('Blogs.create');
    }

    public function store()
    {
        $params = request()->all();
        if($params['id']){
            $blog = Blog::where('id', $params['id'])->first();
            $blog->title        = $params['title'];
            $blog->sub_title    = $params['sub_title'];
            $blog->category     = $params['category'];
            $blog->status       = 1;
            $blog->body         = $params['body'];

            if(backpack_user()->hasRole('normal_user')){
                $blog->status       = 0;
            }
            $blog->update();

            if(isset($params['images'])){
                $images =  $params['images'];
                foreach ($images as $image){

                    $imageName = $image->getClientOriginalName();
                    $imagePath = $image->store('images', 'public');
                    $imageUrl = Storage::disk('public')->url($imagePath);

                    ImageFile::create([
                        'parent_id' => $params['id'],
                        'parent_type' => $this->blogModel,
                        'file_name' => $imageName,
                        'file_path' => $imagePath,
                        'file_url' => $imageUrl,
                    ]);
                }
            }
            \Alert::success(trans('backpack::crud.update_success'))->flash();

        } else{
            $blog               = new Blog();
            $blog->user_id      = backpack_auth()->user()->id;
            $blog->title        = $params['title'];
            $blog->status       = 1;
            $blog->sub_title    = $params['sub_title'];
            $blog->category     = $params['category'];
            $blog->body         = $params['body'];

            if(backpack_user()->hasRole('normal_user')){
                $blog->status       = 0;
            }
            $blog->save();
            $images =  $params['images'];
            foreach ($images as $image){
                $imageName = $image->getClientOriginalName();
                $imagePath = $image->store('images', 'public');
                $imageUrl = Storage::disk('public')->url($imagePath);

                ImageFile::create([
                    'parent_id' => $blog->id,
                    'parent_type' => $this->blogModel,
                    'file_name' => $imageName,
                    'file_path' => $imagePath,
                    'file_url' => $imageUrl,
                ]);
            }
            \Alert::success(trans('backpack::crud.insert_success'))->flash();
        }

        // save the redirect choice for next time
        $this->crud->setSaveAction();
        return $this->crud->performSaveAction($blog->getKey());
    }

    public function setupShowOperation(){
        $this->crud->setShowView('Blogs.show');
    }

    /**
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->crud->setEditView('Blogs.create');
    }

    public function removeImage($id)
    {
        $image = ImageFile::find($id);
        if (!$image) {
            return response()->json(['error' => 'Image not found'], 404);
        }
        Storage::delete($image->file_path);

        $image->delete();

        return  redirect()->back()->with('success', 'created Successfully.');
    }

}