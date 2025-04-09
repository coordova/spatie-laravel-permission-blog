{{-- Asume $post existe en edit, pero no en create --}}
{{-- Asume $categories y $tags se pasan desde el controlador --}}
{{-- Asume $postCategoryIds y $postTagIds existen en edit --}}

@csrf
<div class="mb-3">
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title ?? '') }}" required>
    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="content" class="form-label">Contenido</label>
    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="10" required>{{ old('content', $post->content ?? '') }}</textarea>
    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="categories" class="form-label">Categorías</label>
        <select name="categories[]" id="categories" class="form-select @error('categories') is-invalid @enderror" multiple size="5">
            {{-- El atributo 'multiple' permite seleccionar varias opciones --}}
            {{-- 'categories[]' en el name indica que se enviará un array --}}
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                        {{-- Verifica si la categoría estaba seleccionada previamente (en edit) o en old() --}}
                        @if( in_array($category->id, old('categories', $postCategoryIds ?? [])) ) selected @endif
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <small class="form-text text-muted">Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varias.</small>
        @error('categories') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @error('categories.*') <div class="invalid-feedback">{{ $message }}</div> @enderror {{-- Para errores de 'exists' --}}
    </div>

    <div class="col-md-6 mb-3">
        <label for="tags" class="form-label">Tags</label>
        <select name="tags[]" id="tags" class="form-select @error('tags') is-invalid @enderror" multiple size="5">
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}"
                        @if( in_array($tag->id, old('tags', $postTagIds ?? [])) ) selected @endif
                >
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>
        <small class="form-text text-muted">Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varias.</small>
        @error('tags') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @error('tags.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

{{-- Checkbox para Publicar (Opcional, depende de tu flujo) --}}
{{-- Solo visible si el usuario tiene permiso para publicar --}}
@can('posts.publish')
    <div class="mb-3 form-check">
        <input type="hidden" name="is_published" value="0"> {{-- Valor por defecto si el checkbox no se marca --}}
        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1"
               @if(old('is_published', $post->is_published ?? false)) checked @endif>
        <label class="form-check-label" for="is_published">
            Publicar este post
        </label>
        @error('is_published') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
@endcan

<button type="submit" class="btn btn-primary">
    {{ isset($post) ? 'Actualizar Post' : 'Crear Post' }}
</button>
<a href="{{ isset($post) ? route('posts.show', $post) : route('home') }}" class="btn btn-secondary">Cancelar</a>
