<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Builder;
use Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class RolesListDatatable extends Controller
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addIndexColumn()
            ->editColumn('status', function (User $user) {
                if ($user->status == 1)
                    return '<label class="label label-success">Active</label>';
                else return '<label class="label label-danger">Deactive</label>';
            })
            ->editColumn('created_at', function (User $user) {
                return date('d-m-Y H:i:s', strtotime($user->created_at));
            })
            ->editColumn('checkbox', function (User $user) {
                return '<input type="checkbox" data-id="' . $user->id . '" class="sub_chk" name="ids[]" />';
            })

            ->addColumn('action', function (User $user) {
                return view('backend.users.usersaction', compact('user'))->render();
            })
            ->rawColumns(['checkbox', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {

        $users = User::select('id', 'name', 'email', 'status', 'created_at', 'updated_at');
        if ($this->request()->get('startDate')) {
            $st = $this->request()->get('startDate');
            $dt = ($this->request()->get('endDate') == '') ? date('Y-m-d') : $this->request()->get('endDate');
            $users->whereDate('created_at', '<=', "$dt");
            $users->whereDate('created_at', '>=', "$st");
        }
        if ($this->request()->get('status') == '0' || $this->request()->get('status') == '1') {
            $users->where('status', $this->request()->get('status'));
        }
        // $users->orderBy('created_at','DESC')             
        $users->get();

        return $this->applyScopes($users);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()

            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '10%'])
            ->addCheckbox(['width' => '10px'], true)
            ->parameters($this->getBuilderParameters())
            ->parameters([
                'order' => [
                    5, // here is the column number
                    'desc'
                ],
                'scrollX' => true,
                'extend'  => 'collection',
                'text'    => 'Export',
                'dom'     => 'Bfrtipl',
                // 'buttons' =>  ['csv', 'excel', 'pdf' , 'print'],
                'initComplete' => "function () {
                            this.api().columns().every(function () {
                                var column = this;
                                var input = document.createElement(\"input\");
                                $(input).appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                            });
                        }",
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            //'DT_RowIndex' => ['width' => '10px', 'title' => 'S.No', 'searchable' => false, 'orderable' => false],
            'name',
            'email',
            'status',
            'created_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
