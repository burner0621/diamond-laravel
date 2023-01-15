@extends('layouts.app', ['activePage' => 'notifications', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Notifications', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Notifications</h4>
                    <p class="card-category">Handcrafted by our friend
                        <a target="_blank" href="https://github.com/mouse0270">Robert McIntosh</a>. Please checkout the
                        <a href="http://bootstrap-notify.remabledesigns.com/" target="_blank">full documentation.</a>
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>
                                <small>Notifications Style</small>
                            </h5>
                            <div class="alert alert-info">
                                <span>This is a plain notification</span>
                            </div>
                            <div class="alert alert-info">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                    <i class="nc-icon nc-simple-remove"></i>
                                </button>
                                <span>This is a notification with close button.</span>
                            </div>
                            <div class="alert alert-info alert-with-icon" data-notify="container">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                    <i class="nc-icon nc-simple-remove"></i>
                                </button>
                                <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                                <span data-notify="message">This is a notification with close button and icon.</span>
                            </div>
                            <div class="alert alert-info alert-with-icon" data-notify="container">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                    <i class="nc-icon nc-simple-remove"></i>
                                </button>
                                <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                                <span data-notify="message">This is a notification with close button and icon and have many lines. You can see that the icon and the close button are always vertically aligned. This is a beautiful notification. So you don't have to worry about the style.</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>
                                <small>Notification States</small>
                            </h5>
                            <div class="alert alert-primary">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                    <i class="nc-icon nc-simple-remove"></i>
                                </button>
                                <span>
                                    <b> Primary - </b> This is a regular notification made with ".alert-primary"</span>
                            </div>
                            <div class="alert alert-info">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                    <i class="nc-icon nc-simple-remove"></i>
                                </button>
                                <span>
                                    <b> Info - </b> This is a regular notification made with ".alert-info"</span>
                            </div>
                            <div class="alert alert-success">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                    <i class="nc-icon nc-simple-remove"></i>
                                </button>
                                <span>
                                    <b> Success - </b> This is a regular notification made with ".alert-success"</span>
                            </div>
                            <div class="alert alert-warning">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                    <i class="nc-icon nc-simple-remove"></i>
                                </button>
                                <span>
                                    <b> Warning - </b> This is a regular notification made with ".alert-warning"</span>
                            </div>
                            <div class="alert alert-danger">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert">
                                    <i class="nc-icon nc-simple-remove"></i>
                                </button>
                                <span>
                                    <b> Danger - </b> This is a regular notification made with ".alert-danger"</span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="places-buttons">
                        <div class="row">
                            <div class="col-md-6 offset-md-3 text-center">
                                <h4 class="card-title">Notifications Places
                                    <p class="card-category">
                                        <small>Click to view notifications</small>
                                    </p>
                                </h4>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-3 col-lg-3">
                                <button class="btn btn-default btn-block" onclick="demo.showNotification('top','left')">Top Left</button>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <button class="btn btn-default btn-block" onclick="demo.showNotification('top','center')">Top Center</button>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <button class="btn btn-default btn-block" onclick="demo.showNotification('top','right')">Top Right</button>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-3 col-lg-3">
                                <button class="btn btn-default btn-block" onclick="demo.showNotification('bottom','left')">Bottom Left</button>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <button class="btn btn-default btn-block" onclick="demo.showNotification('bottom','center')">Bottom Center</button>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <button class="btn btn-default btn-block" onclick="demo.showNotification('bottom','right')">Bottom Right</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4 class="title">Modal</h4>
                            <a class="btn btn-info btn-fill btn-wd" data-toggle="modal" data-target="#myModal1" href="#pablo">
                                Launch Modal Mini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mini Modal -->
            <div class="modal fade modal-mini modal-primary" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <div class="modal-profile">
                                <i class="nc-icon nc-bulb-63"></i>
                            </div>
                        </div>
                        <div class="modal-body text-center">
                            <p>Always have an access to your profile</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link btn-simple">Back</button>
                            <button type="button" class="btn btn-link btn-simple" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--  End Modal -->
        </div>
    </div>
@endsection