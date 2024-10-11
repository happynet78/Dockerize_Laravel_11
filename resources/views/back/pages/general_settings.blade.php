@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title here')
@section('content')

    <div class="page-header">
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="title">
					<h4>Tabs</h4>
				</div>
				<nav aria-label="breadcrumb" role="navigation">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('admin.dashboard') }}">Home</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							Settings
						</li>
					</ol>
				</nav>
			</div>
		</div>
    </div>

    <div class="pd-20 card-box mb-4">
        <div class="tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-blue" data-toggle="tab" href="#general_setting" role="tab" aria-selected="true">General setting</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-blue" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Logo & Favicon</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="general_setting" role="tabpanel">
                    <div class="pd-20">
                        ---- General setting ----
                    </div>
                </div>

                <div class="tab-pane fade" id="logo_favicon" role="tabpanel">
                    <div class="pd-20">
                        ---- Logo & Favicon ----
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
