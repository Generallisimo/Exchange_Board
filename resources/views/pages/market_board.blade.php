@extends('layouts.app', ['page' => __('Market Board'), 'pageSlug' => 'market board'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Market Board</h5>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Name</th>
                        <th>Job Position</th>
                        <th>Since</th>
                        <th class="text-right">Salary</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td>Andrew Mike</td>
                        <td>Develop</td>
                        <td>2013</td>
                        <td class="text-right">&euro; 99,225</td>
                        <td class="td-actions text-right">
                            <button type="button" rel="tooltip" class="btn btn-info btn-sm btn-icon">
                                <i class="tim-icons icon-single-02"></i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                                <i class="tim-icons icon-settings"></i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-danger btn-sm btn-icon">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection