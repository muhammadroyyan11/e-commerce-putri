@extends('admin.layouts.app')

@section('title', 'Pengaturan Halaman About')
@section('page-title', 'Pengaturan Halaman About')

@section('content')
<form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Hero Image --}}
    <div class="card card-outline card-primary mb-3">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-image mr-2"></i>Gambar Hero</h3></div>
        <div class="card-body">
            @if($settings['about_hero_image'])
                <img src="{{ $settings['about_hero_image'] }}" style="max-height:120px;" class="img-thumbnail mb-2 d-block">
            @endif
            <div class="form-group mb-2">
                <label>URL Gambar</label>
                <input type="text" name="about_hero_image" class="form-control" value="{{ old('about_hero_image', $settings['about_hero_image']) }}" placeholder="https://...">
            </div>
            <div class="form-group mb-0">
                <label>Upload Gambar</label>
                <input type="file" name="about_hero_image_file" class="form-control-file" accept="image/*">
            </div>
        </div>
    </div>

    {{-- Our Story --}}
    <div class="card card-outline card-success mb-3">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-book-open mr-2"></i>Our Story</h3></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Judul Story <span class="badge badge-warning">ID</span></label>
                        <input type="text" name="about_story_title_id" class="form-control" value="{{ old('about_story_title_id', $settings['about_story_title_id']) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Story Title <span class="badge badge-info">EN</span></label>
                        <input type="text" name="about_story_title_en" class="form-control" value="{{ old('about_story_title_en', $settings['about_story_title_en']) }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paragraf 1 <span class="badge badge-warning">ID</span></label>
                        <textarea name="about_story_desc1_id" class="form-control" rows="4">{{ old('about_story_desc1_id', $settings['about_story_desc1_id']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paragraph 1 <span class="badge badge-info">EN</span></label>
                        <textarea name="about_story_desc1_en" class="form-control" rows="4">{{ old('about_story_desc1_en', $settings['about_story_desc1_en']) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paragraf 2 <span class="badge badge-warning">ID</span></label>
                        <textarea name="about_story_desc2_id" class="form-control" rows="4">{{ old('about_story_desc2_id', $settings['about_story_desc2_id']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Paragraph 2 <span class="badge badge-info">EN</span></label>
                        <textarea name="about_story_desc2_en" class="form-control" rows="4">{{ old('about_story_desc2_en', $settings['about_story_desc2_en']) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Statistik: Tahun Berdiri</label>
                        <input type="text" name="about_stat_years" class="form-control" value="{{ old('about_stat_years', $settings['about_stat_years']) }}" placeholder="4+">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Statistik: Tanaman Terjual</label>
                        <input type="text" name="about_stat_plants" class="form-control" value="{{ old('about_stat_plants', $settings['about_stat_plants']) }}" placeholder="50K+">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Statistik: Pelanggan</label>
                        <input type="text" name="about_stat_customers" class="form-control" value="{{ old('about_stat_customers', $settings['about_stat_customers']) }}" placeholder="10K+">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mission & Vision --}}
    <div class="card card-outline card-info mb-3">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-bullseye mr-2"></i>Misi & Visi</h3></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Misi <span class="badge badge-warning">ID</span></label>
                        <textarea name="about_mission_id" class="form-control" rows="4">{{ old('about_mission_id', $settings['about_mission_id']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Mission <span class="badge badge-info">EN</span></label>
                        <textarea name="about_mission_en" class="form-control" rows="4">{{ old('about_mission_en', $settings['about_mission_en']) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Visi <span class="badge badge-warning">ID</span></label>
                        <textarea name="about_vision_id" class="form-control" rows="4">{{ old('about_vision_id', $settings['about_vision_id']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Vision <span class="badge badge-info">EN</span></label>
                        <textarea name="about_vision_en" class="form-control" rows="4">{{ old('about_vision_en', $settings['about_vision_en']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Values --}}
    <div class="card card-outline card-warning mb-3">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-star mr-2"></i>Nilai-Nilai (Values)</h3></div>
        <div class="card-body">
            @foreach([1,2,3,4] as $i)
            <div class="border rounded p-3 mb-3">
                <h6 class="font-weight-bold mb-3">Value #{{ $i }}</h6>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Icon (emoji)</label>
                            <input type="text" name="about_value{{ $i }}_icon" class="form-control" value="{{ old("about_value{$i}_icon", $settings["about_value{$i}_icon"]) }}" placeholder="🌱">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Judul <span class="badge badge-warning">ID</span></label>
                            <input type="text" name="about_value{{ $i }}_title_id" class="form-control" value="{{ old("about_value{$i}_title_id", $settings["about_value{$i}_title_id"]) }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Title <span class="badge badge-info">EN</span></label>
                            <input type="text" name="about_value{{ $i }}_title_en" class="form-control" value="{{ old("about_value{$i}_title_en", $settings["about_value{$i}_title_en"]) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label>Deskripsi <span class="badge badge-warning">ID</span></label>
                            <textarea name="about_value{{ $i }}_text_id" class="form-control" rows="3">{{ old("about_value{$i}_text_id", $settings["about_value{$i}_text_id"]) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label>Description <span class="badge badge-info">EN</span></label>
                            <textarea name="about_value{{ $i }}_text_en" class="form-control" rows="3">{{ old("about_value{$i}_text_en", $settings["about_value{$i}_text_en"]) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="card card-outline card-danger mb-3">
        <div class="card-header"><h3 class="card-title"><i class="fas fa-bullhorn mr-2"></i>CTA (Call to Action)</h3></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Judul CTA <span class="badge badge-warning">ID</span></label>
                        <input type="text" name="about_cta_title_id" class="form-control" value="{{ old('about_cta_title_id', $settings['about_cta_title_id']) }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>CTA Title <span class="badge badge-info">EN</span></label>
                        <input type="text" name="about_cta_title_en" class="form-control" value="{{ old('about_cta_title_en', $settings['about_cta_title_en']) }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label>Deskripsi CTA <span class="badge badge-warning">ID</span></label>
                        <textarea name="about_cta_desc_id" class="form-control" rows="3">{{ old('about_cta_desc_id', $settings['about_cta_desc_id']) }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-0">
                        <label>CTA Description <span class="badge badge-info">EN</span></label>
                        <textarea name="about_cta_desc_en" class="form-control" rows="3">{{ old('about_cta_desc_en', $settings['about_cta_desc_en']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Simpan Perubahan</button>
        <a href="{{ route('admin.team.index') }}" class="btn btn-secondary ml-2"><i class="fas fa-users mr-1"></i>Kelola Tim</a>
    </div>
</form>
@endsection
