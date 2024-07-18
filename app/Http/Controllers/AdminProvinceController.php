<?php

namespace App\Http\Controllers;

use App\Exports\AdminProvincesExport;
use App\Http\Requests\AdminProvinceRequest;
use App\Models\Province;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AdminProvinceController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAbleTo('admin-provinces')) {
            app()->abort(403);
        }

        $pageTitle = trans('provinces/admin_lang.provinces');
        $title = trans('provinces/admin_lang.list');


        return view('provinces.admin_index', compact('pageTitle', 'title'))
            ->with([]);
    }

    public function create()
    {
        if (!auth()->user()->isAbleTo('admin-provinces-create')) {
            app()->abort(403);
        }
        $pageTitle = trans('provinces/admin_lang.new');
        $title = trans('provinces/admin_lang.list');
        $province = new Province();


        return view('provinces.admin_edit', compact('pageTitle', 'title', "province"));
    }

    public function store(AdminProvinceRequest $request)
    {
        if (!auth()->user()->isAbleTo('admin-provinces-create')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $province = new Province();

            $this->saveProvince($province, $request);

            DB::commit();

            return redirect()->route('admin.provinces.edit', [$province->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/provinces/create')
                ->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        if (!auth()->user()->isAbleTo('admin-provinces-read')) {
            app()->abort(403);
        }


        $province = Province::find($id);

        if (empty($province)) {
            app()->abort(404);
        }

        $pageTitle = trans('provinces/admin_lang.show');
        $title = trans('provinces/admin_lang.list');

        $disabled = "disabled";
        return view('provinces.admin_edit', compact('pageTitle', 'title', "province", "disabled"));
    }

    public function edit($id)
    {
        if (!auth()->user()->isAbleTo('admin-provinces-update')) {
            app()->abort(403);
        }


        $province = Province::find($id);

        if (empty($province)) {
            app()->abort(404);
        }

        $pageTitle = trans('provinces/admin_lang.edit');
        $title = trans('provinces/admin_lang.list');


        return view('provinces.admin_edit', compact('pageTitle', 'title', "province"));
    }

    public function update(AdminProvinceRequest $request, $id)
    {
        if (!auth()->user()->isAbleTo('admin-provinces-update')) {
            app()->abort(403);
        }

        try {
            DB::beginTransaction();

            $province = Province::find($id);

            $this->saveProvince($province, $request);

            DB::commit();


            return redirect()->route('admin.provinces.edit', [$province->id])->with('success', trans('general/admin_lang.save_ok'));
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            return redirect('admin/provinces/create/' . $province->id)
                ->with('error', trans('general/admin_lang.save_ko') . ' - ' . $e->getMessage());
        }
    }


    public function getData()
    {
        if (!auth()->user()->isAbleTo('admin-provinces-list')) {
            app()->abort(403);
        }
        $query = Province::select([
            'provinces.active',
            'provinces.id',
            'provinces.name',

        ]);

        $table = DataTables::of($query);

        $table->editColumn('active', function ($data) {
            $permision = "";
            if (!auth()->user()->isAbleTo('admin-provinces-update')) {
                $permision = "disabled";
            }

            $state = $data->active ? "checked" : "";

            return  '<div class="form-check form-switch ">
                <input class="form-check-input" onclick="changeState(' . $data->id . ')" ' . $state . '  ' . $permision . '  value="1" name="active" type="checkbox" id="active">
            </div>';
        });

        $table->editColumn('actions', function ($data) {
            $actions = '';
            if (auth()->user()->isAbleTo("admin-provinces-read")) {
                $actions .= '<a  class="btn btn-info btn-xs" data-bs-content="' .trans('general/admin_lang.show') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.provinces.show', $data->id) . '" ><i
                class="fa fa-eye fa-lg"></i></a> ';
            }
            if (auth()->user()->isAbleTo("admin-provinces-update")) {
                $actions .= '<a  class="btn btn-primary btn-xs" data-bs-content="' .trans('general/admin_lang.edit') . '" data-bs-placement="left" data-bs-toggle="popover" href="' . route('admin.provinces.edit', $data->id) . '" ><i
                class="fa fa-marker fa-lg"></i></a> ';
            }

            if (auth()->user()->isAbleTo("admin-provinces-delete")) {

                $actions .= '<button class="btn btn-danger btn-xs" data-bs-content="' .trans('general/admin_lang.delete'). '" data-bs-placement="left" data-bs-toggle="popover" onclick="javascript:deleteElement(\'' .
                    url('admin/provinces/' . $data->id) . '\');" data-content="' .
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
        if (!auth()->user()->isAbleTo('admin-provinces-delete')) {
            app()->abort(403);
        }
        $province = Province::find($id);
        if (empty($province)) {
            app()->abort(404);
        }

        $province->delete();

        return response()->json(array(
            'success' => true,
            'msg' => trans("general/admin_lang.delete_ok"),
        ));
    }

    public function changeState($id)
    {
        if (!auth()->user()->isAbleTo('admin-provinces-update')) {
            app()->abort(403);
        }

        $province = Province::find($id);

        if (!empty($province)) {
            $province->active = !$province->active;
            return $province->save() ? 1 : 0;
        }

        return 0;
    }


    public function exportExcel()
    {
        if (!auth()->user()->isAbleTo('admin-provinces-list')) {
            app()->abort(403);
        }
        $query = Province::select([
            'provinces.active',
            'provinces.id',
            'provinces.name',

        ]);
        return Excel::download(new AdminProvincesExport($query), strtolower(trans('provinces/admin_lang.provinces')) . '_' . Carbon::now()->format("dmYHis") . '.xlsx');
    }


    private function saveProvince($province, $request)
    {
        $province->name = $request->input('name');
        $province->active = $request->input('active', 0);
        $province->save();
    }
}
