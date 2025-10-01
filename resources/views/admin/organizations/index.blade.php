@extends('layouts.app')

@section('title', 'Organizações')

@section('content_header')
    <h1>
        Organizações
        <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#createModal">Adicionar Nova</a>
    </h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Organizações</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Nome</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($organizations as $organization)
                        <tr>
                            <td>{{ $organization->id }}</td>
                            <td>{{ $organization->name }}</td>
                            <td>{{ $organization->slug }}</td>
                            <td>{{ $organization->status }}</td>
                            <td>
                                <button class="btn btn-info btn-sm edit-btn" data-id="{{ $organization->id }}" data-toggle="modal" data-target="#editModal">Editar</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $organization->id }}">Excluir</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Nenhuma organização encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $organizations->links() }}
        </div>
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
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
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
                        </div>
                        <div class="form-group">
                            <label for="edit_slug">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Atualizar</button>
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

            $('#createForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ route("admin.organizations.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#createModal').modal('hide');
                        Toast.fire({
                            type: 'success',
                            title: 'Organização criada com sucesso!'
                        });
                        location.reload();
                    },
                    error: function (xhr) {
                        Toast.fire({
                            type: 'error',
                            title: 'Erro ao criar organização.'
                        });
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
                $.ajax({
                    url: '/admin/organizations/' + id,
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#editModal').modal('hide');
                        Toast.fire({
                            type: 'success',
                            title: 'Organização atualizada com sucesso!'
                        });
                        location.reload();
                    },
                    error: function (xhr) {
                        Toast.fire({
                            type: 'error',
                            title: 'Erro ao atualizar organização.'
                        });
                    }
                });
            });

            $('.delete-btn').on('click', function (e) {
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
                                    title: 'Organização excluída com sucesso!'
                                });
                                location.reload();
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
        });
    </script>
@stop
