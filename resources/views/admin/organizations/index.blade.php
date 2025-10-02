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
        <a href="#" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Adicionar Nova</a>
    </div>

    <div id="organizations-table">
        @include('admin.organizations._table')
    </div>

    <div class="d-flex justify-content-center">
        {{ $organizations->links() }}
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Nova Organização</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="createForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <span class="text-danger" id="name_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                            <span class="text-danger" id="slug_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="createSubmitBtn">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Organização</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_name">Nome</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                            <span class="text-danger" id="edit_name_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_slug">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug" required>
                            <span class="text-danger" id="edit_slug_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary" id="editSubmitBtn">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
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

            // Clear validation errors on modal close
            $('#createModal, #editModal').on('hidden.bs.modal', function () {
                $('.text-danger').text('');
                $('input').removeClass('is-invalid');
                $('#createForm')[0].reset();
                $('#editForm')[0].reset();
            });

            $('#createForm').on('submit', function (e) {
                e.preventDefault();
                let btn = $('#createSubmitBtn');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...');

                // Clear previous errors
                $('.text-danger').text('');
                $('input').removeClass('is-invalid');

                $.ajax({
                    url: '{{ route("admin.organizations.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#createModal').modal('hide');
                        Toast.fire({
                            type: 'success',
                            title: response.message
                        });
                        reloadTable();
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('#name').addClass('is-invalid');
                                $('#name_error').text(errors.name[0]);
                            }
                            if (errors.slug) {
                                $('#slug').addClass('is-invalid');
                                $('#slug_error').text(errors.slug[0]);
                            }
                        } else {
                            Toast.fire({
                                type: 'error',
                                title: 'Erro ao criar organização.'
                            });
                        }
                    },
                    complete: function () {
                        btn.prop('disabled', false).html('Salvar');
                    }
                });
            });

            $('.edit-btn').on('click', function () {
                let id = $(this).data('id');
                $.get('/admin/organizations/' + id + '/edit', function (data) {
                    $('#edit_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_slug').val(data.slug);
                });
            });

            $('#editForm').on('submit', function (e) {
                e.preventDefault();
                let id = $('#edit_id').val();
                let btn = $('#editSubmitBtn');
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Atualizando...');

                // Clear previous errors
                $('.text-danger').text('');
                $('input').removeClass('is-invalid');

                $.ajax({
                    url: '/admin/organizations/' + id,
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#editModal').modal('hide');
                        Toast.fire({
                            type: 'success',
                            title: response.message
                        });
                        reloadTable();
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $('#edit_name').addClass('is-invalid');
                                $('#edit_name_error').text(errors.name[0]);
                            }
                            if (errors.slug) {
                                $('#edit_slug').addClass('is-invalid');
                                $('#edit_slug_error').text(errors.slug[0]);
                            }
                        } else {
                            Toast.fire({
                                type: 'error',
                                title: 'Erro ao atualizar organização.'
                            });
                        }
                    },
                    complete: function () {
                        btn.prop('disabled', false).html('Atualizar');
                    }
                });
            });

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
