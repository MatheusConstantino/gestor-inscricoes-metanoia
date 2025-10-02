@extends('layouts.app')

@section('title', 'Nova Organização')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Nova Organização</h1>
        </div>
        <div class="col-sm-6">
            @php
                $breadcrumbItems = [
                    ['name' => 'Dashboard', 'url' => route('admin.dashboard')],
                    ['name' => 'Organizações', 'url' => route('admin.organizations.index')],
                    ['name' => 'Nova', 'url' => '#']
                ];
            @endphp
            <x-breadcrumb :items="$breadcrumbItems" />
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulário de Criação</h3>
        </div>
        <form id="createForm">
            @include('admin.organizations._form', ['buttonText' => 'Salvar'])
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

        $('#createForm').on('submit', function(e) {
            e.preventDefault();
            let btn = $('#createSubmitBtn');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...');

            $('.text-danger').text('');
            $('input').removeClass('is-invalid');

            $.ajax({
                url: '{{ route("admin.organizations.store") }}',
                method: 'POST',
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
                            title: 'Erro ao criar organização.'
                        });
                    }
                },
                complete: function() {
                    btn.prop('disabled', false).html('Salvar');
                }
            });
        });
    });
</script>
@stop
