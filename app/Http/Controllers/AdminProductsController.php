<?php

namespace App\Http\Controllers;

use App\Exports\AdminproductsExport;
use App\Http\Requests\AdminCategoryRequest;
use App\Http\Requests\AdminproductRequest;
use App\Models\Category;
use App\Models\product;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminProductsController extends Controller
{
    public $filtCategoryId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->filtCategoryId = ($request->session()->has('products_filter_category')) ? ($request->session()->get('products_filter_category')) : "";
            return $next($request);
        });
    }

    public function index()
    {
        if (!auth()->user()->isAbleTo('admin-products')) {
            app()->abort(403);
        }

        $pageTitle = trans('products/admin_lang.products');
        $title = trans('products/admin_lang.list');
        $categoryList = Category::active()->get();

        return view('products.admin_index', compact('pageTitle', 'title', 'categoryList'))
            ->with([
                'filtCategoryId' => $this->filtCategoryId,
            ]);
    }

    public function create()
    {
        if (!auth()->user()->isAbleTo('admin-products-create')) {
            app()->abort(403);
        }
        $pageTitle = trans('products/admin_lang.new');

        $title = trans('products/admin_lang.list');
        $product = new Product();

        $categoryList = Category::active()->get();
        return view('products.admin_edit', compact('pageTitle', 'title', "product", 'categoryList'));
    }

    public function store(AdminCategoryRequest $request)
    {
        if (!auth()->user()->isAbleTo('admin-products-create')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $product = new Product();

            $this->saveProduct($product, $request);

            DB::commit();

            return redirect()->route('admin.products.edit', [$product->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/products/create')
                ->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        if (!auth()->user()->isAbleTo('admin-products-read')) {
            app()->abort(403);
        }
        $product = product::find($id);

        if (empty($product)) {
            app()->abort(404);
        }

        $pageTitle = trans('products/admin_lang.show');
        $title = trans('products/admin_lang.list');

        $categoryList = Category::active()->get();
        $disabled = "disabled";
        return view('products.admin_edit', compact('pageTitle', 'title', "product", 'categoryList', 'disabled'));
    }

    public function edit($id)
    {
        if (!auth()->user()->isAbleTo('admin-products-update')) {
            app()->abort(403);
        }
        $product = product::find($id);

        if (empty($product)) {
            app()->abort(404);
        }

        $pageTitle = trans('products/admin_lang.edit');
        $title = trans('products/admin_lang.list');

        $categoryList = Category::active()->get();

        return view('products.admin_edit', compact('pageTitle', 'title', "product", 'categoryList'));
    }

    public function update(AdminproductRequest $request, $id)
    {
        if (!auth()->user()->isAbleTo('admin-products-update')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $product = product::find($id);

            $this->saveProduct($product, $request);

            DB::commit();


            return redirect()->route('admin.products.edit', [$product->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/products/create/' . $product->id)
                ->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }


    public function getData()
    {
        if (!auth()->user()->isAbleTo('admin-products-list')) {
            app()->abort(403);
        }
        $query = product::select([
            'products.active',
            'products.id',
            'products.name',
            'provinces.name as provincia',

        ])->leftJoin("provinces", "products.province_id", "provinces.id");
        $this->addFilter($query);

        $table = DataTables::of($query);

        $table->editColumn('active', function ($data) {
            $permision = "";
            if (!auth()->user()->isAbleTo('admin-products-update')) {
                $permision = "disabled";
            }

            $state = $data->active ? "checked" : "";

            return  '<div class="form-check form-switch ">
                <input class="form-check-input" onclick="changeState(' . $data->id . ')" ' . $state . '  ' . $permision . '  value="1" name="active" type="checkbox" id="active">
            </div>';
        });

        $table->editColumn('actions', function ($data) {
            $actions = '';
            if (auth()->user()->isAbleTo("admin-products-read")) {
                $actions .= '<a  class="btn btn-info btn-xs" data-bs-content="' . trans('general/admin_lang.show') . '" data-bs-placement="left" data-bs-toggle="popover" data-bs-content="' . trans('general/front_lang.show') . '" data-bs-placement="right" 
                data-bs-toggle="popover" href="' . route('admin.products.show', $data->id) . '" ><i
                class="fa fa-eye fa-lg"></i></a> ';
            }
            if (auth()->user()->isAbleTo("admin-products-update")) {
                $actions .= '<a  class="btn btn-primary btn-xs" data-bs-content="' . trans('general/admin_lang.edit') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.products.edit', $data->id) . '" ><i
                class="fa fa-marker fa-lg"></i></a> ';
            }

            if (auth()->user()->isAbleTo("admin-products-delete")) {

                $actions .= '<button class="btn btn-danger btn-xs" data-bs-content="' . trans('general/admin_lang.delete') . '" data-bs-placement="left" data-bs-toggle="popover" onclick="javascript:deleteElement(\'' .
                    url('admin/products/' . $data->id) . '\');" data-content="' .
                    trans('general/admin_lang.borrar') . '" data-placement="left" data-toggle="popover">
                        <i class="fa fa-trash" aria-hidden="true"></i></button>';
            }

            return $actions;
        });

        $table->removeColumn('id');
        $table->rawColumns(['actions', 'active',  'default']);
        return $table->make();
    }

    public function saveFilter(Request $request)
    {
        $this->clearSesions($request);
        if (!empty($request->province_id))
            $request->session()->put('products_filter_category', $request->province_id);

        return redirect('admin/products');
    }
    public function removeFilter(Request $request)
    {
        $this->clearSesions($request);
        return redirect('admin/products');
    }

    private function addFilter(&$query)
    {

        if (!empty($this->filtCategoryId)) {
            $query->where("provinces.id", $this->filtCategoryId);
        }
    }
    private function clearSesions($request)
    {
        $request->session()->forget('products_filter_category');
    }
    public function destroy($id)
    {
        // Si no tiene permisos para modificar lo echamos
        if (!auth()->user()->isAbleTo('admin-products-delete')) {
            app()->abort(403);
        }
        $product = product::find($id);
        if (empty($product)) {
            app()->abort(404);
        }

        $product->delete();

        return response()->json(array(
            'success' => true,
            'msg' => trans("general/admin_lang.delete_ok"),
        ));
    }

    public function changeState($id)
    {
        if (!auth()->user()->isAbleTo('admin-products-update')) {
            app()->abort(403);
        }

        $product = product::find($id);

        if (!empty($product)) {
            $product->active = !$product->active;
            return $product->save() ? 1 : 0;
        }

        return 0;
    }


    public function exportExcel()
    {
        if (!auth()->user()->isAbleTo('admin-products-list')) {
            app()->abort(403);
        }
        $query = product::select([
            'products.active',
            'products.id',
            'products.name',
            'provinces.name as province',

        ])->leftJoin("provinces", "products.province_id", "provinces.id");
        $this->addFilter($query);
        return Excel::download(new AdminproductsExport($query), strtolower(trans('products/admin_lang.products')) . '_' . Carbon::now()->format("dmYHis") . '.xlsx');
    }


    private function saveProduct($product, $request)
    {
        $product->name = $request->input('name');
        $product->active = $request->input('active', 0);
        $product->province_id = $request->input('province_id', null);
        $product->save();
    }

    public function getproductListByProvince($id = null)
    {
        return product::where("province_id", $id)->get();
        // return product::active()->where("province_id", $id)->get();
    }
}
