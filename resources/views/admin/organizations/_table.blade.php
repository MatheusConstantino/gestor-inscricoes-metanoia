<div class="list-group">
    <div class="list-group-item list-group-item-action list-group-item-light">
        <div class="row font-weight-bold">
            <div class="col-1">#</div>
            <div class="col-4">Nome</div>
            <div class="col-3">Slug</div>
            <div class="col-2">Status</div>
            <div class="col-2">Ações</div>
        </div>
    </div>
    @forelse ($organizations as $organization)
        <div class="list-group-item list-group-item-action" id="organization-{{ $organization->id }}">
            <div class="row">
                <div class="col-1">{{ $organization->id }}</div>
                <div class="col-4">{{ $organization->name }}</div>
                <div class="col-3">{{ $organization->slug }}</div>
                <div class="col-2">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input status-toggle" id="status-{{ $organization->id }}" data-id="{{ $organization->id }}" {{ $organization->status === 'ativo' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="status-{{ $organization->id }}"></label>
                    </div>
                </div>
                <div class="col-2">
                    <a href="{{ route('admin.organizations.edit', $organization) }}" class="text-muted mr-3" title="Editar"><i class="fas fa-pencil-alt"></i></a>
                    <a href="#" class="text-danger delete-btn" data-id="{{ $organization->id }}" title="Excluir"><i class="fas fa-trash"></i></a>
                </div>
            </div>
        </div>
    @empty
        <div class="list-group-item">
            <p class="text-center">Nenhuma organização encontrada.</p>
        </div>
    @endforelse
</div>
