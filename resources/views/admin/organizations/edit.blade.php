@extends('layouts.app')

@section('title', 'Editar Organização')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Editar Organização</h1>
        </div>
        <div class="col-sm-6">
            @php
                $breadcrumbItems = [
                    ['name' => 'Dashboard', 'url' => route('admin.dashboard')],
                    ['name' => 'Organizações', 'url' => route('admin.organizations.index')],
                    ['name' => 'Editar', 'url' => '#']
                ];
            @endphp
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulário de Edição</h3>
        </div>
        <form id="editForm">
            @method('PUT')
            @include('admin.organizations._form', ['organization' => $organization, 'buttonText' => 'Atualizar'])
        </form>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            let btn = $('#editSubmitBtn');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Atualizando...');

            $('.text-danger').text('');
            $('input').removeClass('is-invalid');

            $.ajax({
                url: '{{ route("admin.organizations.update", $organization) }}',
                method: 'POST', // Still POST, but with @method('PUT')
                data: $(this).serialize(),
                success: function(response) {
                    Toast.fire({
                        type: 'success',
                        title: response.message
                    }).then(() => {
                        window.location.href = '{{ route("admin.organizations.index") }}';
                    });
                },
                error: function(xhr) {
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
                            title: 'Erro ao atualizar organização.'
                        });
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html('Atualizar');
                }
            });
        });
    });
</script>
@stop
