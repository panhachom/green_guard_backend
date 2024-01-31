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
        CRUD::column('title');
        CRUD::column('body');
        CRUD::column('solution');
        CRUD::column('created_at');
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
        // dd($params);

        if($params['id']){

            $blog = Blog::where('id', $params['id'])->first();
            $blog->title = $params['title'];
            $blog->body = $params['body'];
            $blog->solution = $params['solution'];
            $blog->update();

            if(isset($params['images'])){
                $image =  $params['images'];

                $imageName = $image->getClientOriginalName();
                $imagePath = $image->store('images', 'public');
                $imageUrl = Storage::disk('public')->url($imagePath);

                $image = ImageFile::where('parent_id', $params['id'])->where('parent_type',$this->blogModel)->first();
                $image->update([
                    'file_name' => $imageName,
                    'file_path' => $imagePath,
                    'file_url' => $imageUrl,
                ]);
            }

        } else{
            $blog           = new Blog();
            $blog->user_id  = backpack_auth()->user()->id;
            $blog->title    = $params['title'];
            $blog->body     = $params['body'];
            $blog->solution = $params['solution'];

            $blog->save();
            $image =  $params['images'];

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
        // return view($this->getShowView())->with('success', 'created Successfully.');
        return  redirect()->back()->with('success', 'created Successfully.');
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

}
