<!-- Sidebar-right-->
		<div class="sidebar sidebar-left sidebar-animate">
			<div class="panel panel-primary card mb-0 box-shadow">
				<div class="tab-menu-heading border-0 p-3">
					<div class="card-title mb-0">{{__('admin.header.notifications')}}</div>
					<div class="card-options mr-auto">
						<a href="#" class="sidebar-remove"><i class="fe fe-x"></i></a>
					</div>
				</div>
				<div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
					<div class="tabs-menu ">
						<!-- Tabs -->
						<ul class="nav panel-tabs">
							<li class=""><a href="#messages" class="active" data-toggle="tab"><i class="ion ion-md-chatboxes tx-18 ml-2"></i>{{__('admin.header.messages')}}</a></li>
							<li><a href="#notifications" data-toggle="tab"><i class="ion ion-md-notifications tx-18  ml-2"></i> {{__('admin.header.notifications')}}</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div class="tab-pane active " id="messages">
							<div class="list d-flex align-items-center border-bottom p-3">
								<div class="">
									<span class="avatar bg-primary brround avatar-md">CH</span>
								</div>
								<a class="wrapper w-100 mr-3" href="#" data-toggle="modal" data-target="#chatmodel">
									<p class="mb-0 d-flex ">
										<b>New Websites is Created</b>
									</p>
									<div class="d-flex justify-content-between align-items-center">
										<div class="d-flex align-items-center">
											<i class="mdi mdi-clock text-muted ml-1"></i>
											<small class="text-muted ml-auto">30 mins ago</small>
											<p class="mb-0"></p>
										</div>
									</div>
								</a>
							</div>
						</div>
						<div class="tab-pane  " id="notifications">
							<div class="list-group list-group-flush ">
								<div class="list-group-item d-flex  align-items-center">
									<div class="ml-3">
										<span class="avatar avatar-lg brround cover-image" data-image-src="{{URL::asset('assets/admin/img/faces/12.jpg')}}"><span class="avatar-status bg-success"></span></span>
									</div>
									<div>
										<strong>Madeleine</strong> Hey! there I' am available....
										<div class="small text-muted">
											3 hours ago
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--/Sidebar-right-->
