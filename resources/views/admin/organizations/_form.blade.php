@csrf
<div class="card-body">
    <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $organization->name ?? '') }}" required>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="slug">Slug</label>
        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $organization->slug ?? '') }}" required>
        @error('slug')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="card-footer">
    <a href="{{ route('admin.organizations.index') }}" class="btn btn-secondary">Cancelar</a>
    <button type="submit" class="btn btn-primary float-right">{{ $buttonText ?? 'Salvar' }}</button>
</div>
