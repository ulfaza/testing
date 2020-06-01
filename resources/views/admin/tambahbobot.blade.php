@include('layouts.includes.admin_header')
@include('layouts.includes.admin_leftmenu')
@section('content')


<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="Testing Application">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Testing Application</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/nouislider.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/select2.min.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/ionrangeslider/ion.rangeSlider.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/ionrangeslider/ion.rangeSlider.skinFlat.css"/>
  <link rel="stylesheet" type="text/css" href="asset/css/plugins/bootstrap-material-datetimepicker.css"/>
  <link href="asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->


  <div class="form-group"><label class="col-sm-2 control-label text-right">Password</label>
  		<div class="col-sm-10"><input type="password" class="form-control"></div>
  </div>


<!-- start: Content -->
            <div id="content">
                <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h3 class="animated fadeInLeft">BOBOT RELATIF</h3>
                        <!--<p class="animated fadeInDown">
                          Form <span class="fa-angle-right fa"></span> Form Element
                        </p>-->
                    </div>
                  </div>
                </div>

                <div class="form-element">
                  <div class="col-md-12 padding-0">
                    <div class="col-md-12">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">

                        <h4>1. Functional Suitability</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">
                          <div class="col-md-12">

                          	<div class="form-group"><label class="col-sm-2 control-label text-right">1.1 Functional Completeness</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">1.2 Functional Correctness</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">1.3 Functional Approproateness</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                       </div>
                   </div>
                </div>


                <div class="form-element">
                  <div class="col-md-13 padding-0">
                    <div class="col-md-13">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">

                        <h4>2. Performance Efficiency</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">
                          <div class="col-md-12">

                          	<div class="form-group"><label class="col-sm-2 control-label text-right">2.1 Time Behaviour</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">2.2 Resource Utilization</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">2.3 Capacity</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                       </div>
                   </div>
                </div>


                <div class="form-element">
                  <div class="col-md-13 padding-0">
                    <div class="col-md-13">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">

                        <h4>3. Compatibility</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">
                          <div class="col-md-12">

                          	<div class="form-group"><label class="col-sm-2 control-label text-right">3.1 Co-Existence</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">3.2 Interoperability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                       </div>
                   </div>
                </div>


                <div class="form-element">
                  <div class="col-md-13 padding-0">
                    <div class="col-md-13">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">

                        <h4>4. Usability</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">
                          <div class="col-md-12">

                          	<div class="form-group"><label class="col-sm-2 control-label text-right">4.1 Appropriateness Recognizability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">4.2 Learnability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">4.3 Operability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                           <div class="form-group"><label class="col-sm-2 control-label text-right">4.4 User Error Protection</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                           <div class="form-group"><label class="col-sm-2 control-label text-right">4.5 User Interface Aesthetics</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                           <div class="form-group"><label class="col-sm-2 control-label text-right">4.6 Accessibility</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                       </div>
                   </div>
                </div>


                <div class="form-element">
                  <div class="col-md-13 padding-0">
                    <div class="col-md-13">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">

                        <h4>5. Reliability</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">
                          <div class="col-md-12">

                          	<div class="form-group"><label class="col-sm-2 control-label text-right">5.1 Maturity </label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">5.2 Availability </label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">5.3 Fault-Tolerance</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                           <div class="form-group"><label class="col-sm-2 control-label text-right">5.4 Recoverability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                       </div>
                   </div>
                </div>


                <div class="form-element">
                  <div class="col-md-13 padding-0">
                    <div class="col-md-13">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">

                        <h4>6. Security</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">
                          <div class="col-md-12">

                          	<div class="form-group"><label class="col-sm-2 control-label text-right">6.1 Confidentiality</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">6.2 Integrity</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">6.3 Non-repudiation</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                           <div class="form-group"><label class="col-sm-2 control-label text-right">6.4 Authenticity</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                           <div class="form-group"><label class="col-sm-2 control-label text-right">6.5 Accountability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                       </div>
                   </div>
                </div>


                <div class="form-element">
                  <div class="col-md-13 padding-0">
                    <div class="col-md-13">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">

                        <h4>7. Maintainability </h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">
                          <div class="col-md-12">

                          	<div class="form-group"><label class="col-sm-2 control-label text-right">7.1 Modularity </label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">7.2 Reusability </label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">7.3 Analysability </label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                           <div class="form-group"><label class="col-sm-2 control-label text-right">7.4 Modifiability </label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                           <div class="form-group"><label class="col-sm-2 control-label text-right">7.5 Testability </label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                       </div>
                   </div>
                </div>


                <div class="form-element">
                  <div class="col-md-13 padding-0">
                    <div class="col-md-13">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">

                        <h4>8. Portability </h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">
                          <div class="col-md-12">

                          	<div class="form-group"><label class="col-sm-2 control-label text-right">8.1 Adaptability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">8.2 Installability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">8.3 Replaceability</label>
                              <div class="col-sm-10"><input type="text" class="form-control"></div>
                           </div>
                       </div>
                   </div>
                </div>


                

