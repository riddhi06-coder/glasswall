@php
    $r = $record ?? null;
@endphp

@if($errors->any())
  <div class="col-12">
    <div class="alert alert-danger mb-0">
      <ul class="mb-0">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
      </ul>
    </div>
  </div>
@endif

<!-- URL Path -->
<div class="col-12">
  <label class="form-label" for="url_path">Page URL / Path <span class="text-danger">*</span></label>
  <input class="form-control" id="url_path" type="text" name="url_path" value="{{ old('url_path', $r->url_path ?? '') }}" placeholder="/about-us  (or paste the full URL)" required>
  <small class="text-secondary">The page this applies to. Use the path (e.g. <b>/about-us</b>). Home page is <b>/</b>. Pasting a full URL is fine — it is normalized automatically. The <b>Page Name</b> shown in the list is generated from this path.</small>
</div>

<!-- Meta Title -->
<div class="col-12">
  <label class="form-label" for="meta_title">Meta Title</label>
  <input class="form-control" id="meta_title" type="text" name="meta_title" value="{{ old('meta_title', $r->meta_title ?? '') }}" placeholder="Page title shown in search results / browser tab" maxlength="255">
  <small class="text-secondary">Recommended length: 50–60 characters.</small>
</div>

<!-- Meta Description -->
<div class="col-12">
  <label class="form-label" for="meta_description">Meta Description</label>
  <textarea class="form-control" id="meta_description" name="meta_description" rows="3" placeholder="Short summary shown under the title in search results" maxlength="1000">{{ old('meta_description', $r->meta_description ?? '') }}</textarea>
  <small class="text-secondary">Recommended length: 150–160 characters.</small>
</div>

<!-- Canonical -->
<div class="col-12">
  <label class="form-label" for="canonical">Canonical</label>
  <input class="form-control" id="canonical" type="text" name="canonical" value="{{ old('canonical', $r->canonical ?? '') }}" placeholder="https://www.glasswallsystems.in/about-us">
  <small class="text-secondary">Leave blank to use the page's own URL automatically.</small>
</div>

<!-- HrefLang -->
<div class="col-12">
  <label class="form-label" for="hreflang">HrefLang</label>
  <textarea class="form-control" id="hreflang" name="hreflang" rows="3" placeholder='&lt;link rel="alternate" href="https://www.glasswallsystems.in/about-us" hreflang="en-in" /&gt;'>{{ old('hreflang', $r->hreflang ?? '') }}</textarea>
  <small class="text-secondary">Paste the raw <code>&lt;link rel="alternate" ... hreflang="..."&gt;</code> tag(s). Leave blank to use the site default.</small>
</div>

<!-- OG Tag -->
<div class="col-12">
  <label class="form-label" for="og_tag">OG Tag</label>
  <textarea class="form-control" id="og_tag" name="og_tag" rows="4" placeholder='&lt;meta property="og:title" content="..." /&gt;&#10;&lt;meta property="og:description" content="..." /&gt;&#10;&lt;meta property="og:image" content="..." /&gt;'>{{ old('og_tag', $r->og_tag ?? '') }}</textarea>
  <small class="text-secondary">Paste the raw Open Graph <code>&lt;meta property="og:..."&gt;</code> tags.</small>
</div>

<!-- Twitter Card Tag -->
<div class="col-12">
  <label class="form-label" for="twitter_card_tag">Twitter Card Tag</label>
  <textarea class="form-control" id="twitter_card_tag" name="twitter_card_tag" rows="4" placeholder='&lt;meta name="twitter:card" content="summary_large_image" /&gt;&#10;&lt;meta name="twitter:title" content="..." /&gt;'>{{ old('twitter_card_tag', $r->twitter_card_tag ?? '') }}</textarea>
  <small class="text-secondary">Paste the raw Twitter card <code>&lt;meta name="twitter:..."&gt;</code> tags.</small>
</div>

<!-- Active -->
<div class="col-12">
  <div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $r->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active (output these tags on the page)</label>
  </div>
</div>
