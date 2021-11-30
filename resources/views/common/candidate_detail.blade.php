@extends('layouts.master')
@section('title', 'Campus Screening Tracker')
@section('PageContent')
<style>
    .profile-view {
	position: relative
}

.profile-view .profile-img-wrap {
	height: 120px;
	width: 120px
}

.profile-view .profile-img {
	width: 120px;
	height: 120px
}

.profile-view .profile-img .avatar {
	font-size: 24px;
	height: 120px;
	line-height: 120px;
	margin: 0;
	width: 120px
}

.profile-view .profile-basic {
	margin-left: 140px;
	padding-right: 50px
}

.profile-view .pro-edit {
	position: absolute;
	right: 0;
	top: 0
}
</style>
    <div class="page-content">
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                   <div class="col-md-12">
                       <div class="profile-view">

                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scriptsection')

@endsection
