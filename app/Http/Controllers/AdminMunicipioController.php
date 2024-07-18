<?php

namespace App\Http\Controllers;

use App\Exports\AdminMunicipiosExport;
use App\Http\Requests\AdminMunicipioRequest;
use App\Models\Municipio;
use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminMunicipioController extends Controller
{
    public $filtProvinceId;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->filtProvinceId = ($request->session()->has('municipio_filter_province_id')) ? ($request->session()->get('municipio_filter_province_id')) : "";
            return $next($request);
        });
    }

    public function index()
    {
        if (!auth()->user()->isAbleTo('admin-municipios')) {
            app()->abort(403);
        }

        $pageTitle = trans('municipios/admin_lang.municipios');
        $title = trans('municipios/admin_lang.list');
        $provincesList = Province::active()->get();

        return view('municipios.admin_index', compact('pageTitle', 'title', 'provincesList'))
            ->with([
                'filtProvinceId' => $this->filtProvinceId,
            ]);
    }

    public function create()
    {
        if (!auth()->user()->isAbleTo('admin-municipios-create')) {
            app()->abort(403);
        }
        $pageTitle = trans('municipios/admin_lang.new');
     
        $title = trans('municipios/admin_lang.list');
        $municipio = new Municipio();

        $provincesList = Province::active()->get();
        return view('municipios.admin_edit', compact('pageTitle', 'title', "municipio", 'provincesList'));
    }

    public function store(AdminMunicipioRequest $request)
    {
        if (!auth()->user()->isAbleTo('admin-municipios-create')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $municipio = new Municipio();

            $this->saveMunicipio($municipio, $request);

            DB::commit();

            return redirect()->route('admin.municipios.edit', [$municipio->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/municipios/create')
                ->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        if (!auth()->user()->isAbleTo('admin-municipios-read')) {
            app()->abort(403);
        }
        $municipio = Municipio::find($id);

        if (empty($municipio)) {
            app()->abort(404);
        }

        $pageTitle = trans('municipios/admin_lang.show');
        $title = trans('municipios/admin_lang.list');

        $provincesList = Province::active()->get();
        $disabled = "disabled";
        return view('municipios.admin_edit', compact('pageTitle', 'title', "municipio", 'provincesList', 'disabled'));
    }

    public function edit($id)
    {
        if (!auth()->user()->isAbleTo('admin-municipios-update')) {
            app()->abort(403);
        }
        $municipio = Municipio::find($id);

        if (empty($municipio)) {
            app()->abort(404);
        }

        $pageTitle = trans('municipios/admin_lang.edit');
        $title = trans('municipios/admin_lang.list');

        $provincesList = Province::active()->get();

        return view('municipios.admin_edit', compact('pageTitle', 'title', "municipio", 'provincesList'));
    }

    public function update(AdminMunicipioRequest $request, $id)
    {
        if (!auth()->user()->isAbleTo('admin-municipios-update')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $municipio = Municipio::find($id);

            $this->saveMunicipio($municipio, $request);

            DB::commit();


            return redirect()->route('admin.municipios.edit', [$municipio->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/municipios/create/' . $municipio->id)
                ->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }


    public function getData()
    {
        if (!auth()->user()->isAbleTo('admin-municipios-list')) {
            app()->abort(403);
        }
        $query = Municipio::select([
            'municipios.active',
            'municipios.id',
            'municipios.name',
            'provinces.name as provincia',

        ])->leftJoin("provinces", "municipios.province_id", "provinces.id");
        $this->addFilter($query);

        $table = DataTables::of($query);

        $table->editColumn('active', function ($data) {
            $permision = "";
            if (!auth()->user()->isAbleTo('admin-municipios-update')) {
                $permision = "disabled";
            }

            $state = $data->active ? "checked" : "";

            return  '<div class="form-check form-switch ">
                <input class="form-check-input" onclick="changeState(' . $data->id . ')" ' . $state . '  ' . $permision . '  value="1" name="active" type="checkbox" id="active">
            </div>';
        });

        $table->editColumn('actions', function ($data) {
            $actions = '';
            if (auth()->user()->isAbleTo("admin-municipios-read")) {
                $actions .= '<a  class="btn btn-info btn-xs" data-bs-content="' .trans('general/admin_lang.show') . '" data-bs-placement="left" data-bs-toggle="popover" data-bs-content="' . trans('general/front_lang.show') . '" data-bs-placement="right" 
                data-bs-toggle="popover" href="' . route('admin.municipios.show', $data->id) . '" ><i
                class="fa fa-eye fa-lg"></i></a> ';
            }
            if (auth()->user()->isAbleTo("admin-municipios-update")) {
                $actions .= '<a  class="btn btn-primary btn-xs" data-bs-content="' .trans('general/admin_lang.edit') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.municipios.edit', $data->id) . '" ><i
                class="fa fa-marker fa-lg"></i></a> ';
            }

            if (auth()->user()->isAbleTo("admin-municipios-delete")) {

                $actions .= '<button class="btn btn-danger btn-xs" data-bs-content="' .trans('general/admin_lang.delete'). '" data-bs-placement="left" data-bs-toggle="popover" onclick="javascript:deleteElement(\'' .
                    url('admin/municipios/' . $data->id) . '\');" data-content="' .
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
            $request->session()->put('municipio_filter_province_id', $request->province_id);

        return redirect('admin/municipios');
    }
    public function removeFilter(Request $request)
    {
        $this->clearSesions($request);
        return redirect('admin/municipios');
    }

    private function addFilter(&$query)
    {

        if (!empty($this->filtProvinceId)) {
            $query->where("provinces.id", $this->filtProvinceId);
        }
    }
    private function clearSesions($request)
    {
        $request->session()->forget('municipio_filter_province_id');
    }
    public function destroy($id)
    {
        // Si no tiene permisos para modificar lo echamos
        if (!auth()->user()->isAbleTo('admin-municipios-delete')) {
            app()->abort(403);
        }
        $municipio = Municipio::find($id);
        if (empty($municipio)) {
            app()->abort(404);
        }

        $municipio->delete();

        return response()->json(array(
            'success' => true,
            'msg' => trans("general/admin_lang.delete_ok"),
        ));
    }

    public function changeState($id)
    {
        if (!auth()->user()->isAbleTo('admin-municipios-update')) {
            app()->abort(403);
        }

        $municipio = Municipio::find($id);

        if (!empty($municipio)) {
            $municipio->active = !$municipio->active;
            return $municipio->save() ? 1 : 0;
        }

        return 0;
    }


    public function exportExcel()
    {
        if (!auth()->user()->isAbleTo('admin-municipios-list')) {
            app()->abort(403);
        }
        $query = Municipio::select([
            'municipios.active',
            'municipios.id',
            'municipios.name',
            'provinces.name as province',

        ])->leftJoin("provinces", "municipios.province_id", "provinces.id");
        $this->addFilter($query);
        return Excel::download(new AdminMunicipiosExport($query), strtolower(trans('municipios/admin_lang.municipios')) . '_' . Carbon::now()->format("dmYHis") . '.xlsx');
    }


    private function saveMunicipio($municipio, $request)
    {
        $municipio->name = $request->input('name');
        $municipio->active = $request->input('active', 0);
        $municipio->province_id = $request->input('province_id', null);
        $municipio->save();
    }

    public function getMunicipioListByProvince($id = null)
    {
        return Municipio::where("province_id", $id)->get();
        // return Municipio::active()->where("province_id", $id)->get();
    }
}
