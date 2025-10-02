@extends('layouts.app')

@section('title', 'Organizações')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Organizações</h1>
        </div>
        <div class="col-sm-6">
            @php
                $breadcrumbItems = [
                    ['name' => 'Dashboard', 'url' => route('admin.dashboard')],
                    ['name' => 'Organizações', 'url' => '#']
                ];
            @endphp
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
    </div>
@stop

@section('content')
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.organizations.create') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-plus"></i> Adicionar Nova</a>
    </div>

    <div id="organizations-table">
        @include('admin.organizations._table')
    </div>

    <div class="d-flex justify-content-center">
        {{ $organizations->links() }}
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });


            function reloadTable() {
                $.get('{{ route("admin.organizations.index") }}', function (data) {
                    $('#organizations-table').html(data);
                });
            }


            // Use event delegation for dynamically added elements
            $(document).on('click', '.delete-btn', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Você tem certeza?',
                    text: "Você não poderá reverter isso!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, exclua!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/admin/organizations/' + id,
                            method: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (response) {
                                Toast.fire({
                                    type: 'success',
                                    title: response.message
                                });
                                reloadTable();
                            },
                            error: function (xhr) {
                                Toast.fire({
                                    type: 'error',
                                    title: 'Erro ao excluir organização.'
                                });
                            }
                        });
                    }
                })
            });

            $(document).on('change', '.status-toggle', function() {
                let id = $(this).data('id');
                let status = $(this).is(':checked');

                $.ajax({
                    url: `/admin/organizations/${id}/toggle-status`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        Toast.fire({
                            type: 'success',
                            title: response.message
                        });
                    },
                    error: function(xhr) {
                        Toast.fire({
                            type: 'error',
                            title: 'Erro ao atualizar status.'
                        });
                        // Revert the toggle on error
                        $(this).prop('checked', !status);
                    }.bind(this)
                });
            });
        });
    </script>
@stop
