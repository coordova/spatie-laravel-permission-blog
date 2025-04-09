@csrf
<div class="mb-3">
    <label for="name" class="form-label">Nombre de la Categoría</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    <small class="form-text text-muted">El slug se generará automáticamente.</small>
</div>

<button type="submit" class="btn btn-primary">
    {{ isset($category) ? 'Actualizar Categoría' : 'Crear Categoría' }}
</button>
<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancelar</a>
