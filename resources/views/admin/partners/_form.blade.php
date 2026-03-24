<div class="ad-card" style="margin-bottom:20px;">
    <div class="ad-card-head">
        <h3><i class="fas fa-handshake" style="color:var(--ad-primary);margin-right:6px;"></i>Partner Details</h3>
    </div>
    <div class="ad-card-body">
        <div class="ad-form-row">
            <div class="ad-form-group">
                <label class="ad-label">Name <span class="required">*</span></label>
                <input type="text" name="name" id="nameInput"
                       class="ad-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                       value="{{ old('name', $partner->name ?? '') }}"
                       placeholder="e.g. NITA"
                       required>
                @error('name')<p class="ad-error">{{ $message }}</p>@enderror
            </div>
            <div class="ad-form-group">
                <label class="ad-label">Slug</label>
                <input type="text" name="slug" id="slugInput"
                       class="ad-input {{ $errors->has('slug') ? 'is-invalid' : '' }}"
                       value="{{ old('slug', $partner->slug ?? '') }}"
                       placeholder="auto-generated-from-name">
                <p class="ad-input-hint">Leave blank to generate from the name.</p>
                @error('slug')<p class="ad-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="ad-form-row">
            <div class="ad-form-group">
                <label class="ad-label">Category</label>
                <input type="text" name="category"
                       class="ad-input {{ $errors->has('category') ? 'is-invalid' : '' }}"
                       value="{{ old('category', $partner->category ?? '') }}"
                       placeholder="e.g. Industry Partner">
                @error('category')<p class="ad-error">{{ $message }}</p>@enderror
            </div>
            <div class="ad-form-group">
                <label class="ad-label">Website URL</label>
                <input type="url" name="website_url"
                       class="ad-input {{ $errors->has('website_url') ? 'is-invalid' : '' }}"
                       value="{{ old('website_url', $partner->website_url ?? '') }}"
                       placeholder="https://example.org">
                @error('website_url')<p class="ad-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="ad-form-row">
            <div class="ad-form-group">
                <label class="ad-label">Display Order</label>
                <input type="number" min="0" max="9999" name="sort_order"
                       class="ad-input {{ $errors->has('sort_order') ? 'is-invalid' : '' }}"
                       value="{{ old('sort_order', $partner->sort_order ?? 0) }}">
                <p class="ad-input-hint">Lower numbers appear first.</p>
                @error('sort_order')<p class="ad-error">{{ $message }}</p>@enderror
            </div>
            <div class="ad-form-group">
                <label class="ad-label">Logo {{ isset($partner) ? '' : '*' }}</label>
                <input type="file" name="logo" accept="image/*"
                       class="ad-input {{ $errors->has('logo') ? 'is-invalid' : '' }}">
                @error('logo')<p class="ad-error">{{ $message }}</p>@enderror
                @if(isset($partner) && $partner->logo)
                    <div style="margin-top:10px;">
                        <img src="{{ $partner->logo_url }}"
                             alt="{{ $partner->name }}"
                             style="max-width:160px;max-height:80px;object-fit:contain;border:1px solid var(--ad-border);padding:8px;background:#fff;">
                    </div>
                @endif
            </div>
        </div>

        <div class="ad-form-group">
            <label class="ad-label">Short Description</label>
            <textarea name="short_description" rows="4"
                      class="ad-input {{ $errors->has('short_description') ? 'is-invalid' : '' }}"
                      placeholder="Short summary for the partners page.">{{ old('short_description', $partner->short_description ?? '') }}</textarea>
            @error('short_description')<p class="ad-error">{{ $message }}</p>@enderror
        </div>

        <div class="ad-form-row">
            <label style="display:flex;align-items:center;gap:8px;font-weight:500;">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $partner->is_featured ?? true) ? 'checked' : '' }}>
                Feature on the homepage
            </label>
            <label style="display:flex;align-items:center;gap:8px;font-weight:500;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $partner->is_active ?? true) ? 'checked' : '' }}>
                Visible on the site
            </label>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('nameInput');
    const slugInput = document.getElementById('slugInput');

    if (!nameInput || !slugInput) return;

    let slugEdited = Boolean(slugInput.value);
    slugInput.addEventListener('input', () => {
        slugEdited = slugInput.value.trim() !== '';
    });

    nameInput.addEventListener('input', () => {
        if (slugEdited) return;

        slugInput.value = nameInput.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    });
});
</script>
@endpush
