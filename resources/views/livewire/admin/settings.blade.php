<div>

    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a wrie:click="selectTab('general_settings')" class="nav-link {{ $tab == 'general_settings' ? 'active':'' }}" data-toggle="tab" href="#general_settings" role="tab" aria-selected="true">General setting</a>
            </li>
            <li class="nav-item">
                <a wire:click="selectTab('logo_favicon')" class="nav-link {{ $tab  == 'logo_favicon' ? 'active' : '' }}" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Logo & Favicon</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade {{ $tab == 'general_settings' ? 'show active' : '' }}" id="general_settings" role="tabpanel">
                <div class="pd-20">
                    <form wire:submit="updateSiteInfo()">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site title</b></label>
                                    <input type="text" class="form-control" wire:model="site_title" placeholder="Enter site title">
                                    @error('site_title')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site email</b></label>
                                    <input type="text" class="form-control" wire:model="site_email" placeholder="Enter site email">
                                    @error('site_email')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site phone number</b><small> (Optional)</small></label>
                                    <input type="text" class="form-control" wire:model="site_phone" placeholder="Enter site contact phone">
                                    @error('site_phone')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for=""><b>Site Meta Keywords</b><small> (Optional)</small></label>
                                    <input type="text" class="form-control" wire:model="site_meta_keywords" placeholder="Eg: ecommerce, free api, laravel">
                                    @error('site_meta_keywords')
                                        <span class="text-danger ml-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for=""><b>Site Meta Description</b><small> (Optional)</small></label>
                            <textarea cols="30" rows="10" class="form-control" placeholder="Type site meta description..."></textarea>
                            @error('site_meta_description')
                                <span class="text-danger ml-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save Change</button>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade {{ $tab == 'logo_favicon' ? 'show active' : '' }}" id="logo_favicon" role="tabpanel">
                <div class="pd-20">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Site Logo</h6>
                            <div class="mb-2 mt-1" style="max-width: 200px;">
                                <img src="/images/site/{{ isset(settings()->site_logo) ? settings()->site_logo : '' }}" data-ijabo-default-img="/images/site/{{ isset(settings()->site_logo) ? settings()->site_logo : '' }}" alt="" class="img-thumbnail" id="preview_site_logo">
                            </div>
                            <form action="{{ route('admin.update_logo') }}" method="post" enctype="multipart/form-data" id="updateLogoForm">
                                @csrf
                                <div class="mb-2">
                                    <input type="file" name="site_logo" id="" class="form-ccontrol">
                                    <span class="text-danger ml-1"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Channge Logo</button>
                            </form>
                        </div>

                        <div class="col-md-6">
                            <h6>Site Favicon</h6>
                            <div class="mb-2 ml-1" style="max-width: 100px;">
                                <img wire:ignore src="/images/site/{{ isset(settings()->site_favicon) ? settings()->site_favicon : '' }}" alt="" class="img-thumbnail" data-ijabo-default-img="/images/site/{{ isset(settings()->site_favicon) ? settings()->site_favicon : '' }}">
                            </div>
                            <form action="{{ route('admin.update_favicon') }}" method="POST" enctype="multipart/form-data" id="updateFaviconForm">
                                @csrf
                                <div class="mb-2">
                                    <input type="file" name="site_favicon" id="" class="form-control">
                                    <span class="text-danger ml-1"></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Change favicon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>

</div>
