<?php

namespace App\Http\Controllers;

use App\Exports\AdminCategoriesExport;
use App\Http\Requests\AdminCategoryRequest;
use App\Models\Category;
use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminCategoryController extends Controller
{

    public function __construct()
    {
        
    }

    public function index()
    {
        if (!auth()->user()->isAbleTo('admin-categories')) {
            app()->abort(403);
        }

        $pageTitle = trans('categories/admin_lang.categories');
        $title = trans('categories/admin_lang.list');
        $provincesList = Category::active()->get();

        return view('categories.admin_index', compact('pageTitle', 'title'));
    }

    public function create()
    {
        if (!auth()->user()->isAbleTo('admin-categories-create')) {
            app()->abort(403);
        }
        $pageTitle = trans('categories/admin_lang.new');
     
        $title = trans('categories/admin_lang.list');
        $category = new Category();

        return view('categories.admin_edit', compact('pageTitle', 'title', "category"));
    }

    public function store(AdminCategoryRequest $request)
    {
        if (!auth()->user()->isAbleTo('admin-categories-create')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $category = new category();

            $this->saveCategory($category, $request);

            DB::commit();

            return redirect()->route('admin.categories.edit', [$category->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/categories/create')
                ->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        if (!auth()->user()->isAbleTo('admin-categories-read')) {
            app()->abort(403);
        }
        $category = Category::find($id);

        if (empty($category)) {
            app()->abort(404);
        }

        $pageTitle = trans('categories/admin_lang.show');
        $title = trans('categories/admin_lang.list');

        $disabled = "disabled";
        return view('categories.admin_edit', compact('pageTitle', 'title', "category",  'disabled'));
    }

    public function edit($id)
    {
        if (!auth()->user()->isAbleTo('admin-categories-update')) {
            app()->abort(403);
        }
        $category = Category::find($id);

        if (empty($category)) {
            app()->abort(404);
        }

        $pageTitle = trans('categories/admin_lang.edit');
        $title = trans('categories/admin_lang.list');


        return view('categories.admin_edit', compact('pageTitle', 'title', "category"));
    }

    public function update(AdmincategoryRequest $request, $id)
    {
        if (!auth()->user()->isAbleTo('admin-categories-update')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $category = Category::find($id);

            $this->saveCategory($category, $request);

            DB::commit();


            return redirect()->route('admin.categories.edit', [$category->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/categories/create/' . $category->id)
                ->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }


    public function getData()
    {
        if (!auth()->user()->isAbleTo('admin-categories-list')) {
            app()->abort(403);
        }
        $query = Category::select([
            'categories.active',
            'categories.id',
            'categories.name',
            'categories.description'
        ]);

        $table = DataTables::of($query);

        $table->editColumn('active', function ($data) {
            $permision = "";
            if (!auth()->user()->isAbleTo('admin-categories-update')) {
                $permision = "disabled";
            }

            $state = $data->active ? "checked" : "";

            return  '<div class="form-check form-switch ">
                <input class="form-check-input" onclick="changeState(' . $data->id . ')" ' . $state . '  ' . $permision . '  value="1" name="active" type="checkbox" id="active">
            </div>';
        });

        $table->editColumn('actions', function ($data) {
            $actions = '';
            if (auth()->user()->isAbleTo("admin-categories-read")) {
                $actions .= '<a  class="btn btn-info btn-xs" data-bs-content="' .trans('general/admin_lang.show') . '" data-bs-placement="left" data-bs-toggle="popover" data-bs-content="' . trans('general/front_lang.show') . '" data-bs-placement="right" 
                data-bs-toggle="popover" href="' . route('admin.categories.show', $data->id) . '" ><i
                class="fa fa-eye fa-lg"></i></a> ';
            }
            if (auth()->user()->isAbleTo("admin-categories-update")) {
                $actions .= '<a  class="btn btn-primary btn-xs" data-bs-content="' .trans('general/admin_lang.edit') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.categories.edit', $data->id) . '" ><i
                class="fa fa-marker fa-lg"></i></a> ';
            }

            if (auth()->user()->isAbleTo("admin-categories-delete")) {

                $actions .= '<button class="btn btn-danger btn-xs" data-bs-content="' .trans('general/admin_lang.delete'). '" data-bs-placement="left" data-bs-toggle="popover" onclick="javascript:deleteElement(\'' .
                    url('admin/categories/' . $data->id) . '\');" data-content="' .
                    trans('general/admin_lang.borrar') . '" data-placement="left" data-toggle="popover">
                        <i class="fa fa-trash" aria-hidden="true"></i></button>';
            }

            return $actions;
        });

        $table->removeColumn('id');
        $table->rawColumns(['actions', 'active',  'default']);
        return $table->make();
    }

    
   
    public function destroy($id)
    {
        // Si no tiene permisos para modificar lo echamos
        if (!auth()->user()->isAbleTo('admin-categories-delete')) {
            app()->abort(403);
        }
        $category = Category::find($id);
        if (empty($category)) {
            app()->abort(404);
        }

        $category->delete();

        return response()->json(array(
            'success' => true,
            'msg' => trans("general/admin_lang.delete_ok"),
        ));
    }

    public function changeState($id)
    {
        if (!auth()->user()->isAbleTo('admin-categories-update')) {
            app()->abort(403);
        }

        $category = Category::find($id);

        if (!empty($category)) {
            $category->active = !$category->active;
            return $category->save() ? 1 : 0;
        }

        return 0;
    }


    public function exportExcel()
    {
        if (!auth()->user()->isAbleTo('admin-categories-list')) {
            app()->abort(403);
        }
        $query = Category::select([
            'categories.active',
            'categories.id',
            'categories.name',
            'categories.description',

        ]);
        return Excel::download(new AdminCategoriesExport($query), strtolower(trans('categories/admin_lang.categories')) . '_' . Carbon::now()->format("dmYHis") . '.xlsx');
    }


    private function saveCategory($category, $request)
    {
        $category->name = $request->input('name');
        $category->description = $request->input('description');
        $category->active = $request->input('active', 0);
        $category->save();
    }

}
